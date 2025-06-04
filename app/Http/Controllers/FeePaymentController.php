<?php

namespace App\Http\Controllers;

use App\Models\FeePayment;
use App\Mail\FeeReminder;
use Illuminate\Support\Facades\Mail;
use App\Models\StudentList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class FeePaymentController extends Controller
{
    /**
     * Display the fee payment page for parents or admin.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $selectedMonth = $request->input('month'); // format: 01, 02, ..., 12
        $selectedYear = $request->input('year');   // format: 2023, 2024, etc.

        $isAdmin = $user->role === 'admin';

        // Query students
        $students = StudentList::with([
            'subjects' => function ($query) {
                $query->withPivot('created_at');
            },
            'feePayments',
            'parent'
        ]);

        if (!$isAdmin) {
            $parentId = $user->parentInfo->id;
            $students->where('parent_id', $parentId);
        }

        $students = $students->get();

        // Filter by month/year if requested
        if ($selectedMonth || $selectedYear) {
            foreach ($students as $student) {
                $filteredSubjects = $student->subjects->filter(function ($subject) use ($selectedMonth, $selectedYear) {
                    $createdAt = optional($subject->pivot)->created_at;

                    if (!$createdAt) {
                        return false;
                    }

                    $createdAt = Carbon::parse($createdAt);

                    $matchesMonth = $selectedMonth ? $createdAt->format('m') === str_pad($selectedMonth, 2, '0', STR_PAD_LEFT) : true;
                    $matchesYear = $selectedYear ? $createdAt->format('Y') === $selectedYear : true;

                    return $matchesMonth && $matchesYear;
                });

                $student->setRelation('subjects', $filteredSubjects);
            }

            // Optionally remove students with no matching subjects
            $students = $students->filter(fn($student) => $student->subjects->isNotEmpty());
        }

        $view = $isAdmin ? 'fee_payments.admin-index' : 'fee_payments.index';
        return view($view, compact('students', 'selectedMonth', 'selectedYear'));
    }

    /**
     * Initiate a payment using Stripe.
     */
    public function pay(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:student_lists,id',
            'amount' => 'required|numeric|min:1',
        ]);

        $student = StudentList::findOrFail($request->student_id);
        $parentId = Auth::user()->parentInfo->id;

        // Security: Ensure parent owns this student
        if ($student->parent_id !== $parentId) {
            abort(403, 'Unauthorized payment attempt.');
        }

        Stripe::setApiKey(config('services.stripe.secret'));

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'myr',
                    'product_data' => [
                        'name' => "Fee Payment for {$student->name}",
                    ],
                    'unit_amount' => $request->amount * 100,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('fee_payments.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('fee_payments.index'),
            'metadata' => [
                'student_id' => $student->id,
                'parent_id' => $parentId,
            ],
        ]);

        // Record pending payment
        FeePayment::create([
            'student_id' => $student->id,
            'parent_id' => $parentId,
            'amount' => $request->amount,
            'status' => 'pending',
            'stripe_payment_id' => $session->id,
        ]);

        return redirect($session->url);
    }

    /**
     * Handle Stripe payment success and update payment status.
     */
    public function success(Request $request)
    {
        $sessionId = $request->get('session_id');

        if (!$sessionId) {
            return redirect()->route('fee_payments.index')->with('error', 'Invalid session.');
        }

        $payment = FeePayment::where('stripe_payment_id', $sessionId)->firstOrFail();

        if ($payment->status !== 'paid') {
            $payment->update(['status' => 'paid']);
        }

        return redirect()->route('fee_payments.index')->with('success', 'Payment successful!');
    }

    /**
     * Admin view of all fee payments.
     */

public function adminView(Request $request)
{
    $selectedMonth = $request->input('month');
    $selectedYear = $request->input('year');
    $selectedLevel = $request->input('level');

    $students = StudentList::with([
        'subjects' => function ($query) {
            $query->withPivot('created_at');
        },
        'feePayments'
    ])
    ->when($selectedLevel, function ($query) use ($selectedLevel) {
        $query->where('level', $selectedLevel);
    })
    ->get()
    ->map(function ($student) use ($selectedMonth, $selectedYear) {
        // Filter enrollments by month/year
        $filteredSubjects = $student->subjects->filter(function ($subject) use ($selectedMonth, $selectedYear) {
            $createdAt = optional($subject->pivot)->created_at;

            if (!$createdAt) return false;

            $createdAt = \Carbon\Carbon::parse($createdAt);

            $matchesMonth = $selectedMonth ? $createdAt->format('m') === str_pad($selectedMonth, 2, '0', STR_PAD_LEFT) : true;
            $matchesYear = $selectedYear ? $createdAt->format('Y') === $selectedYear : true;

            return $matchesMonth && $matchesYear;
        });

        $student->setRelation('subjects', $filteredSubjects);

        // Filter fee payments by month/year
        $filteredPayments = $student->feePayments->filter(function ($payment) use ($selectedMonth, $selectedYear) {
            $createdAt = \Carbon\Carbon::parse($payment->created_at);

            $matchesMonth = $selectedMonth ? $createdAt->format('m') === str_pad($selectedMonth, 2, '0', STR_PAD_LEFT) : true;
            $matchesYear = $selectedYear ? $createdAt->format('Y') === $selectedYear : true;

            return $matchesMonth && $matchesYear;
        });

        $student->totalPaid = $filteredPayments->where('status', 'paid')->sum('amount');
        $student->payments = $filteredPayments;

        return $student;
    })
    ->filter(fn($student) => $student->subjects->isNotEmpty());

    return view('fee_payments.admin-view', compact('students', 'selectedMonth', 'selectedYear', 'selectedLevel'));
}

    /**
     * Admin sends reminder to unpaid students' parents (stubbed).
     */
    public function sendReminder(StudentList $student)
{
    $parent = $student->parent;

    if ($parent && $parent->email) {
        Mail::to($parent->email)->send(new FeeReminder($student));

        return back()->with('success', 'Reminder email sent to parent: ' . $parent->email);
    }

    return back()->with('error', 'Parent contact not found.');
}

public function exportPdf()
{
    $students = StudentList::with(['enrollments.subject', 'enrollments.feePayments' => function ($query) {
        $query->where('status', 'paid');
    }])->get();

    $pdf = Pdf::loadView('fee_payments.pdf', compact('students'));

    return $pdf->download('fee_payments_report.pdf');
}
}
