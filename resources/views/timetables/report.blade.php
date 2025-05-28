<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Timetable Report</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white p-6 rounded shadow">
                <h3 class="text-lg font-semibold mb-4">Summary</h3>
                <div class="grid grid-cols-3 gap-4">
                    <div class="p-4 bg-gray-100 rounded">Total Students: {{ $totalStudents }}</div>
                    <div class="p-4 bg-gray-100 rounded">Total Subjects: {{ $totalSubjects }}</div>
                    <div class="p-4 bg-gray-100 rounded">Total Tutors: {{ $totalTutors }}</div>
                </div>
            </div>

            <div class="bg-white p-6 rounded shadow">
                <h3 class="text-lg font-semibold mb-4">Subjects</h3>
                <table class="min-w-full border-collapse border border-gray-300">
                    <thead>
                        <tr>
                            <th class="border border-gray-300 p-2">Subject</th>
                            <th class="border border-gray-300 p-2">Level</th>
                            <th class="border border-gray-300 p-2">Class</th>
                            <th class="border border-gray-300 p-2">Students Enrolled</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($subjects as $subject)
                        <tr>
                            <td class="border border-gray-300 p-2">{{ $subject->name }}</td>
                            <td class="border border-gray-300 p-2">{{ $subject->level }}</td>
                            <td class="border border-gray-300 p-2">{{ $subject->subject_class }}</td>
                            <td class="border border-gray-300 p-2">{{ $subject->students_count }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                {{ $subjects->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
