<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold text-gray-800">
                {{ __('Student Payment Details') }} - {{ $student->name }}
            </h2>
            <a href="{{ route('fee_payments.admin_view') }}"
               class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                ← Back to Student List
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white p-6 shadow rounded">
                <h3 class="text-lg font-semibold mb-4">Student Information</h3>
                <p><strong>Name:</strong> {{ $student->name }}</p>
                <p><strong>IC:</strong> {{ $student->ic }}</p>
                <p><strong>Level:</strong> {{ $student->level }}</p>
                <p><strong>Phone:</strong> {{ $student->phone }}</p>
                <p><strong>Parent:</strong> {{ $student->parent->user->name ?? 'N/A' }}</p>
            </div>

            <div class="bg-white p-6 shadow rounded">
                <h3 class="text-lg font-semibold mb-4">Subject Enrollment</h3>
                <ul class="list-disc ml-5">
                    @foreach ($student->subjects as $subject)
                        <li>{{ $subject->name }} ({{ $subject->level }})</li>
                    @endforeach
                </ul>
            </div>

            <div class="bg-white p-6 shadow rounded">
                <h3 class="text-lg font-semibold mb-4">Fee Payment Records</h3>
                @if($student->feePayments->count() > 0)
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left">Amount</th>
                                <th class="px-4 py-2 text-left">Status</th>
                                <th class="px-4 py-2 text-left">Date</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($student->feePayments as $payment)
                                <tr>
                                    <td class="px-4 py-2">RM {{ number_format($payment->amount, 2) }}</td>
                                    <td class="px-4 py-2 capitalize">{{ $payment->status }}</td>
                                    <td class="px-4 py-2">{{ \Carbon\Carbon::parse($payment->created_at)->format('d M Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p>No payment records found.</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
