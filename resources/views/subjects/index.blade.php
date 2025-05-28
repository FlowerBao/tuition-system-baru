<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Subjects Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 text-center">
                    <p class="text-2xl font-bold animate-bounce">
                        {{ __("Welcome to Aimi An Najjah Tuition Centre") }}
                    </p>
                    <p class="text-xl font-bold mt-4 animate-pulse">
                        {{ __("Inspiring Minds, Achieving Brilliance") }}
                    </p>
                </div>
            </div>

            <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                <!-- Total Tutors Card -->
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h3 class="text-xl font-semibold text-gray-800">Total Tutors</h3>
                    <p class="text-3xl font-bold text-blue-600 mt-2">{{ $totalTutors }}</p>
                </div>

                <!-- Total Students Card -->
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h3 class="text-xl font-semibold text-gray-800">Total Students</h3>
                    <p class="text-3xl font-bold text-green-600 mt-2">{{ $totalStudents }}</p>
                </div>

                <!-- Register Subject Card -->
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h3 class="text-xl font-semibold text-gray-800">Register Subject</h3>
                    <p class="text-md text-gray-600 mt-2">Click below to add a new subject</p>
                    <a href="{{ route('admin.subject.create') }}" class="mt-4 inline-block bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
                        Register New Subject
                    </a>
                </div>
            </div>

            <!-- Subjects With Timetable Counts -->
            <div class="mt-12 bg-white p-6 rounded-lg shadow-md">
                <h3 class="text-2xl font-semibold text-gray-800 mb-4 text-center">Subjects Overview</h3>

                @forelse ($subjects as $subject)
                    <div class="border border-gray-200 p-4 rounded-lg mb-4">
                        <h4 class="text-xl font-bold text-gray-700">{{ $subject->name }}</h4>
                        <p>🗓️ Timetables: <strong>{{ $subject->timetables_count }}</strong></p>
                        <p>💰 Price: RM{{ number_format($subject->price, 2) }}</p>
                        <p>🎓 Level: {{ $subject->level }}</p>
                        <p>🏫 Class: {{ $subject->subject_class }}</p>
                    </div>
                @empty
                    <p class="text-gray-500">No subjects found.</p>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>
