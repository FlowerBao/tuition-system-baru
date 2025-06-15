<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tutor Certificates 🎓</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            min-height: 100vh;
        }
        
        /* Cute floating characters */
        .cute-owl {
            position: fixed;
            top: 10%;
            right: 5%;
            font-size: 3rem;
            animation: owlFloat 4s ease-in-out infinite;
            z-index: 10;
        }
        
        .cute-book {
            position: fixed;
            top: 70%;
            left: 5%;
            font-size: 2.5rem;
            animation: bookBounce 3s ease-in-out infinite;
            z-index: 10;
        }
        
        .cute-star {
            position: fixed;
            font-size: 1.5rem;
            animation: starTwinkle 2s ease-in-out infinite;
            z-index: 5;
        }
        
        @keyframes owlFloat {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            25% { transform: translateY(-15px) rotate(2deg); }
            50% { transform: translateY(-10px) rotate(0deg); }
            75% { transform: translateY(-20px) rotate(-2deg); }
        }
        
        @keyframes bookBounce {
            0%, 100% { transform: translateY(0) scale(1); }
            50% { transform: translateY(-25px) scale(1.1); }
        }
        
        @keyframes starTwinkle {
            0%, 100% { opacity: 1; transform: scale(1) rotate(0deg); }
            50% { opacity: 0.5; transform: scale(1.2) rotate(180deg); }
        }
        
        /* Card styles */
        .cute-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
            transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
            border: 2px solid rgba(255, 255, 255, 0.3);
        }
        
        .cute-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
        }
        
        /* Button styles */
        .cute-button {
            background: linear-gradient(45deg, #4fc3f7, #29b6f6);
            border-radius: 25px;
            padding: 12px 24px;
            color: white;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(79, 195, 247, 0.3);
        }
        
        .cute-button:hover {
            transform: translateY(-2px) scale(1.05);
            box-shadow: 0 6px 20px rgba(79, 195, 247, 0.4);
        }
        
        .back-button {
            background: linear-gradient(45deg, #42a5f5, #1e88e5);
            border-radius: 25px;
            padding: 12px 24px;
            color: white;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(66, 165, 245, 0.3);
        }
        
        .back-button:hover {
            transform: translateY(-2px) scale(1.05);
            box-shadow: 0 6px 20px rgba(66, 165, 245, 0.4);
        }
        
        /* Table row animations */
        .certificate-row {
            transition: all 0.3s ease;
            border-radius: 15px;
            margin: 8px 0;
            background: rgba(255, 255, 255, 0.7);
        }
        
        .certificate-row:hover {
            background: linear-gradient(90deg, rgba(79, 195, 247, 0.3), rgba(129, 212, 250, 0.3));
            transform: translateX(10px) scale(1.02);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }
        
        /* Search input */
        .cute-search {
            border-radius: 25px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            background: rgba(255, 255, 255, 0.9);
            padding: 15px 50px 15px 20px;
            transition: all 0.3s ease;
        }
        
        .cute-search:focus {
            border-color: #42a5f5;
            box-shadow: 0 0 20px rgba(66, 165, 245, 0.3);
            transform: scale(1.02);
        }
        
        /* Header animation */
        .bounce-in-cute {
            animation: bounceInCute 1s ease-out;
        }
        
        @keyframes bounceInCute {
            0% {
                opacity: 0;
                transform: scale(0.3) translateY(-100px);
            }
            50% {
                opacity: 1;
                transform: scale(1.1) translateY(-20px);
            }
            70% {
                transform: scale(0.95) translateY(0);
            }
            100% {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }
        
        /* Avatar styles */
        .cute-avatar {
            background: linear-gradient(45deg, #81d4fa, #4fc3f7);
            border: 3px solid white;
            box-shadow: 0 4px 15px rgba(129, 212, 250, 0.3);
        }
        
        /* Floating elements */
        .floating-hearts {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 1;
        }
        
        .heart {
            position: absolute;
            color: rgba(129, 212, 250, 0.6);
            animation: floatUp 8s infinite linear;
        }
        
        @keyframes floatUp {
            0% {
                transform: translateY(100vh) scale(0);
                opacity: 0;
            }
            10% {
                opacity: 1;
            }
            90% {
                opacity: 1;
            }
            100% {
                transform: translateY(-100px) scale(1);
                opacity: 0;
            }
        }
        
        /* Fade in animation */
        .fade-in-up {
            animation: fadeInUp 0.8s ease-out;
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
    </style>
</head>
<body>
    <!-- Floating Hearts Background -->
    <div class="floating-hearts" id="heartsContainer"></div>
    
    <!-- Cute Characters -->
    <div class="cute-owl">🦉</div>
    <div class="cute-book">📚</div>
    
    <!-- Twinkling Stars -->
    <div class="cute-star" style="top: 15%; left: 20%; animation-delay: 0s;">⭐</div>
    <div class="cute-star" style="top: 25%; right: 15%; animation-delay: 1s;">✨</div>
    <div class="cute-star" style="top: 60%; left: 10%; animation-delay: 2s;">🌟</div>
    <div class="cute-star" style="top: 80%; right: 25%; animation-delay: 1.5s;">💫</div>

    <div class="container mx-auto py-8 px-4 relative z-20">
        
        <!-- Back Button -->
        <div class="mb-6 fade-in-up">
            <button onclick="goHome()" class="back-button inline-flex items-center">
                <i class="fas fa-arrow-left mr-2"></i>
                Back to Home
            </button>
        </div>
        
        <!-- Header Section -->
        <div class="text-center mb-12 bounce-in-cute">
            <div class="inline-block text-6xl mb-4">🎓</div>
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">
                Tutor Certificates
            </h1>
            <p class="text-xl text-white text-opacity-90 max-w-2xl mx-auto">
                Discover amazing certificates from our wonderful tutors! ✨
            </p>
        </div>

        <!-- Search Section -->
        <div class="cute-card p-6 mb-8 fade-in-up" style="animation-delay: 0.2s;">
            <div class="flex flex-col md:flex-row gap-4 items-center justify-between">
                <div class="relative flex-1 max-w-md">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <span class="text-xl">🔍</span>
                    </div>
                    <input type="text" 
                           id="searchInput"
                           placeholder="Search for awesome certificates..."
                           class="cute-search block w-full pl-12 pr-4 py-3 leading-5 focus:outline-none">
                </div>
                <div class="flex items-center gap-4">
                    <span class="text-sm text-gray-600 flex items-center">
                        <span class="text-lg mr-2">📋</span>
                        <span id="totalCount" class="font-semibold text-blue-600">{{ $certificates->count() }}</span> certificates
                    </span>
                    <button onclick="clearSearch()" class="cute-button text-sm">
                        Clear 🧹
                    </button>
                </div>
            </div>
        </div>

        <!-- Main Content Card -->
        <div class="cute-card overflow-hidden fade-in-up" style="animation-delay: 0.4s;">
            
            <!-- Table Header -->
            <div class="bg-gradient-to-r from-blue-400 to-blue-600 px-6 py-4">
                <div class="flex items-center justify-center">
                    <h2 class="text-lg font-semibold text-white flex items-center">
                        <span class="text-2xl mr-3">🏆</span>
                        Certificate Collection
                    </h2>
                </div>
            </div>

            <!-- Table Content -->
            <div class="p-4">
                <div id="certificateContainer">
                    @forelse($certificates as $index => $certificate)
                        <div class="certificate-row p-4 mb-3" data-tutor-name="{{ $certificate->tutor->tutor_name ?? 'N/A' }}" data-certificate-name="{{ $certificate->name }}">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center flex-1">
                                    <div class="flex-shrink-0 mr-4">
                                        @php
                                            $tutorName = $certificate->tutor->tutor_name ?? 'N/A';
                                            $initials = $tutorName !== 'N/A' ? 
                                                strtoupper(substr($tutorName, 0, 1) . (strpos($tutorName, ' ') ? substr($tutorName, strpos($tutorName, ' ') + 1, 1) : '')) : 
                                                'NA';
                                            $emojis = ['🐱', '🐶', '🦊', '🐼', '🐨', '🦝', '🐻', '🐹'];
                                            $emoji = $emojis[$index % count($emojis)];
                                        @endphp
                                        <div class="cute-avatar h-12 w-12 rounded-full flex items-center justify-center text-xl">
                                            {{ $emoji }}
                                        </div>
                                    </div>
                                    <div class="flex-1">
                                        <div class="font-semibold text-gray-800 flex items-center">
                                            <span class="mr-2">👨‍🏫</span>
                                            {{ $certificate->tutor->tutor_name ?? 'N/A' }}
                                        </div>
                                        <div class="text-gray-600 text-sm">
                                            @if($certificate->tutor && $certificate->tutor->specialization)
                                                {{ $certificate->tutor->specialization }}
                                            @else
                                                Amazing Tutor
                                            @endif
                                        </div>
                                        <div class="font-medium text-blue-600 mt-1 flex items-center">
                                            <span class="mr-2">📜</span>
                                            {{ $certificate->name }}
                                        </div>
                                        @if($certificate->issued_by || $certificate->issued_date || $certificate->created_at)
                                            <div class="text-sm text-gray-500 mt-1">
                                                @if($certificate->issued_by)
                                                    {{ $certificate->issued_by }}
                                                @endif
                                                @if($certificate->issued_date)
                                                    • {{ \Illuminate\Support\Carbon::parse($certificate->issued_date)->format('Y') }}
                                                @elseif($certificate->created_at)
                                                    • {{ $certificate->created_at->format('Y') }}
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <a href="{{ $certificate->file_path }}"
                                       target="_blank"
                                       class="cute-button inline-flex items-center text-sm">
                                        <span class="mr-2">👀</span>
                                        View
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div id="emptyState" class="text-center py-16">
                            <div class="text-6xl mb-4">📜</div>
                            <h3 class="text-lg font-medium text-gray-800 mb-2">No certificates yet!</h3>
                            <p class="text-gray-600">Our tutors are working hard to get certified. Check back soon! 🌟</p>
                        </div>
                    @endforelse
                </div>

                <!-- Search Empty State (hidden by default) -->
                <div id="searchEmptyState" class="hidden text-center py-16">
                    <div class="text-6xl mb-4">🔍</div>
                    <h3 class="text-lg font-medium text-gray-800 mb-2">Oops! Nothing found</h3>
                    <p class="text-gray-600 mb-6">Try a different search term, or let's see all certificates! 😊</p>
                    <button onclick="clearSearch()" class="cute-button">
                        Show All Certificates 🎉
                    </button>
                </div>
            </div>

            <!-- Footer -->
            <div class="bg-gradient-to-r from-blue-50 to-cyan-50 px-6 py-4 border-t">
                <div class="flex items-center justify-between text-sm">
                    <div class="flex items-center text-gray-700">
                        <span class="text-lg mr-2">✅</span>
                        All certificates are verified and awesome!
                    </div>
                    <div class="text-gray-600">
                        Updated: <span class="font-medium">{{ now()->format('M d, Y') }}</span> 📅
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let allRows = [];
        
        function initializeTable() {
            const container = document.getElementById('certificateContainer');
            allRows = Array.from(container.querySelectorAll('.certificate-row'));
            updateCount();
            createFloatingHearts();
        }
        
        function updateCount() {
            const visibleRows = allRows.filter(row => !row.classList.contains('hidden'));
            document.getElementById('totalCount').textContent = visibleRows.length;
        }
        
        function searchCertificates() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const container = document.getElementById('certificateContainer');
            const searchEmptyState = document.getElementById('searchEmptyState');
            
            let visibleCount = 0;
            
            allRows.forEach(row => {
                const tutorName = row.getAttribute('data-tutor-name').toLowerCase();
                const certificateName = row.getAttribute('data-certificate-name').toLowerCase();
                
                if (tutorName.includes(searchTerm) || certificateName.includes(searchTerm)) {
                    row.classList.remove('hidden');
                    visibleCount++;
                } else {
                    row.classList.add('hidden');
                }
            });
            
            if (visibleCount === 0 && allRows.length > 0) {
                container.style.display = 'none';
                searchEmptyState.classList.remove('hidden');
            } else {
                container.style.display = '';
                searchEmptyState.classList.add('hidden');
            }
            
            updateCount();
        }
        
        function clearSearch() {
            document.getElementById('searchInput').value = '';
            const container = document.getElementById('certificateContainer');
            const searchEmptyState = document.getElementById('searchEmptyState');
            
            allRows.forEach(row => row.classList.remove('hidden'));
            container.style.display = '';
            searchEmptyState.classList.add('hidden');
            updateCount();
        }
        
        function goHome() {
            // Replace with your actual homepage URL
            window.location.href = '/';
        }
        
        function createFloatingHearts() {
            const container = document.getElementById('heartsContainer');
            const hearts = ['💙', '💎', '🔷', '🌀', '❄️', '🦋'];
            
            setInterval(() => {
                const heart = document.createElement('div');
                heart.className = 'heart';
                heart.textContent = hearts[Math.floor(Math.random() * hearts.length)];
                heart.style.left = Math.random() * 100 + '%';
                heart.style.animationDuration = (Math.random() * 3 + 5) + 's';
                heart.style.fontSize = (Math.random() * 1 + 1) + 'rem';
                
                container.appendChild(heart);
                
                setTimeout(() => {
                    heart.remove();
                }, 8000);
            }, 3000);
        }
        
        // Initialize when page loads
        document.addEventListener('DOMContentLoaded', function() {
            initializeTable();
            
            // Add search functionality
            document.getElementById('searchInput').addEventListener('input', searchCertificates);
            
            // Animate rows on load
            setTimeout(() => {
                allRows.forEach((row, index) => {
                    setTimeout(() => {
                        row.style.opacity = '0';
                        row.style.transform = 'translateY(20px)';
                        row.style.transition = 'all 0.5s ease';
                        
                        setTimeout(() => {
                            row.style.opacity = '1';
                            row.style.transform = 'translateY(0)';
                        }, 50);
                    }, index * 100);
                });
            }, 600);
        });
    </script>
</body>
</html>