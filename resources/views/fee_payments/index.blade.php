<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-grey leading-tight bg-blue-200 px-4 py-2 rounded">
                {{ __('Fee Payments') }}
            </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h2 class="text-2xl font-bold">Fee List</h2>
            {{-- Enhanced Filter Section --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-8">
                <div class="flex items-center mb-4">
                    <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                    </svg>
                    <h3 class="text-lg font-semibold text-gray-800">Filter Payments</h3>
                </div>
                
                <form method="GET" action="{{ route('fee_payments.index') }}" class="grid grid-cols-1 md:grid-cols-3 gap-6 items-end">
                    <div class="space-y-2">
                        <label for="month" class="block text-sm font-medium text-gray-700">Month</label>
                        <div class="relative">
                            <select name="month" id="month" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 appearance-none bg-white">
                                <option value="">All Months</option>
                                @foreach(range(1, 12) as $m)
                                    <option value="{{ str_pad($m, 2, '0', STR_PAD_LEFT) }}"
                                        {{ request('month') == str_pad($m, 2, '0', STR_PAD_LEFT) ? 'selected' : '' }}>
                                        {{ date('F', mktime(0, 0, 0, $m, 1)) }}
                                    </option>
                                @endforeach
                            </select>
                            <svg class="absolute right-3 top-1/2 transform -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label for="year" class="block text-sm font-medium text-gray-700">Year</label>
                        <div class="relative">
                            <select name="year" id="year" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 appearance-none bg-white">
                                <option value="">All Years</option>
                                @foreach(range(date('Y'), date('Y') - 5) as $y)
                                    <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>
                                        {{ $y }}
                                    </option>
                                @endforeach
                            </select>
                            <svg class="absolute right-3 top-1/2 transform -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>

                    <div class="flex space-x-3">
                        <button type="submit" class="flex-1 px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-semibold rounded-lg hover:from-blue-700 hover:to-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transform transition-all duration-200 hover:scale-105 flex items-center justify-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            Apply Filter
                        </button>
                        @if(request()->hasAny(['month', 'year']))
                            <a href="{{ route('fee_payments.index') }}" class="px-4 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-all duration-200 flex items-center justify-center">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            {{-- Enhanced Payment Table --}}
            @if($students->isEmpty())
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-12 text-center">
                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9.5a2.121 2.121 0 00-3-3L12 4.5m0 0L7.5 9M15 13l-3 3m0 0l-3-3m3 3V10"></path>
                    </svg>
                    <h3 class="text-lg font-semibold text-gray-700 mb-2">No Students Found</h3>
                    <p class="text-gray-500">Try adjusting your filter criteria to see payment records.</p>
                </div>
            @else
                <div class="space-y-6">
                    @foreach($students as $student)
                        @php
                            $totalSubjects = $student->subjects->count();
                            $paidSubjects = 0;
                            $unpaidSubjects = [];
                            $totalUnpaidAmount = 0;
                            
                            foreach($student->subjects as $subject) {
                                $pivot = $subject->pivot ?? null;
                                $enrolledAt = $pivot?->created_at;
                                $payment = $student->feePayments
                                    ->where('student_id', $student->id)
                                    ->where('status', 'paid')
                                    ->where('created_at', '>=', $enrolledAt)
                                    ->first();
                                    
                                if($payment) {
                                    $paidSubjects++;
                                } else {
                                    $unpaidSubjects[] = $subject;
                                    $totalUnpaidAmount += $subject->price ?? 0;
                                }
                            }
                            $paymentRate = $totalSubjects > 0 ? ($paidSubjects / $totalSubjects) * 100 : 0;
                        @endphp
                        
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow duration-200">
                            <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white font-bold text-lg">
                                            {{ strtoupper(substr($student->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <h3 class="text-xl font-bold text-gray-800">{{ $student->name }}</h3>
                                            <p class="text-sm text-gray-600">Student ID: {{ $student->id }}</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <div class="flex items-center space-x-2">
                                            <span class="text-sm text-gray-600">Payment Status:</span>
                                            <div class="flex items-center space-x-1">
                                                <div class="w-16 h-2 bg-gray-200 rounded-full overflow-hidden">
                                                    <div class="h-full bg-gradient-to-r from-green-400 to-green-600 rounded-full transition-all duration-300" style="width: {{ $paymentRate }}%"></div>
                                                </div>
                                                <span class="text-sm font-semibold {{ $paymentRate == 100 ? 'text-green-600' : 'text-orange-600' }}">
                                                    {{ round($paymentRate) }}%
                                                </span>
                                            </div>
                                        </div>
                                        @if($totalUnpaidAmount > 0)
                                            <div class="mt-2">
                                                <span class="text-sm text-gray-600">Outstanding Balance:</span>
                                                <span class="text-lg font-bold text-red-600 ml-1">RM {{ number_format($totalUnpaidAmount, 2) }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="p-6">
                                @if($student->subjects->isEmpty())
                                    <div class="text-center py-8">
                                        <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                        </svg>
                                        <p class="text-gray-500 font-medium">No subjects enrolled for selected period</p>
                                    </div>
                                @else
                                    <div class="overflow-x-auto">
                                        <table class="w-full">
                                            <thead>
                                                <tr class="border-b border-gray-200">
                                                    <th class="text-left py-3 px-4 font-semibold text-gray-700">Subject</th>
                                                    <th class="text-left py-3 px-4 font-semibold text-gray-700">Enrolled Date</th>
                                                    <th class="text-left py-3 px-4 font-semibold text-gray-700">Amount</th>
                                                    <th class="text-center py-3 px-4 font-semibold text-gray-700">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-gray-100">
                                                @foreach($student->subjects as $subject)
                                                    @php
                                                        $pivot = $subject->pivot ?? null;
                                                        $enrolledAt = $pivot?->created_at;
                                                        $amount = $subject->price ?? 0;

                                                        $payment = $student->feePayments
                                                            ->where('student_id', $student->id)
                                                            ->where('status', 'paid')
                                                            ->where('created_at', '>=', $enrolledAt)
                                                            ->first();
                                                    @endphp
                                                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                                                        <td class="py-4 px-4">
                                                            <div class="flex items-center space-x-3">
                                                                <div class="w-8 h-8 bg-gradient-to-br from-indigo-400 to-purple-500 rounded-lg flex items-center justify-center text-white text-xs font-bold">
                                                                    {{ strtoupper(substr($subject->name, 0, 2)) }}
                                                                </div>
                                                                <span class="font-medium text-gray-900">{{ $subject->name }}</span>
                                                            </div>
                                                        </td>
                                                        <td class="py-4 px-4 text-gray-600">
                                                            @if($enrolledAt)
                                                                <div class="flex items-center space-x-2">
                                                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                                    </svg>
                                                                    <span>{{ $enrolledAt->format('M d, Y') }}</span>
                                                                </div>
                                                            @else
                                                                <span class="text-gray-400">N/A</span>
                                                            @endif
                                                        </td>
                                                        <td class="py-4 px-4">
                                                            <span class="text-lg font-bold text-gray-900">RM {{ number_format($amount, 2) }}</span>
                                                        </td>
                                                        <td class="py-4 px-4 text-center">
                                                            @if($payment)
                                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                                    </svg>
                                                                    Paid
                                                                </span>
                                                            @else
                                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">
                                                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                                                    </svg>
                                                                    Pending
                                                                </span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                    {{-- Single Payment Button Section --}}
                                    @if($totalUnpaidAmount > 0)
                                        <div class="mt-6 pt-6 border-t border-gray-200">
                                            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg p-6">
                                                <div class="flex items-center justify-between">
                                                    <div>
                                                        <h4 class="text-lg font-semibold text-gray-800 mb-2">Outstanding Payment</h4>
                                                        <p class="text-sm text-gray-600 mb-2">
                                                            {{ count($unpaidSubjects) }} subject{{ count($unpaidSubjects) > 1 ? 's' : '' }} pending payment:
                                                        </p>
                                                        <div class="flex flex-wrap gap-2 mb-3">
                                                            @foreach($unpaidSubjects as $unpaidSubject)
                                                                <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-orange-100 text-orange-800">
                                                                    {{ $unpaidSubject->name }} - RM {{ number_format($unpaidSubject->price ?? 0, 2) }}
                                                                </span>
                                                            @endforeach
                                                        </div>
                                                        <div class="text-2xl font-bold text-gray-900">
                                                            Total: <span class="text-red-600">RM {{ number_format($totalUnpaidAmount, 2) }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="ml-6">
                                                        @if(auth()->user()->role === 'parents')
                                                            <form method="POST" action="{{ route('fee_payments.pay') }}" class="inline-block">
                                                                @csrf
                                                                <input type="hidden" name="student_id" value="{{ $student->id }}">
                                                                <input type="hidden" name="amount" value="{{ $totalUnpaidAmount }}">
                                                                <button type="submit" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-green-500 to-green-600 text-white text-lg font-semibold rounded-lg hover:from-green-600 hover:to-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transform transition-all duration-200 hover:scale-105 shadow-lg">
                                                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                                                    </svg>
                                                                    Pay All Outstanding
                                                                </button>
                                                            </form>
                                                        @elseif(auth()->user()->role === 'admin')
                                                            <form method="POST" action="{{ route('fee_payments.reminder', $student->id) }}" class="inline-block">
                                                                @csrf
                                                                <button type="submit" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-amber-500 to-orange-500 text-white text-lg font-semibold rounded-lg hover:from-amber-600 hover:to-orange-600 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 transform transition-all duration-200 hover:scale-105 shadow-lg">
                                                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5-5-5h5v-12"></path>
                                                                    </svg>
                                                                    Send Payment Reminder
                                                                </button>
                                                            </form>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <div class="mt-6 pt-6 border-t border-gray-200">
                                            <div class="bg-gradient-to-r from-green-50 to-emerald-50 rounded-lg p-6 text-center">
                                                <svg class="w-12 h-12 text-green-500 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                <h4 class="text-lg font-semibold text-green-800 mb-2">All Payments Complete</h4>
                                                <p class="text-green-600">This student has paid for all enrolled subjects.</p>
                                            </div>
                                        </div>
                                    @endif
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <style>
        .form-select {
            background-image: none;
        }
        
        select:focus {
            outline: none;
        }
        
        .hover\:scale-105:hover {
            transform: scale(1.05);
        }
    </style>
</x-app-layout>