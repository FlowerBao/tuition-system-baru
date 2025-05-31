<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-grey leading-tight bg-blue-200 px-4 py-2 rounded">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-8 rounded-lg shadow-md">

                <h3 class="text-2xl font-bold text-center text-gray-700 mb-8">
                    <div class="flex flex-col items-center mb-4">
                        <!-- Logo - Centered and Larger -->
                        <img src="{{ asset('assets/images/logo.png') }}" alt="Company Logo" class="h-24 mb-2">
                    Welcome to Aimi An Najjah Tuition Centre
                </h3>

                @if(auth()->user()->role === 'admin')
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        <a href="{{ route('fee_payments.admin_view') }}" class="block">
                        <div class="bg-blue-100 p-6 rounded-lg shadow text-center">
                            <div class="text-6xl text-blue-600 mb-4">👨‍🎓</div>
                            <h3 class="text-lg font-semibold text-blue-700">Total Registered Students</h3>
                            <p class="text-3xl font-bold text-gray-800">{{ $totalStudents }}</p>
                        </div>
                        </a>

                        <a href="{{ route('tutors.index') }}" class="block">
                        <div class="bg-green-100 p-6 rounded-lg shadow text-center">
                            <div class="text-6xl text-green-600 mb-4">👩‍🏫</div>
                            <h3 class="text-lg font-semibold text-green-700">Total Registered Tutors</h3>
                            <p class="text-3xl font-bold text-gray-800">{{ $totalTutors }}</p>
                        </div>
                        </a>

                        <a href="{{ route('timetables.index') }}" class="block">
                        <div class="bg-purple-100 p-6 rounded-lg shadow text-center">
                            <div class="text-6xl text-purple-600 mb-4">📚</div>
                            <h3 class="text-lg font-semibold text-purple-700">Total Registered Subjects</h3>
                            <p class="text-3xl font-bold text-gray-800">{{ $totalSubjects }}</p>
                        </div>
                        </a>
                    </div>
                @elseif(auth()->user()->role === 'tutor')
                    <div>
                        <h3 class="text-xl font-bold mb-4 text-center">Your Subject Enrollments</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($subjectsWithCounts as $subject)
                                <div class="bg-blue-100 p-6 rounded-lg shadow text-center">
                                    <div class="text-5xl text-blue-600 mb-3">📘</div>
                                    <h4 class="text-lg font-semibold text-blue-800">{{ $subject->name }}</h4>
                                    <p class="text-sm text-gray-600">Level: {{ $subject->level }}</p>
                                    <p class="text-2xl font-bold mt-2 text-gray-800">{{ $subject->students_count }} Students</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @elseif(auth()->user()->role === 'parents')
                    <div class="bg-yellow-100 p-6 rounded-lg shadow text-center">
                        <div class="text-6xl text-yellow-600 mb-4">👪</div>
                        <h3 class="text-lg font-semibold text-yellow-800">Total Students Registered Under Your Account</h3>
                        <p class="text-3xl font-bold text-gray-800">{{ $totalParentStudents }}</p>
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>
