<x-app-layout>
    <x-slot name="header">  
        <div class="bg-gradient-to-r from-blue-600 to-purple-700 rounded-xl shadow-lg">
            <h2 class="font-semibold text-xl text-grey leading-tight bg-blue-200 px-4 py-2 rounded">
            {{ __('Subject Management') }}
        </h2>
        </div>
    </x-slot>

    @if(session('success'))
    <div class="mb-4 p-4 rounded bg-green-100 text-green-800 border border-green-300">
        {{ session('success') }}
    </div>
    @endif

    {{-- Main Content --}}
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Main Content Card -->
            <div class="bg-white/80 backdrop-blur-sm overflow-hidden shadow-xl rounded-2xl border border-gray-100">
                
                <!-- Header Section -->
                <div class="bg-gradient-to-r from-slate-50 to-blue-50 p-8 border-b border-gray-200">
                    <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
                        <div>
                            <h2 class="text-3xl font-bold text-gray-800 mb-2">Subject Overview</h2>
                            <p class="text-gray-600">Manage and monitor your educational programs</p>
                        </div>
                        <div class="flex flex-wrap gap-3">
                            <a href="{{ route('timetables.create') }}" 
                               class="bg-gradient-to-r from-emerald-500 to-emerald-600 hover:from-emerald-600 hover:to-emerald-700 text-white px-6 py-3 rounded-xl font-medium shadow-lg hover:shadow-xl transition-all duration-300 flex items-center gap-2">
                                <span class="text-lg">➕</span>
                                Register New Subject
                            </a>
                            <button onclick="printReport()" 
                                   class="px-6 py-3 bg-gradient-to-r from-red-600 to-red-700 text-white rounded-lg hover:from-red-700 hover:to-red-800 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 font-medium">
                                <span class="text-lg">🖨️</span>
                                Generate Report
                            </button>
                        </div>
                    </div>
                </div>

                <div class="p-8">
                    <!-- Enhanced Filter Section -->
                    <div class="mb-8">
                        <h3 class="text-xl font-semibold text-gray-800 mb-4 flex items-center gap-2">
                            <span class="text-2xl">🔍</span>
                            Filter Options
                        </h3>
                        <form method="GET" action="{{ route('timetables.index') }}" 
                              class="bg-gradient-to-r from-gray-50 to-blue-50 p-6 rounded-xl border border-gray-200">
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 items-end">
                                <div class="space-y-2">
                                    <label for="level" class="block text-sm font-semibold text-gray-700">Education Level</label>
                                    <select name="level" id="level" 
                                            class="w-full border-2 border-gray-200 rounded-lg px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200">
                                        <option value="">All Levels</option>
                                        @foreach($levels as $levelOption)
                                            <option value="{{ $levelOption }}" {{ request('level') == $levelOption ? 'selected' : '' }}>
                                                {{ $levelOption }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="space-y-2">
                                    <label for="subject_class" class="block text-sm font-semibold text-gray-700">Grade/Form</label>
                                    <select name="subject_class" id="subject_class" 
                                            class="w-full border-2 border-gray-200 rounded-lg px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200">
                                        <option value="">All Classes</option>
                                        @foreach($subjectClasses as $subjectClassOption)
                                            <option value="{{ $subjectClassOption }}" {{ request('subject_class') == $subjectClassOption ? 'selected' : '' }}>
                                                {{ $subjectClassOption }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="flex items-end">
                                    <button type="submit" 
                                            class="w-full bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white px-6 py-3 rounded-lg font-medium shadow-lg hover:shadow-xl transition-all duration-300">
                                        Apply Filters
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Success Message -->
                    @if(session('success'))
                        <div class="bg-gradient-to-r from-emerald-50 to-emerald-100 border-l-4 border-emerald-500 text-emerald-800 px-6 py-4 rounded-r-xl mb-6 shadow-sm">
                            <div class="flex items-center gap-3">
                                <span class="text-2xl">✅</span>
                                <span class="font-medium">{{ session('success') }}</span>
                            </div>
                        </div>
                    @endif

                    <!-- Admin Dashboard Section -->
                    @if (auth()->user()->role === 'admin')
                    <div class="mb-10">
                        <!-- Total Subjects Card -->
                        <div class="bg-gradient-to-br from-blue-500 via-purple-500 to-indigo-600 p-8 rounded-2xl shadow-2xl text-white mb-8 relative overflow-hidden">
                            <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -translate-y-16 translate-x-16"></div>
                            <div class="absolute bottom-0 left-0 w-24 h-24 bg-white/5 rounded-full translate-y-12 -translate-x-12"></div>
                            <div class="relative z-10 text-center">
                                <div class="flex items-center justify-center mb-4">
                                    <span class="text-8xl drop-shadow-lg">📚</span>
                                </div>
                                <h3 class="text-2xl font-bold mb-2">Total Registered Subjects</h3>
                                <p class="text-6xl font-black mb-2 drop-shadow-lg">{{ $totalSubjects }}</p>
                                <p class="text-blue-100 text-lg">Active learning programs</p>
                            </div>
                        </div>

                        <!-- Charts Section -->
                        <div class="mb-10">
                            <h3 class="text-2xl font-bold text-gray-800 mb-6 flex items-center gap-3">
                                <span class="text-3xl">📈</span>
                                Subject Distribution Analytics
                            </h3>
                            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                                <div class="bg-white p-6 rounded-2xl shadow-lg border border-gray-100 hover:shadow-xl transition-shadow duration-300">
                                    <h4 class="text-lg font-bold text-center mb-4 text-gray-800 flex items-center justify-center gap-2">
                                        <span class="text-2xl">🏫</span>
                                        Sekolah Menengah
                                    </h4>
                                    <div class="relative">
                                        <canvas id="chartMenengah" width="300" height="300" class="drop-shadow-sm"></canvas>
                                    </div>
                                </div>
                                <div class="bg-white p-6 rounded-2xl shadow-lg border border-gray-100 hover:shadow-xl transition-shadow duration-300">
                                    <h4 class="text-lg font-bold text-center mb-4 text-gray-800 flex items-center justify-center gap-2">
                                        <span class="text-2xl">🎒</span>
                                        Sekolah Rendah
                                    </h4>
                                    <div class="relative">
                                        <canvas id="chartRendah" width="300" height="300" class="drop-shadow-sm"></canvas>
                                    </div>
                                </div>
                                <div class="bg-white p-6 rounded-2xl shadow-lg border border-gray-100 hover:shadow-xl transition-shadow duration-300">
                                    <h4 class="text-lg font-bold text-center mb-4 text-gray-800 flex items-center justify-center gap-2">
                                        <span class="text-2xl">🕌</span>
                                        Sekolah Agama
                                    </h4>
                                    <div class="relative">
                                        <canvas id="chartAgama" width="300" height="300" class="drop-shadow-sm"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Enhanced Subject Report -->
                        <div id="print-section" class="mb-10">
                            <h3 class="text-2xl font-bold text-gray-800 mb-6 flex items-center gap-3">
                                <span class="text-3xl">📋</span>
                                Subject Enrollment Report
                            </h3>
                            <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100">
                                <div class="overflow-x-auto">
                                    <table class="w-full">
                                        <thead class="bg-gradient-to-r from-slate-700 to-gray-800 text-white">
                                            <tr>
                                                <th class="px-6 py-4 text-left font-semibold">Subject</th>
                                                <th class="px-6 py-4 text-center font-semibold">Level</th>
                                                <th class="px-6 py-4 text-center font-semibold">Grade/Form</th>
                                                <th class="px-6 py-4 text-center font-semibold">Total Students</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-100">
                                            @foreach ($subjectReport as $report)
                                                <tr class="hover:bg-gradient-to-r hover:from-blue-50 hover:to-indigo-50 transition-all duration-200">
                                                    <td class="px-6 py-4 font-medium text-gray-900">{{ $report->subject }}</td>
                                                    <td class="px-6 py-4 text-center">
                                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium">
                                                            {{ $report->level }}
                                                        </span>
                                                    </td>
                                                    <td class="px-6 py-4 text-center">
                                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium">
                                                            {{ $report->subject_class }}
                                                        </span>
                                                    </td>
                                                    <td class="px-6 py-4 text-center">
                                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold">
                                                            {{ $report->student_count }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="mt-6">
                                {{ $subjectReport->links('pagination::tailwind') }}
                            </div>
                        </div>
                    @endif

                    <!-- Enhanced Timetable Section -->
                    <div class="mb-8">
                        <h3 class="text-2xl font-bold text-gray-800 mb-6 flex items-center gap-3">
                            <span class="text-3xl">🗓️</span>
                            Class Timetable
                        </h3>
                        <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100">
                            <div class="overflow-x-auto">
                                <table class="w-full">
                                    <thead class="bg-gradient-to-r from-slate-700 to-gray-800 text-white">
                                        <tr>
                                            <th class="px-6 py-4 text-left font-semibold">Subject</th>
                                            <th class="px-6 py-4 text-center font-semibold">Price</th>
                                            <th class="px-6 py-4 text-center font-semibold">Level</th>
                                            <th class="px-6 py-4 text-center font-semibold">Grade/Form</th>
                                            <th class="px-6 py-4 text-center font-semibold">Day</th>
                                            <th class="px-6 py-4 text-center font-semibold">Time</th>
                                            <th class="px-6 py-4 text-center font-semibold">Classroom</th>
                                            <th class="px-6 py-4 text-center font-semibold">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100">
                                        @forelse($timetableList as $timetable)
                                            <tr class="hover:bg-gradient-to-r hover:from-gray-50 hover:to-blue-50 transition-all duration-200">
                                                <td class="px-6 py-4">
                                                    <div class="font-semibold text-gray-900">{{ $timetable->subject->name }}</div>
                                                </td>
                                                <td class="px-6 py-4 text-center">
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium">
                                                        RM{{ $timetable->subject->price }}
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 text-center">
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium">
                                                        {{ $timetable->subject->level }}
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 text-center">
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium">
                                                        {{ $timetable->subject->subject_class }}
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 text-center">
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium">
                                                        {{ $timetable->day }}
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 text-center">
                                                    <div class="text-sm font-medium text-gray-900">
                                                        {{ $timetable->start_time }} - {{ $timetable->end_time }}
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 text-center">
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium">
                                                        {{ $timetable->classroom_name }}
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 text-center">
                                                    <div class="flex justify-center gap-3">
                                                        <a href="{{ route('timetables.edit', $timetable->id) }}" 
                                                           class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-blue-100 hover:bg-blue-200 text-blue-600 hover:text-blue-700 transition-all duration-200 shadow-sm hover:shadow-md" 
                                                           title="Edit Subject">
                                                            <span class="text-lg">✏️</span>
                                                        </a>
                                                        <form action="{{ route('timetables.destroy', $timetable->id) }}" method="POST" 
                                                              onsubmit="return confirm('Are you sure you want to delete this subject?')" class="inline-block">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" 
                                                                    class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-red-100 hover:bg-red-200 text-red-600 hover:text-red-700 transition-all duration-200 shadow-sm hover:shadow-md" 
                                                                    title="Delete Subject">
                                                                <span class="text-lg">🗑️</span>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8" class="px-6 py-12 text-center">
                                                    <div class="text-gray-500">
                                                        <span class="text-6xl mb-4 block">📭</span>
                                                        <p class="text-xl font-medium mb-2">No subjects found</p>
                                                        <p class="text-gray-400">Try adjusting your filters or add a new subject</p>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Print Script --}}
    <script>
        function printReport() {
            const printContents = document.getElementById('print-section').innerHTML;
            const originalContents = document.body.innerHTML;

            document.body.innerHTML = '<div style="padding: 20px;">' + printContents + '</div>';
            window.print();
            document.body.innerHTML = originalContents;
            location.reload();
        }
    </script>

    {{-- Enhanced Chart.js Pie Charts Script --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            function generatePieChart(ctxId, labels, data) {
                new Chart(document.getElementById(ctxId).getContext('2d'), {
                    type: 'doughnut',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Student Count',
                            data: data,
                            backgroundColor: [
                                '#3B82F6', '#10B981', '#F59E0B', '#EF4444', 
                                '#8B5CF6', '#22D3EE', '#14B8A6', '#F43F5E',
                                '#6366F1', '#84CC16', '#F97316', '#EC4899'
                            ],
                            borderColor: '#ffffff',
                            borderWidth: 3,
                            hoverBorderWidth: 5,
                            hoverOffset: 10
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        cutout: '60%',
                        plugins: {
                            legend: { 
                                position: 'bottom',
                                labels: {
                                    padding: 20,
                                    usePointStyle: true,
                                    font: {
                                        size: 12,
                                        weight: 'bold'
                                    }
                                }
                            },
                            tooltip: {
                                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                                titleColor: '#ffffff',
                                bodyColor: '#ffffff',
                                borderColor: '#3B82F6',
                                borderWidth: 1,
                                cornerRadius: 10,
                                displayColors: true,
                                callbacks: {
                                    label: function(context) {
                                        const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                        const percentage = ((context.parsed / total) * 100).toFixed(1);
                                        return context.label + ': ' + context.parsed + ' students (' + percentage + '%)';
                                    }
                                }
                            }
                        },
                        animation: {
                            animateRotate: true,
                            duration: 2000
                        }
                    }
                });
            }

            // Generate charts with enhanced styling
            generatePieChart(
                'chartMenengah',
                {!! json_encode($menengahSubjects->pluck('subject')) !!},
                {!! json_encode($menengahSubjects->pluck('student_count')) !!}
            );

            generatePieChart(
                'chartRendah',
                {!! json_encode($rendahSubjects->pluck('subject')) !!},
                {!! json_encode($rendahSubjects->pluck('student_count')) !!}
            );

            generatePieChart(
                'chartAgama',
                {!! json_encode($agamaSubjects->pluck('subject')) !!},
                {!! json_encode($agamaSubjects->pluck('student_count')) !!}
            );
        });
    </script>

    {{-- Enhanced Print Styles --}}
    <style>
        @media print {
            body * {
                visibility: hidden;
            }
            #print-section, #print-section * {
                visibility: visible;
            }
            #print-section {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }
            
            /* Print-specific table styling */
            table {
                border-collapse: collapse;
                width: 100%;
            }
            
            th, td {
                border: 1px solid #000 !important;
                padding: 8px !important;
                text-align: left;
            }
            
            th {
                background-color: #f3f4f6 !important;
                font-weight: bold;
            }
            
            .rounded-full {
                border-radius: 0 !important;
                background-color: transparent !important;
                color: #000 !important;
            }
        }

        /* Enhanced hover animations */
        .hover\:shadow-xl:hover {
            transform: translateY(-2px);
        }
        
        .transition-all {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        /* Custom scrollbar for tables */
        .overflow-x-auto::-webkit-scrollbar {
            height: 8px;
        }
        
        .overflow-x-auto::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 4px;
        }
        
        .overflow-x-auto::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }
        
        .overflow-x-auto::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>
</x-app-layout>