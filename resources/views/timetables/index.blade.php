<x-app-layout>
    <x-slot name="header">  
        <h2 class="font-semibold text-xl text-grey leading-tight bg-blue-200 px-4 py-2 rounded">
            {{ __('Subject List') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold">Subject List</h2>
                    <div class="flex gap-3">
                        <a href="{{ route('timetables.create') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
                            Register New Subject
                        </a>
                        <button onclick="printReport()" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded">
                            Print Subject Report
                        </button>
                    </div>
                </div>

                <!-- Filter Form -->
                <form method="GET" action="{{ route('timetables.index') }}" class="mb-6">
                    <div class="flex items-center flex-wrap gap-4">
                        <label for="level" class="text-sm font-medium text-gray-700">Filter by Level:</label>
                        <select name="level" id="level" class="border rounded px-3 py-1">
                            <option value="">All Levels</option>
                            @foreach($levels as $levelOption)
                                <option value="{{ $levelOption }}" {{ request('level') == $levelOption ? 'selected' : '' }}>{{ $levelOption }}</option>
                            @endforeach
                        </select>

                        <label for="subject_class" class="text-sm font-medium text-gray-700">Filter by Class:</label>
                        <select name="subject_class" id="subject_class" class="border rounded px-3 py-1">
                            <option value="">All Classes</option>
                            @foreach($subjectClasses as $subjectClassOption)
                                <option value="{{ $subjectClassOption }}" {{ request('subject_class') == $subjectClassOption ? 'selected' : '' }}>{{ $subjectClassOption }}</option>
                            @endforeach
                        </select>

                        <button type="submit" class="bg-blue-700 text-white px-4 py-1 rounded hover:bg-blue-800">Filter</button>
                    </div>
                </form>

                <!-- Success Message -->
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Admin Summary -->
                @if (auth()->user()->role === 'admin')
                <div class="mt-10 w-full">
                    <div class="bg-blue-100 p-10 rounded-2xl shadow-lg text-center w-full">
                        <div class="flex items-center justify-center text-purple-600 mb-6">
                            <span class="text-7xl">📚</span>
                        </div>
                        <h3 class="text-2xl font-semibold text-blue-700">Total Registered Subjects</h3>
                        <p class="text-5xl font-bold mt-2">{{ count($timetableList) }}</p>
                    </div>
                </div>

                <!-- Subject Report -->
                <div id="print-section" class="mt-10">
                    <h3 class="text-xl font-semibold mb-4">Subject Enrollment Report</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white border border-gray-300 text-sm">
                            <thead class="bg-indigo-100 text-indigo-900 font-semibold">
                                <tr>
                                    <th class="px-4 py-2 border text-left">Subject</th>
                                    <th class="px-4 py-2 border text-center">Level</th>
                                    <th class="px-4 py-2 border text-center">Subject Class</th>
                                    <th class="px-4 py-2 border text-center">Total Students</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($subjectReport as $report)
                                    <tr class="hover:bg-indigo-50">
                                        <td class="px-4 py-2 border">{{ $report->subject }}</td>
                                        <td class="px-4 py-2 border text-center">{{ $report->level }}</td>
                                        <td class="px-4 py-2 border text-center">{{ $report->subject_class }}</td>
                                        <td class="px-4 py-2 border text-center">{{ $report->student_count }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $subjectReport->links('pagination::tailwind') }}
                    </div>

                    <!-- Three Pie Charts for Each Level -->
                    <div class="mt-10">
                        <h3 class="text-xl font-semibold mb-4">Subject Distribution by Level</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <h4 class="text-lg font-semibold text-center mb-2">Sekolah Menengah</h4>
                                <canvas id="chartMenengah" width="300" height="300"></canvas>
                            </div>
                            <div>
                                <h4 class="text-lg font-semibold text-center mb-2">Sekolah Rendah</h4>
                                <canvas id="chartRendah" width="300" height="300"></canvas>
                            </div>
                            <div>
                                <h4 class="text-lg font-semibold text-center mb-2">Sekolah Agama</h4>
                                <canvas id="chartAgama" width="300" height="300"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Timetable Table -->
                <div class="overflow-x-auto mt-10">
                    <h3 class="text-xl font-semibold mb-4">Timetable</h3>
                    <table class="min-w-full bg-white border border-gray-300 text-sm">
                        <thead class="bg-indigo-100 text-indigo-900 font-semibold">
                            <tr>
                                <th class="px-4 py-2 border text-left">Subject Name</th>
                                <th class="px-4 py-2 border text-center">Price</th>
                                <th class="px-4 py-2 border text-center">Level</th>
                                <th class="px-4 py-2 border text-center">Class</th>
                                <th class="px-4 py-2 border text-center">Day</th>
                                <th class="px-4 py-2 border text-center">Start Time</th>
                                <th class="px-4 py-2 border text-center">End Time</th>
                                <th class="px-4 py-2 border text-left">Classroom</th>
                                <th class="px-4 py-2 border text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($timetableList as $timetable)
                                <tr class="hover:bg-indigo-50">
                                    <td class="px-4 py-2 border">{{ $timetable->subject->name }}</td>
                                    <td class="px-4 py-2 border text-center">{{ $timetable->subject->price }}</td>
                                    <td class="px-4 py-2 border text-center">{{ $timetable->subject->level }}</td>
                                    <td class="px-4 py-2 border text-center">{{ $timetable->subject->subject_class }}</td>
                                    <td class="px-4 py-2 border text-center">{{ $timetable->day }}</td>
                                    <td class="px-4 py-2 border text-center">{{ $timetable->start_time }}</td>
                                    <td class="px-4 py-2 border text-center">{{ $timetable->end_time }}</td>
                                    <td class="px-4 py-2 border">{{ $timetable->classroom_name }}</td>
                                    <td class="px-4 py-2 border text-center">
                                        <div class="flex justify-center gap-2">
                                            <a href="{{ route('timetables.edit', $timetable->id) }}" class="text-xl hover:text-blue-600" title="Edit">✏️</a>
                                            <form action="{{ route('timetables.destroy', $timetable->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this subject?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-xl hover:text-red-600" title="Delete">🗑️</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center px-4 py-2 border">No subjects found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Print Script --}}
    <script>
        function printReport() {
            const printContents = document.getElementById('print-section').innerHTML;
            const originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
        }
    </script>

    {{-- Chart.js Pie Charts Script --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            function generatePieChart(ctxId, labels, data) {
                new Chart(document.getElementById(ctxId).getContext('2d'), {
                    type: 'pie',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Jumlah Pelajar',
                            data: data,
                            backgroundColor: [
                                '#3B82F6', '#10B981', '#F59E0B', '#EF4444', '#8B5CF6', '#22D3EE', '#14B8A6', '#F43F5E'
                            ],
                            borderColor: '#ffffff',
                            borderWidth: 2
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: { position: 'bottom' }
                        }
                    }
                });
            }

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

    {{-- Print Styles --}}
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
            canvas {
                max-width: 100% !important;
                height: auto !important;
            }
        }
    </style>
</x-app-layout>
