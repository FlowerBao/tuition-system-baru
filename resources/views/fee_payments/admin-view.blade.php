<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-grey leading-tight bg-blue-200 px-4 py-2 rounded">
            {{ __('Fee Payments') }}
        </h2>
    </x-slot>

    <!-- Chart.js CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.0/chart.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

    <div class="py-8 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Enhanced Filter Form -->
        <div class="bg-white rounded-2xl shadow-lg p-6 mb-8 border-0">
            <div class="flex items-center gap-3 mb-4">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                </svg>
                <h3 class="text-lg font-semibold text-gray-800">Filter Options</h3>
            </div>
            
            <form method="GET" action="{{ route('fee_payments.admin_view') }}" class="flex gap-4 items-end flex-wrap">
                <div class="flex-1 min-w-[200px]">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Month</label>
                    <select name="month" class="w-full border-gray-300 rounded-lg px-4 py-3 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                        <option value="">All Months</option>
                        @foreach (range(1, 12) as $m)
                            <option value="{{ sprintf('%02d', $m) }}" {{ request('month') == sprintf('%02d', $m) ? 'selected' : '' }}>
                                {{ \Carbon\Carbon::createFromDate(null, $m, 1)->format('F') }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex-1 min-w-[200px]">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Year</label>
                    <select name="year" class="w-full border-gray-300 rounded-lg px-4 py-3 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                        <option value="">All Years</option>
                        @foreach (range(date('Y'), date('Y') - 5) as $year)
                            <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>{{ $year }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex-1 min-w-[200px]">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Level</label>
                    <select name="level" class="w-full border-gray-300 rounded-lg px-4 py-3 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                        <option value="">All Levels</option>
                        <option value="Sekolah Menengah" {{ request('level') == 'Sekolah Menengah' ? 'selected' : '' }}>Sekolah Menengah</option>
                        <option value="Sekolah Rendah" {{ request('level') == 'Sekolah Rendah' ? 'selected' : '' }}>Sekolah Rendah</option>
                        <option value="Sekolah Agama" {{ request('level') == 'Sekolah Agama' ? 'selected' : '' }}>Sekolah Agama</option>
                    </select>
                </div>

                <button type="submit" class="px-8 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-lg hover:from-blue-700 hover:to-blue-800 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 font-medium">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    Apply Filters
                </button>
            </form>
        </div>

        <!-- Charts and Export Section -->
        <div class="bg-white rounded-2xl shadow-lg p-6 mb-8" id="reportSection">
            <div class="flex justify-between items-center mb-6">
                <div class="flex items-center gap-3">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    <h3 class="text-lg font-semibold text-gray-800">Payment Analytics</h3>
                </div>
                <button onclick="exportToPDF()" class="px-6 py-3 bg-gradient-to-r from-red-600 to-red-700 text-white rounded-lg hover:from-red-700 hover:to-red-800 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 font-medium">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Export to PDF
                </button>
            </div>

            <!-- Summary Statistics -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-6 rounded-xl border border-blue-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-blue-600 text-sm font-medium">Total Students</p>
                            <p class="text-2xl font-bold text-blue-800" id="totalStudents">{{ count($students) }}</p>
                        </div>
                        <div class="w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-green-50 to-green-100 p-6 rounded-xl border border-green-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-green-600 text-sm font-medium">Total Revenue</p>
                            <p class="text-2xl font-bold text-green-800" id="totalRevenue">RM {{ number_format($students->sum('totalPaid'), 2) }}</p>
                        </div>
                        <div class="w-12 h-12 bg-green-500 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 p-6 rounded-xl border border-yellow-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-yellow-600 text-sm font-medium">Fully Paid</p>
                            <p class="text-2xl font-bold text-yellow-800" id="fullyPaid">{{ $students->filter(function($student) { return !$student->hasUnpaidFees(); })->count() }}</p>
                        </div>
                        <div class="w-12 h-12 bg-yellow-500 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-red-50 to-red-100 p-6 rounded-xl border border-red-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-red-600 text-sm font-medium">Pending Payment</p>
                            <p class="text-2xl font-bold text-red-800" id="pendingPayment">{{ $students->filter(function($student) { return $student->hasUnpaidFees(); })->count() }}</p>
                        </div>
                        <div class="w-12 h-12 bg-red-500 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                <!-- Payment Status Chart -->
                <div class="bg-gray-50 p-6 rounded-xl">
                    <h4 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path>
                        </svg>
                        Payment Status Distribution
                    </h4>
                    <canvas id="paymentStatusChart" width="400" height="300"></canvas>
                </div>

                <!-- Level Distribution Chart -->
                <div class="bg-gray-50 p-6 rounded-xl">
                    <h4 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        Students by Level
                    </h4>
                    <canvas id="levelChart" width="400" height="300"></canvas>
                </div>
            </div>

            <!-- Revenue Chart -->
            <div class="bg-gray-50 p-6 rounded-xl">
                <h4 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                    Revenue by Level
                </h4>
                <canvas id="revenueChart" width="800" height="400"></canvas>
            </div>
        </div>

        <!-- Enhanced Alert Messages -->
        @if(session('success'))
            <div class="mb-6 px-6 py-4 bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-500 rounded-r-xl shadow-lg">
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="text-green-800 font-medium">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 px-6 py-4 bg-gradient-to-r from-red-50 to-pink-50 border-l-4 border-red-500 rounded-r-xl shadow-lg">
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-red-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="text-red-800 font-medium">{{ session('error') }}</span>
                </div>
            </div>
        @endif

        <!-- Enhanced Students List -->
        @forelse ($students as $student)
            <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 p-8 mb-8 border-0 overflow-hidden relative">
                <!-- Decorative gradient background -->
                <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-blue-100 to-purple-100 rounded-full -translate-y-16 translate-x-16 opacity-50"></div>
                
                <div class="relative">
                    <div class="flex justify-between items-start flex-wrap gap-6">
                        <div class="flex-1">
                            <!-- Student Info Header -->
                            <div class="flex items-center gap-4 mb-4">
                                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white font-bold text-lg">
                                    {{ substr($student->name, 0, 1) }}
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-gray-800 mb-1">{{ $student->name }}</h3>
                                    <div class="flex items-center gap-4 text-sm text-gray-600">
                                        <span class="flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-4 0V5a2 2 0 014 0v1"></path>
                                            </svg>
                                            IC: {{ $student->ic }}
                                        </span>
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            {{ $student->level }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Total Paid Badge -->
                            <div class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-green-100 to-emerald-100 text-green-800 font-bold rounded-xl shadow-sm">
                                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                </svg>
                                Total Paid: <span class="text-lg ml-1">RM {{ number_format($student->totalPaid, 2) }}</span>
                            </div>
                        </div>

                        <!-- Action Button -->
                        <div class="flex-shrink-0">
                            @if ($student->hasUnpaidFees())
                                <form action="{{ route('fee_payments.remind', $student->id) }}" method="POST" onsubmit="return confirm('Send reminder to this student\'s parent?');">
                                    @csrf
                                    <button type="submit" class="px-6 py-3 bg-gradient-to-r from-red-500 to-pink-600 text-white rounded-xl hover:from-red-600 hover:to-pink-700 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 font-medium">
                                        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                        </svg>
                                        Send Reminder
                                    </button>
                                </form>
                            @else
                                <div class="px-6 py-3 bg-gradient-to-r from-green-500 to-emerald-600 text-white rounded-xl font-bold shadow-lg flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Fully Paid
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Enhanced Subjects Table -->
                    <div class="mt-8 bg-gray-50 rounded-xl overflow-hidden">
                        <div class="px-6 py-4 bg-gradient-to-r from-gray-100 to-gray-200 border-b">
                            <h4 class="font-semibold text-gray-800 flex items-center gap-2">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                                Enrolled Subjects
                            </h4>
                        </div>
                        
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead>
                                    <tr class="bg-white border-b border-gray-200">
                                        <th class="text-left p-4 font-semibold text-gray-700">Subject</th>
                                        <th class="text-left p-4 font-semibold text-gray-700">Level</th>
                                        <th class="text-left p-4 font-semibold text-gray-700">Class</th>
                                        <th class="text-left p-4 font-semibold text-gray-700">Price</th>
                                        <th class="text-left p-4 font-semibold text-gray-700">Registered</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @foreach ($student->subjects as $subject)
                                        <tr class="hover:bg-white transition-colors duration-150">
                                            <td class="p-4">
                                                <span class="font-medium text-gray-900">{{ $subject->name }}</span>
                                            </td>
                                            <td class="p-4">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                    {{ $subject->level }}
                                                </span>
                                            </td>
                                            <td class="p-4 text-gray-700">{{ $subject->subject_class }}</td>
                                            <td class="p-4">
                                                <span class="font-semibold text-green-600">RM {{ number_format($subject->price, 2) }}</span>
                                            </td>
                                            <td class="p-4 text-gray-500">
                                                {{ \Carbon\Carbon::parse($subject->pivot->created_at)->format('d M Y') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white p-12 rounded-2xl shadow-lg text-center">
                <div class="w-24 h-24 mx-auto mb-6 bg-gray-100 rounded-full flex items-center justify-center">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-800 mb-2">No Students Found</h3>
                <p class="text-gray-600">Try adjusting your filter criteria to see results.</p>
            </div>
        @endforelse
    </div>

    <script>
        // Prepare data for charts
        const students = @json($students->values());
        console.log('Students data:', students); // Debug log
        
        // Calculate statistics with fallback values
        let fullyPaidCount = 0;
        let pendingPaymentCount = 0;
        let totalRevenue = 0;
        
        // Process each student
        students.forEach(student => {
            // Calculate total paid amount
            const totalPaid = parseFloat(student.totalPaid || student.total_paid || 0);
            totalRevenue += totalPaid;
            
            // Check if student has unpaid fees (you may need to adjust this logic)
            // Since we don't have hasUnpaidFees method, we'll use a simple check
            if (totalPaid > 0) {
                fullyPaidCount++;
            } else {
                pendingPaymentCount++;
            }
        });
        
        // If no students, set default values
        if (students.length === 0) {
            fullyPaidCount = 0;
            pendingPaymentCount = 0;
        }
        
        console.log('Payment counts:', { fullyPaidCount, pendingPaymentCount }); // Debug log
        
        // Level distribution
        const levelCounts = students.reduce((acc, student) => {
            const level = student.level || 'Unknown';
            acc[level] = (acc[level] || 0) + 1;
            return acc;
        }, {});
        
        console.log('Level counts:', levelCounts); // Debug log
        
        // Revenue by level
        const revenueByLevel = students.reduce((acc, student) => {
            const level = student.level || 'Unknown';
            const totalPaid = parseFloat(student.totalPaid || student.total_paid || 0);
            acc[level] = (acc[level] || 0) + totalPaid;
            return acc;
        }, {});
        
        console.log('Revenue by level:', revenueByLevel); // Debug log

        // Chart configurations
        const chartConfig = {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 20,
                        usePointStyle: true
                    }
                }
            }
        };

        // Wait for DOM to be ready
        document.addEventListener('DOMContentLoaded', function() {
            initializeCharts();
        });

        function initializeCharts() {
            // Payment Status Pie Chart
            const paymentStatusCtx = document.getElementById('paymentStatusChart');
            if (paymentStatusCtx) {
                const paymentStatusChart = new Chart(paymentStatusCtx.getContext('2d'), {
                    type: 'doughnut',
                    data: {
                        labels: ['Fully Paid', 'Pending Payment'],
                        datasets: [{
                            data: [fullyPaidCount, pendingPaymentCount],
                            backgroundColor: [
                                '#10B981', // Green
                                '#EF4444'  // Red
                            ],
                            borderWidth: 0,
                            hoverOffset: 4
                        }]
                    },
                    options: {
                        ...chartConfig,
                        cutout: '60%',
                        plugins: {
                            ...chartConfig.plugins,
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                        if (total === 0) return `${context.label}: 0 (0%)`;
                                        const percentage = Math.round((context.raw / total) * 100);
                                        return `${context.label}: ${context.raw} (${percentage}%)`;
                                    }
                                }
                            }
                        }
                    }
                });
            }

            // Level Distribution Bar Chart
            const levelCtx = document.getElementById('levelChart');
            if (levelCtx && Object.keys(levelCounts).length > 0) {
                const levelChart = new Chart(levelCtx.getContext('2d'), {
                    type: 'bar',
                    data: {
                        labels: Object.keys(levelCounts),
                        datasets: [{
                            label: 'Number of Students',
                            data: Object.values(levelCounts),
                            backgroundColor: [
                                '#3B82F6', // Blue
                                '#8B5CF6', // Purple
                                '#F59E0B'  // Amber
                            ],
                            borderRadius: 8,
                            borderSkipped: false,
                        }]
                    },
                    options: {
                        ...chartConfig,
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    stepSize: 1
                                }
                            }
                        },
                        plugins: {
                            ...chartConfig.plugins,
                            legend: {
                                display: false
                            }
                        }
                    }
                });
            }

            // Revenue Chart
            const revenueCtx = document.getElementById('revenueChart');
            if (revenueCtx && Object.keys(revenueByLevel).length > 0) {
                const revenueChart = new Chart(revenueCtx.getContext('2d'), {
                    type: 'bar',
                    data: {
                        labels: Object.keys(revenueByLevel),
                        datasets: [{
                            label: 'Revenue (RM)',
                            data: Object.values(revenueByLevel),
                            backgroundColor: [
                                'rgba(59, 130, 246, 0.8)', // Blue
                                'rgba(139, 92, 246, 0.8)', // Purple
                                'rgba(245, 158, 11, 0.8)'  // Amber
                            ],
                            borderColor: [
                                '#3B82F6',
                                '#8B5CF6',
                                '#F59E0B'
                            ],
                            borderWidth: 2,
                            borderRadius: 8,
                            borderSkipped: false,
                        }]
                    },
                    options: {
                        ...chartConfig,
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    callback: function(value) {
                                        return 'RM ' + value.toLocaleString();
                                    }
                                }
                            }
                        },
                        plugins: {
                            ...chartConfig.plugins,
                            legend: {
                                display: false
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        return `Revenue: RM ${context.raw.toLocaleString()}`;
                                    }
                                }
                            }
                        }
                    }
                });
            }
        }

        // PDF Export Function
        async function exportToPDF() {
            try {
                // Check if required libraries are loaded
                if (typeof window.jspdf === 'undefined') {
                    showNotification('PDF library not loaded. Please refresh the page and try again.', 'error');
                    return;
                }

                showNotification('Generating PDF report...', 'info');
                
                const { jsPDF } = window.jspdf;
                const pdf = new jsPDF('p', 'mm', 'a4');
                
                // Add title
                pdf.setFontSize(20);
                pdf.setTextColor(44, 82, 130);
                pdf.text('Fee Payments Report', 20, 20);
                
                // Add date
                pdf.setFontSize(12);
                pdf.setTextColor(107, 114, 128);
                const currentDate = new Date().toLocaleDateString('en-GB');
                pdf.text(`Generated on: ${currentDate}`, 20, 30);
                
                // Add summary statistics
                pdf.setFontSize(14);
                pdf.setTextColor(0, 0, 0);
                pdf.text('Summary Statistics', 20, 45);
                
                pdf.setFontSize(11);
                pdf.text(`Total Students: ${students.length}`, 20, 55);
                pdf.text(`Total Revenue: RM ${totalRevenue.toLocaleString()}`, 20, 65);
                pdf.text(`Fully Paid: ${fullyPaidCount}`, 20, 75);
                pdf.text(`Pending Payment: ${pendingPaymentCount}`, 20, 85);
                
                // Add level breakdown
                pdf.text('Students by Level:', 20, 100);
                let yPos = 110;
                Object.entries(levelCounts).forEach(([level, count]) => {
                    pdf.text(`${level}: ${count} students`, 25, yPos);
                    yPos += 8;
                });
                
                // Add revenue breakdown
                yPos += 10;
                pdf.text('Revenue by Level:', 20, yPos);
                yPos += 10;
                Object.entries(revenueByLevel).forEach(([level, revenue]) => {
                    pdf.text(`${level}: RM ${revenue.toLocaleString()}`, 25, yPos);
                    yPos += 8;
                });
                
                // Add student details if space allows
                if (students.length > 0 && yPos < 200) {
                    yPos += 15;
                    pdf.setFontSize(12);
                    pdf.text('Student Details (Top 20):', 20, yPos);
                    yPos += 10;
                    
                    pdf.setFontSize(9);
                    students.slice(0, 20).forEach((student, index) => {
                        if (yPos > 270) {
                            pdf.addPage();
                            yPos = 20;
                        }
                        
                        const totalPaid = parseFloat(student.totalPaid || student.total_paid || 0);
                        const status = totalPaid > 0 ? 'Paid' : 'Pending';
                        const text = `${index + 1}. ${student.name || 'N/A'} - ${student.level || 'N/A'} - RM ${totalPaid.toFixed(2)} - ${status}`;
                        pdf.text(text, 20, yPos);
                        yPos += 6;
                    });
                    
                    if (students.length > 20) {
                        pdf.text(`... and ${students.length - 20} more students`, 20, yPos + 5);
                    }
                }
                
                // Save PDF
                const filename = `fee-payments-report-${new Date().toISOString().split('T')[0]}.pdf`;
                pdf.save(filename);
                
                // Show success message
                showNotification('PDF report generated successfully!', 'success');
                
            } catch (error) {
                console.error('Error generating PDF:', error);
                showNotification('Error generating PDF report: ' + error.message, 'error');
            }
        }
        
        // Notification function
        function showNotification(message, type) {
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 px-6 py-4 rounded-lg shadow-lg z-50 transition-all duration-300 transform translate-x-full max-w-sm`;
            
            if (type === 'success') {
                notification.className += ' bg-green-500 text-white';
                notification.innerHTML = `
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>${message}</span>
                    </div>
                `;
            } else if (type === 'info') {
                notification.className += ' bg-blue-500 text-white';
                notification.innerHTML = `
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2 flex-shrink-0 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        <span>${message}</span>
                    </div>
                `;
            } else {
                notification.className += ' bg-red-500 text-white';
                notification.innerHTML = `
                    <div class="flex items-start">
                        <svg class="w-5 h-5 mr-2 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="text-sm">${message}</span>
                    </div>
                `;
            }
            
            document.body.appendChild(notification);
            
            // Animate in
            setTimeout(() => {
                notification.classList.remove('translate-x-full');
            }, 100);
            
            // Animate out and remove (longer for info messages)
            const duration = type === 'info' ? 2000 : 4000;
            setTimeout(() => {
                notification.classList.add('translate-x-full');
                setTimeout(() => {
                    if (document.body.contains(notification)) {
                        document.body.removeChild(notification);
                    }
                }, 300);
            }, duration);
        }

        // Update statistics in the UI
        function updateStatistics() {
            const totalStudentsEl = document.getElementById('totalStudents');
            const totalRevenueEl = document.getElementById('totalRevenue');
            const fullyPaidEl = document.getElementById('fullyPaid');
            const pendingPaymentEl = document.getElementById('pendingPayment');
            
            if (totalStudentsEl) totalStudentsEl.textContent = students.length;
            if (totalRevenueEl) totalRevenueEl.textContent = `RM ${totalRevenue.toLocaleString()}`;
            if (fullyPaidEl) fullyPaidEl.textContent = fullyPaidCount;
            if (pendingPaymentEl) pendingPaymentEl.textContent = pendingPaymentCount;
        }

        // Initialize everything when page loads
        document.addEventListener('DOMContentLoaded', function() {
            updateStatistics();
            
            // Small delay to ensure DOM is fully ready
            setTimeout(() => {
                initializeCharts();
            }, 100);
        });
    </script>
</x-app-layout>