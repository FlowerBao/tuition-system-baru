<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Children Attendance Records') }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 shadow rounded-xl">
            <h2 class="text-2xl font-bold">Attendance Records</h2>
            {{-- Filter Form --}}
            <form method="GET" class="grid md:grid-cols-3 gap-4 mb-6">
                {{-- Filter by Student --}}
                <div>
                    <label for="student_id" class="block font-medium text-sm text-gray-700">Select Student</label>
                    <select name="student_id" id="student_id" class="mt-1 block w-full rounded-md shadow-sm border-gray-300" onchange="this.form.submit()">
                        <option value="">All Students</option>
                        @foreach($students as $student)
                            <option value="{{ $student->id }}" {{ request('student_id') == $student->id ? 'selected' : '' }}>
                                {{ $student->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Filter by Subject --}}
                <div>
                    <label for="subject_id" class="block font-medium text-sm text-gray-700">Select Subject</label>
                    <select name="subject_id" id="subject_id" class="mt-1 block w-full rounded-md shadow-sm border-gray-300" onchange="this.form.submit()">
                        <option value="">All Subjects</option>
                        @foreach($subjects as $subject)
                            <option value="{{ $subject->id }}" {{ request('subject_id') == $subject->id ? 'selected' : '' }}>
                                {{ $subject->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Filter by Month --}}
                <div>
                    <label for="month" class="block font-medium text-sm text-gray-700">Select Month</label>
                    <input type="month" name="month" id="month"
                           value="{{ request('month', now()->format('Y-m')) }}"
                           class="mt-1 block w-full rounded-md shadow-sm border-gray-300"
                           onchange="this.form.submit()">
                </div>
            </form>

            {{-- Attendance Table by Student --}}
            @php
                $filteredStudents = $selectedStudentId
                    ? $students->where('id', $selectedStudentId)
                    : $students;
            @endphp

            @forelse($filteredStudents as $student)
                <div class="mt-6">
                    <h3 class="text-lg font-semibold text-blue-600 mb-3">{{ $student->name }}</h3>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm border border-gray-200 mb-4">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-4 py-2 border">Date</th>
                                    <th class="px-4 py-2 border">Subject</th>
                                    <th class="px-4 py-2 border">Tutor</th>
                                    <th class="px-4 py-2 border">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($datesInMonth as $date)
                                    @php
                                        $key = $student->id . '-' . $date;
                                        $record = $groupedAttendances->get($key)?->first();
                                    @endphp
                                    <tr>
                                        <td class="border px-4 py-2">{{ \Carbon\Carbon::parse($date)->format('d M Y') }}</td>
                                        <td class="border px-4 py-2">{{ $record?->subject?->name ?? '-' }}</td>
                                        <td class="border px-4 py-2">{{ $record?->tutor?->name ?? '-' }}</td>
                                        <td class="border px-4 py-2">
                                            @if ($record)
                                                <span class="text-green-600 font-semibold">Present</span>
                                            @else
                                                <span class="text-red-500 font-semibold">Absent</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @empty
                <p class="text-gray-600">No students found under your account.</p>
            @endforelse
        </div>
    </div>
</x-app-layout>
