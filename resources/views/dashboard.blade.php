<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-grey leading-tight bg-blue-200 px-4 py-2 rounded animate-fade-in-down">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-8 rounded-lg shadow-md animate-fade-in-up">

                <h3 class="text-2xl font-bold text-center text-gray-700 mb-8 animate-fade-in">
                    <div class="flex flex-col items-center mb-4">
                        <!-- Logo - Centered and Larger with bounce animation -->
                        <img src="{{ asset('assets/images/logo.png') }}" alt="Company Logo" class="h-24 mb-2 animate-bounce-subtle">
                    </div>
                    <span class="animate-text-gradient bg-gradient-to-r from-blue-600 via-purple-600 to-blue-600 bg-clip-text text-transparent">
                        Welcome to Aimi An Najjah Tuition Centre
                    </span>
                </h3>

                @if(auth()->user()->role === 'admin')
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        <a href="{{ route('fee_payments.admin_view') }}" class="block animate-fade-in-left" style="animation-delay: 0.1s;">
                            <div class="bg-blue-100 p-6 rounded-lg shadow text-center transform transition-all duration-300 hover:scale-105 hover:shadow-xl hover:bg-blue-200 card-hover-glow">
                                <div class="text-6xl text-blue-600 mb-4 animate-pulse-subtle">👨‍🎓</div>
                                <h3 class="text-lg font-semibold text-blue-700 transition-colors duration-300">Total Registered Students</h3>
                                <p class="text-3xl font-bold text-gray-800 counter-animation">{{ $totalStudents }}</p>
                            </div>
                        </a>

                        <a href="{{ route('tutors.index') }}" class="block animate-fade-in-up" style="animation-delay: 0.2s;">
                            <div class="bg-green-100 p-6 rounded-lg shadow text-center transform transition-all duration-300 hover:scale-105 hover:shadow-xl hover:bg-green-200 card-hover-glow">
                                <div class="text-6xl text-green-600 mb-4 animate-pulse-subtle">👩‍🏫</div>
                                <h3 class="text-lg font-semibold text-green-700 transition-colors duration-300">Total Registered Tutors</h3>
                                <p class="text-3xl font-bold text-gray-800 counter-animation">{{ $totalTutors }}</p>
                            </div>
                        </a>

                        <a href="{{ route('timetables.index') }}" class="block animate-fade-in-right" style="animation-delay: 0.3s;">
                            <div class="bg-purple-100 p-6 rounded-lg shadow text-center transform transition-all duration-300 hover:scale-105 hover:shadow-xl hover:bg-purple-200 card-hover-glow">
                                <div class="text-6xl text-purple-600 mb-4 animate-pulse-subtle">📚</div>
                                <h3 class="text-lg font-semibold text-purple-700 transition-colors duration-300">Total Registered Subjects</h3>
                                <p class="text-3xl font-bold text-gray-800 counter-animation">{{ $totalSubjects }}</p>
                            </div>
                        </a>
                    </div>
                @elseif(auth()->user()->role === 'tutor')
                    <div class="animate-fade-in-up" style="animation-delay: 0.2s;">
                        <h3 class="text-xl font-bold mb-4 text-center animate-fade-in">Your Subject Enrollments</h3>
                        <div class="bg-blue-100 p-6 rounded-lg shadow text-center transform transition-all duration-300 hover:scale-102 hover:shadow-lg card-hover-glow">
                            @foreach($subjectsWithCounts as $subject)
                                <div class="mb-6 animate-slide-up" style="animation-delay: {{ $loop->index * 0.1 }}s;">
                                    <div class="text-5xl text-blue-600 mb-3 animate-pulse-subtle">📘</div>
                                    <h4 class="text-lg font-semibold text-blue-800 transition-colors duration-300">{{ $subject->name }}</h4>
                                    <p class="text-sm text-gray-600">Level: {{ $subject->level }}</p>
                                    <p class="text-2xl font-bold mt-2 text-gray-800 counter-animation">{{ $subject->students_count }} Students</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @elseif(auth()->user()->role === 'parents')
                    <div class="bg-yellow-100 p-6 rounded-lg shadow text-center transform transition-all duration-300 hover:scale-102 hover:shadow-lg animate-fade-in-up card-hover-glow" style="animation-delay: 0.2s;">
                        <div class="text-6xl text-yellow-600 mb-4 animate-pulse-subtle">👪</div>
                        <h3 class="text-lg font-semibold text-yellow-800 transition-colors duration-300">Total Students Registered Under Your Account</h3>
                        <p class="text-3xl font-bold text-gray-800 counter-animation">{{ $totalParentStudents }}</p>
                    </div>
                @endif

            </div>
        </div>
    </div>

    <style>
        /* Keyframe Animations */
        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInLeft {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes fadeInRight {
            from {
                opacity: 0;
                transform: translateX(30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes bounceSubtle {
            0%, 20%, 50%, 80%, 100% {
                transform: translateY(0);
            }
            40% {
                transform: translateY(-10px);
            }
            60% {
                transform: translateY(-5px);
            }
        }

        @keyframes pulseSubtle {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.05);
            }
        }

        @keyframes textGradient {
            0%, 100% {
                background-position: 0% 50%;
            }
            50% {
                background-position: 100% 50%;
            }
        }

        @keyframes counterUp {
            from {
                opacity: 0;
                transform: translateY(20px) scale(0.8);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        @keyframes glowPulse {
            0%, 100% {
                box-shadow: 0 0 20px rgba(59, 130, 246, 0.3);
            }
            50% {
                box-shadow: 0 0 30px rgba(59, 130, 246, 0.6);
            }
        }

        /* Animation Classes */
        .animate-fade-in-down {
            animation: fadeInDown 0.8s ease-out forwards;
        }

        .animate-fade-in-up {
            animation: fadeInUp 0.8s ease-out forwards;
        }

        .animate-fade-in-left {
            animation: fadeInLeft 0.8s ease-out forwards;
            opacity: 0;
        }

        .animate-fade-in-right {
            animation: fadeInRight 0.8s ease-out forwards;
            opacity: 0;
        }

        .animate-fade-in {
            animation: fadeIn 1s ease-out forwards;
        }

        .animate-slide-up {
            animation: slideUp 0.6s ease-out forwards;
            opacity: 0;
        }

        .animate-bounce-subtle {
            animation: bounceSubtle 2s infinite;
        }

        .animate-pulse-subtle {
            animation: pulseSubtle 3s ease-in-out infinite;
        }

        .animate-text-gradient {
            background-size: 200% auto;
            animation: textGradient 3s ease-in-out infinite;
        }

        .counter-animation {
            animation: counterUp 0.8s ease-out forwards;
        }

        .card-hover-glow {
            transition: all 0.3s ease;
        }

        .card-hover-glow:hover {
            animation: glowPulse 2s ease-in-out infinite;
        }

        /* Hover scale variations */
        .hover\:scale-102:hover {
            transform: scale(1.02);
        }

        /* Ensure smooth transitions */
        * {
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Loading state animation */
        .loading-shimmer {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200% 100%;
            animation: shimmer 1.5s infinite;
        }

        @keyframes shimmer {
            0% {
                background-position: -200% 0;
            }
            100% {
                background-position: 200% 0;
            }
        }

        /* Stagger animation delays for better visual flow */
        .grid > *:nth-child(1) { animation-delay: 0.1s; }
        .grid > *:nth-child(2) { animation-delay: 0.2s; }
        .grid > *:nth-child(3) { animation-delay: 0.3s; }
        .grid > *:nth-child(4) { animation-delay: 0.4s; }
        .grid > *:nth-child(5) { animation-delay: 0.5s; }
        .grid > *:nth-child(6) { animation-delay: 0.6s; }
    </style>
</x-app-layout>