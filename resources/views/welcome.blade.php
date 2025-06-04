<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Welcome - Aimi An Najjah Tuition Centre</title>
  <link rel="icon" href="{{ asset('assets/images/logo.png') }}" type="image/png" />
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    #slider-images img {
      max-height: 300px;
      object-fit: cover;
    }
    @media (min-width: 768px) {
      #slider-images img {
        max-height: 500px;
      }
    }
  </style>
</head>
<body class="bg-gray-100 font-sans">

  <!-- Responsive Navbar -->
  <nav class="bg-white shadow-md">
    <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
      <div class="flex items-center space-x-4">
        <img src="{{ asset('assets/images/logo.png') }}" class="w-10 h-10 sm:w-12 sm:h-12" alt="Logo">
        <span class="text-lg sm:text-xl font-bold text-blue-800">Aimi An Najjah Tuition Centre</span>
      </div>
      <div class="hidden md:flex space-x-6">
        <a href="/" class="text-gray-700 hover:text-green-700 font-medium">Home</a>
        <a href="/about" class="text-gray-700 hover:text-green-700 font-medium">Our Tutor</a>
        <a href="/login" class="text-white bg-blue-500 hover:bg-blue-600 px-4 py-2 rounded-lg">Login</a>
      </div>
      <!-- Mobile Menu Button -->
      <div class="md:hidden">
        <button id="menuBtn" class="focus:outline-none">
          <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16"></path>
          </svg>
        </button>
      </div>
    </div>
    <!-- Mobile Menu -->
    <div id="mobileMenu" class="md:hidden hidden px-4 pb-4 space-y-2">
      <a href="/" class="block text-gray-700 hover:text-blue-700">Home</a>
      <a href="/about" class="block text-gray-700 hover:text-blue-700">Our Tutor</a>
      <a href="/login" class="block text-white bg-blue-500 hover:bg-blue-600 px-4 py-2 rounded-lg text-center">Login</a>
    </div>
  </nav>

  <!-- Hero Section -->
  <section class="relative bg-blue-900 text-white py-20 text-center">
    <div class="absolute inset-0">
      <img src="{{ asset('assets/images/bg green.png') }}" alt="Farm Background" class="w-full h-full object-cover opacity-20">
    </div>
    <div class="relative px-4 sm:px-6 lg:px-8">
      <h1 class="text-3xl sm:text-4xl font-bold mb-4">About Aimi An Najjah Tuition Centre</h1>
      <p class="text-base sm:text-lg mb-6">INTERESTED IN REGISTERING YOUR CHILD AT AIMI AN NAJJAH TUITION CENTER? </p>
        <p class="text-base sm:text-lg mb-6"> Click the button below to start registering your child now with as minimum as RM30 for the registration fee.</p>
      <a href="/register" class="bg-green-500 hover:bg-green-600 text-white px-6 py-2 rounded-full font-medium">Register Now</a>
    </div>
  </section>

  <!-- About Details -->
  <section class="bg-blue-50 py-16 px-4 sm:px-6 lg:px-20">
    <div class="max-w-6xl mx-auto grid md:grid-cols-2 gap-10 items-center">
      <div>
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Vision</h2>
        <p class="text-gray-600 mb-4 text-justify">
          Pusat Tuisyen Aimi An Najjah aspires to become a leading educational center in Malaysia that 
          fosters academic excellence and character development through a holistic and innovative educational approach. 
          We are committed to nurturing a generation of knowledgeable students with noble character who are prepared to face future challenges.
        </p>
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Mission</h2>
        <ul class="list-disc list-inside text-gray-600 space-y-2">
          <li>Customized syllabus matching school standards</li>
          <li>Safe, supportive, and clean classroom environments</li>
          <li>Provide individual attention to each student</li>
          <li>Encourage lifelong learning by fostering curiosity and critical thinking</li>
        </ul>
        <p class="text-gray-600 text-justify">
          We strive to provide the best learning environment for students to grow, explore, and succeed academically and personally.
        </p>
      </div>
      <div class="relative">
        <img src="{{ asset('assets/images/activity2.jpg') }}" alt="Farming Steps" class="rounded-lg shadow-lg w-full h-auto">
        <div class="absolute top-4 left-4 bg-blue-600 text-white text-sm font-bold px-4 py-2 rounded shadow-lg">
          10+<br><span class="text-xs font-normal">Years of Experience</span>
        </div>
      </div>
    </div>
  </section>

  <!-- Image Slider -->
  <section class="bg-gray-100 py-12 px-4 sm:px-6 lg:px-20">
    <h2 class="text-2xl font-bold text-center text-blue-800 mb-8">Our Moments in Action</h2>
    <div class="relative overflow-hidden max-w-5xl mx-auto rounded-lg shadow-lg">
      <div id="slider-images" class="flex transition-transform duration-700 ease-in-out">
        <img src="{{ asset('assets/images/activity6.png') }}" class="w-full flex-shrink-0" alt="Slide 1">
        <img src="{{ asset('assets/images/activity5.png') }}" class="w-full flex-shrink-0" alt="Slide 2">
        <img src="{{ asset('assets/images/activity4.png') }}" class="w-full flex-shrink-0" alt="Slide 3">
      </div>
      <button onclick="prevSlide()" class="absolute top-1/2 left-3 transform -translate-y-1/2 bg-black bg-opacity-50 text-white px-3 py-2 rounded-full hover:bg-opacity-75">‹</button>
      <button onclick="nextSlide()" class="absolute top-1/2 right-3 transform -translate-y-1/2 bg-black bg-opacity-50 text-white px-3 py-2 rounded-full hover:bg-opacity-75">›</button>
    </div>
    <div class="flex justify-center mt-4 space-x-2" id="slider-dots">
      <span class="dot h-3 w-3 rounded-full bg-green-500 inline-block cursor-pointer"></span>
      <span class="dot h-3 w-3 rounded-full bg-gray-300 inline-block cursor-pointer"></span>
      <span class="dot h-3 w-3 rounded-full bg-gray-300 inline-block cursor-pointer"></span>
    </div>
  </section>

  <!-- Footer -->
  <footer class="bg-blue-800 shadow-inner py-6 text-center text-white">
    &copy; {{ date('Y') }} Aimi An Najjah Tuition Centre. All rights reserved.
  </footer>

  <!-- JS for Menu & Slider -->
  <script>
    // Navbar toggle
    document.getElementById("menuBtn").addEventListener("click", () => {
      document.getElementById("mobileMenu").classList.toggle("hidden");
    });

    // Image Slider
    let sliderIndex = 0;
    const sliderImages = document.getElementById("slider-images");
    const sliderDots = document.querySelectorAll("#slider-dots .dot");

    function getSliderWidth() {
      return sliderImages.parentElement.clientWidth;
    }

    function showSlider(index) {
      sliderImages.style.transform = `translateX(-${index * getSliderWidth()}px)`;
      sliderDots.forEach((dot, i) => {
        dot.classList.remove("bg-green-500");
        dot.classList.add("bg-gray-300");
        if (i === index) dot.classList.add("bg-green-500");
      });
      sliderIndex = index;
    }

    function nextSlide() {
      showSlider((sliderIndex + 1) % 3);
    }

    function prevSlide() {
      showSlider((sliderIndex - 1 + 3) % 3);
    }

    sliderDots.forEach((dot, i) => dot.addEventListener("click", () => showSlider(i)));
    window.addEventListener("resize", () => showSlider(sliderIndex));
    showSlider(0);
    setInterval(nextSlide, 6000);
  </script>
</body>
</html>
