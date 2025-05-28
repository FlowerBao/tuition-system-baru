<x-app-layout>
    <x-slot name="header">  
        <h2 class="font-semibold text-xl text-grey leading-tight bg-blue-200 px-4 py-2 rounded">
            {{ __('Timetable') }}
        </h2>
    </x-slot>
    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold">Your Timetable</h2>

                    <!-- Print Button -->
                    <button onclick="printTimetable()" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        Print Timetable
                    </button>
                </div>

                {{-- Filter Form for Admin --}}
                @if (Auth::user()->is_admin)
                    <form method="GET" action="{{ route('timetables.display') }}" class="mb-4 flex space-x-4">
                        <div>
                            <label for="level" class="block text-sm font-medium text-gray-700">Filter by Level</label>
                            <select name="level" id="level" class="mt-1 block w-full border-gray-300 rounded-md">
                                <option value="">-- All Levels --</option>
                                @foreach($levels as $level)
                                    <option value="{{ $level }}" @if(request('level') == $level) selected @endif>{{ $level }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex items-end">
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                                Filter
                            </button>
                            <a href="{{ route('timetables.download') }}" class="ml-2 px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                                Download CSV
                            </a>
                        </div>
                    </form>
                @endif

                <!-- Timetable Section -->
                <div class="overflow-x-auto" id="printable-timetable">
                    <!-- Company Header with Logo -->
                    <div class="flex flex-col items-center mb-4">
                        <img src="{{ asset('assets/images/logo.png') }}" alt="Company Logo" class="h-24 mb-2">
                        <div class="text-lg font-semibold">Aimi An Najjah</div>
                    </div>

                    <div class="overflow-x-auto shadow-lg rounded-lg border border-gray-200">
                        <table class="min-w-full bg-white">
                            <thead>
                                <tr class="bg-gray-200">
                                    <th class="py-3 px-6 text-left text-sm font-semibold text-gray-700">Subject Name</th>
                                    <th class="py-3 px-6 text-left text-sm font-semibold text-gray-700">Price</th>
                                    <th class="py-3 px-6 text-left text-sm font-semibold text-gray-700">Level</th>
                                    <th class="py-3 px-6 text-left text-sm font-semibold text-gray-700">Class</th>
                                    <th class="py-3 px-6 text-left text-sm font-semibold text-gray-700">Day</th>
                                    <th class="py-3 px-6 text-left text-sm font-semibold text-gray-700">Start Time</th>
                                    <th class="py-3 px-6 text-left text-sm font-semibold text-gray-700">End Time</th>
                                    <th class="py-3 px-6 text-left text-sm font-semibold text-gray-700">Classroom</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($timetables as $timetable)
                                    <tr class="border-t border-gray-200">
                                        <td class="py-3 px-6 text-sm text-gray-700">{{ $timetable->subject->name }}</td>
                                        <td class="py-3 px-6 text-sm text-gray-700">{{ $timetable->subject->price }}</td>
                                        <td class="py-3 px-6 text-sm text-gray-700">{{ $timetable->subject->level }}</td>
                                        <td class="py-3 px-6 text-sm text-gray-700">{{ $timetable->subject->subject_class }}</td>
                                        <td class="py-3 px-6 text-sm text-gray-700">{{ $timetable->day }}</td>
                                        <td class="py-3 px-6 text-sm text-gray-700">{{ $timetable->start_time }}</td>
                                        <td class="py-3 px-6 text-sm text-gray-700">{{ $timetable->end_time }}</td>
                                        <td class="py-3 px-6 text-sm text-gray-700">{{ $timetable->classroom_name }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function printTimetable() {
            var printContents = document.getElementById('printable-timetable').innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
        }
    </script>

    <style>
        @media print {
            body {
                font-family: Arial, sans-serif;
                color: #000;
            }

            #printable-timetable {
                padding: 20px;
                margin-top: 20px;
            }

            .bg-indigo-200 {
                background-color: #e3d7f7 !important;
            }

            .text-indigo-800 {
                color: #4a3d88 !important;
            }

            .px-4 {
                display: none;
            }

            img {
                width: 150px;
            }

            .text-lg {
                font-size: 18px;
                font-weight: bold;
                margin-top: 10px;
            }
        }
    </style>
</x-app-layout>
