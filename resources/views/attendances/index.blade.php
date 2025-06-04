<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-grey leading-tight bg-blue-200 px-4 py-2 rounded">
            {{ __('Attendance Records') }}
        </h2>
    </x-slot>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold">Attendance Records</h2>
                    <div class="flex gap-3">
                        <a href="{{ route('attendances.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                            Take Attendance
                        </a>
                    </div>
                </div>

                <form method="GET" class="flex gap-4 mb-4">
                    <input type="date" name="date" class="border rounded px-3 py-1" value="{{ request('date') }}">

                    <select name="subject_class" class="border rounded px-3 py-1">
                        <option value="">All Classes</option>
                        @if(isset($subjectClasses) && $subjectClasses->count())
                            @foreach($subjectClasses as $class)
                                <option value="{{ $class }}" {{ request('subject_class') == $class ? 'selected' : '' }}>
                                    Class {{ $class }}
                                </option>
                            @endforeach
                        @endif
                    </select>

                    <select name="subject_id" class="border rounded px-3 py-1">
                        <option value="">All Subjects</option>
                        @foreach($subjects as $subject)
                            <option value="{{ $subject->id }}" {{ request('subject_id') == $subject->id ? 'selected' : '' }}>
                                {{ $subject->name }}
                            </option>
                        @endforeach
                    </select>

                    <button type="submit" class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700">Filter</button>
                </form>

                <div class="overflow-x-auto shadow-lg rounded-lg border border-gray-200">
                    <table class="w-full table-auto border-collapse">
                        <thead>
                            <tr class="bg-gray-200 text-left">
                                <th class="py-3 px-6 text-left text-sm font-semibold text-gray-700">Date</th>
                                <th class="py-3 px-6 text-left text-sm font-semibold text-gray-700">Student</th>
                                <th class="py-3 px-6 text-left text-sm font-semibold text-gray-700">Subject</th>
                                <th class="py-3 px-6 text-left text-sm font-semibold text-gray-700">Tutor</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($attendances as $attendance)
                                <tr class="border-t border-gray-200">
                                    <td class="py-3 px-6 text-sm text-gray-700">{{ $attendance->date }}</td>
                                    <td class="py-3 px-6 text-sm text-gray-700">{{ $attendance->student->name }}</td>
                                    <td class="py-3 px-6 text-sm text-gray-700">{{ $attendance->subject->name }}</td>
                                    <td class="py-3 px-6 text-sm text-gray-700">{{ $attendance->tutor->user->name ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="p-4 text-center">No attendance records found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $attendances->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
