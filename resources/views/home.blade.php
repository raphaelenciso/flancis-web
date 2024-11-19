<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Flanci's Concept Longue</title>

  <script src="{{ asset('css/tailwind.css') }}"></script>

  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css">

  <style>
    .font-playfair {
      font-family: 'Playfair Display', serif;
    }

    .font-inter {
      font-family: 'Inter', sans-serif;
    }

    /* Custom Swiper Navigation Styles */
    .swiper-button-next,
    .swiper-button-prev {
      width: 40px;
      height: 40px;
      background-color: #7D4D00;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .swiper-button-next:after,
    .swiper-button-prev:after {
      display: none;
      /* Hide default swiper icons */
    }

    .swiper-button-disabled {
      opacity: 0.5;
    }
  </style>
</head>

<body class="bg-white font-inter">
  <!-- Header -->
  <header class="bg-white py-6 shadow-sm fixed w-full z-30">
    <div class="container mx-auto px-4 max-w-7xl flex justify-between items-center">
      <div class="flex items-center">
        <span class="font-playfair text-xl font-bold">Flanci's Concept Longue</span>
      </div>
      <nav class="hidden md:block">
        <ul class="flex space-x-8">
          <li><a href="#hero" class="text-[#1E1E1E] hover:text-[#7D4D00] nav-link font-medium">Home</a></li>
          <li><a href="#features" class="text-[#1E1E1E] hover:text-[#7D4D00] nav-link font-medium">Features</a></li>
          <li><a href="#services" class="text-[#1E1E1E] hover:text-[#7D4D00] nav-link font-medium">Services</a></li>
          <li><a href="#about" class="text-[#1E1E1E] hover:text-[#7D4D00] nav-link font-medium">About</a></li>
          <li><a href="#contact" class="text-[#1E1E1E] hover:text-[#7D4D00] nav-link font-medium">Contact</a></li>
        </ul>
      </nav>
      <div class="hidden md:flex space-x-4">
        <a class="bg-[#7D4D00] text-white font-semibold py-2 px-4 rounded-full hover:bg-[#5A3800] transition duration-300" href='/signup'>Sign Up</a>
      </div>
      <button id="mobile-menu-button" class="md:hidden text-[#1E1E1E]">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
        </svg>
      </button>
    </div>
    <div id="mobile-menu" class="hidden md:hidden bg-white shadow-md">
      <ul class="py-2">
        <li><a href="#hero" class="block px-4 py-2 text-[#1E1E1E] hover:bg-[#FFF9F0] nav-link">Home</a></li>
        <li><a href="#features" class="block px-4 py-2 text-[#1E1E1E] hover:bg-[#FFF9F0] nav-link">Features</a></li>
        <li><a href="#services" class="block px-4 py-2 text-[#1E1E1E] hover:bg-[#FFF9F0] nav-link">Services</a></li>
        <li><a href="#about" class="block px-4 py-2 text-[#1E1E1E] hover:bg-[#FFF9F0] nav-link">About</a></li>
        <li><a href="#contact" class="block px-4 py-2 text-[#1E1E1E] hover:bg-[#FFF9F0] nav-link">Contact</a></li>
        <li><a href='/signin' class="block px-4 py-2 text-[#7D4D00] hover:bg-[#FFF9F0] font-semibold">Log in</a></li>
        <li><a href='/signup' class="block px-4 py-2 text-[#7D4D00] hover:bg-[#FFF9F0] font-semibold">Sign Up</a></li>
      </ul>
    </div>
  </header>

  <!-- Hero Section -->
  <section id="hero" class="bg-[#FFF9F0]">
    <div class="container mx-auto px-4 max-w-7xl flex items-center pt-24 relative min-h-[700px]">
      <div class="lg:w-1/2 lg:mb-0">
        <h1 class="text-5xl font-bold text-[#1E1E1E] mb-6 leading-tight font-playfair">Relax And Pamper Yourself</h1>
        <p class="text-xl text-[#1E1E1E] mb-8">Experience the art of indulgence and relaxation. Discover the ultimate experience in beauty and self-care right here.</p>
        <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
          <a class="bg-white text-[#7D4D00] font-bold py-3 px-6 rounded-full border-2 border-[#7D4D00] hover:bg-[#FFF9F0] transition duration-300 flex items-center justify-center" href="/signin">
            Book Now
          </a>
        </div>
      </div>
      <div class="hidden lg:block absolute bottom-0 right-0">
        <div class="w-[450px] h-[450px] rounded-full bg-[#ffd3b6] absolute bottom-[30px] right-[100px] z-10 blur-[30px]"></div>
        <img src="{{ asset('images/hero-img.png') }}" alt="Hero Image" class="w-full max-w-[850px] h-auto relative z-20">
      </div>
    </div>
  </section>

  <!-- Feature Sections -->
  <section id="features" class="py-32">
    <div class="container mx-auto px-4 max-w-7xl">
      <h2 class="text-5xl font-bold text-[#7D4D00] mb-20 text-center font-playfair">Features</h2>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
        <!-- Feature 1 -->
        <div class="text-center">
          <img src="{{ asset('icons/real-time-icon.svg') }}" alt="Real-time Icon" class="w-24 h-24 mx-auto mb-6">
          <h3 class="text-2xl font-bold text-black mb-4">Real-time Updates</h3>
          <p class="text-[#665244]">Stay informed with instant updates on your appointments and bookings.</p>
        </div>

        <!-- Feature 2 -->
        <div class="text-center">
          <img src="{{ asset('icons/scheduling-icon.svg') }}" alt="Scheduling Icon" class="w-24 h-24 mx-auto mb-6">
          <h3 class="text-2xl font-bold text-black mb-4">Flexible Scheduling</h3>
          <p class="text-[#665244]">Easily manage your schedule with flexible appointment booking options.</p>
        </div>

        <!-- Feature 3 -->
        <div class="text-center">
          <img src="{{ asset('icons/customers-icon.svg') }}" alt="Customers Icon" class="w-24 h-24 mx-auto mb-6">
          <h3 class="text-2xl font-bold text-black mb-4">Customer Management</h3>
          <p class="text-[#665244]">Efficiently track and manage customer information and preferences.</p>
        </div>

      </div>
    </div>
  </section>

  <!-- Services Section -->
  <section id="services" class="bg-[#FFF9F0] py-32 overflow-hidden">
    <div class="container mx-auto px-4 max-w-7xl">
      <div class="mb-12">
        <h2 class="text-5xl font-bold text-[#7D4D00] mb-4 text-center font-playfair">Our Services</h2>
        <p class="text-center text-[#665244] max-w-2xl mx-auto">
          Indulge in our top-notch treatments, all set within a serene environment designed for your comfort and rejuvenation. Our dedicated team is here to ensure you unwind and experience the ultimate in self-care.
        </p>
      </div>
      <div class="relative px-12">
        <div class="swiper-container">
          <div class="swiper-wrapper">
            @foreach($serviceTypes as $serviceType)
            <div class="swiper-slide">
              <div class="w-64 mx-auto relative group">
                <img src="{{ asset($serviceType->service_image) }}" alt="{{ $serviceType->service_type }}" class="w-full h-48 object-cover rounded-lg mb-2">
                <h3 class="text-xl font-bold text-[#7D4D00] mb-1 text-center">{{ $serviceType->service_type }}</h3>
                <div class="absolute inset-0 bg-black bg-opacity-75 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col justify-center items-center p-4 overflow-y-auto">
                  @foreach($serviceType->services as $service)
                  <div class="text-white mb-2">
                    <h4 class="font-semibold">{{ $service->service_name }}</h4>
                  </div>
                  @endforeach
                </div>
              </div>
            </div>
            @endforeach
          </div>
          <!-- Custom Navigation Arrows -->
          <div class="swiper-button-prev">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M15 18l-6-6 6-6" />
            </svg>
          </div>
          <div class="swiper-button-next">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M9 18l6-6-6-6" />
            </svg>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- About Us Section -->
  <section id="about" class="py-32">
    <div class="container mx-auto px-4 max-w-7xl">
      <h2 class="text-5xl font-bold text-[#492D00] mb-12 text-center font-playfair">About Us</h2>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="text-center bg-[#FFF7F1] p-6 rounded-lg">
          <img src="{{ asset('images/about-us-images/our-beauty-longue.png') }}" alt="Our Beauty Lounge" class="w-full h-48 object-cover rounded-lg mb-4">
          <h3 class="text-2xl font-bold text-[#492D00] mb-2 capitalize font-playfair">Our Beauty Lounge</h3>
          <p class="text-black ">At Flanci's Concept Lounge, we provide a luxurious and relaxing environment where you can unwind and indulge in top-notch beauty treatments. Our lounge is designed to offer a serene and rejuvenating experience, with a team dedicated to your comfort and well-being.</p>
        </div>
        <div class="text-center bg-[#FFF7F1] p-6 rounded-lg">
          <img src="{{ asset('images/about-us-images/our-services.png') }}" alt="Our Services" class="w-full h-48 object-cover rounded-lg mb-4">
          <h3 class="text-2xl font-bold text-[#492D00] mb-2 capitalize font-playfair">Our Services</h3>
          <p class="text-black text-sm">We offer a wide range of beauty services, including handcare and footcare treatments, manicures, pedicures, gluta drips, and more. Our experienced professionals use the latest techniques and high-quality products to ensure you leave feeling refreshed and beautiful.</p>
        </div>
        <div class="text-center bg-[#FFF7F1] p-6 rounded-lg">
          <img src="{{ asset('images/about-us-images/our-team.png') }}" alt="Our Team" class="w-full h-48 object-cover rounded-lg mb-4">
          <h3 class="text-2xl font-bold text-[#492D00] mb-2 capitalize font-playfair">Our Team</h3>
          <p class="text-black text-sm">Our team consists of highly trained and passionate beauty experts who are committed to providing exceptional service. They stay up-to-date with the latest trends and techniques to ensure you receive the best care and advice.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Contact Us Section -->
  <section id="contact" class="bg-[#553500] py-32">
    <div class="container mx-auto px-4 max-w-7xl">
      <div class="flex flex-col md:flex-row">
        <div class="md:w-1/2 mb-8 md:mb-0">
          <h2 class="text-5xl font-bold text-white mb-8 font-inter">Contact Us</h2>
          <div class="text-white space-y-4">
            <div class="flex items-center">
              <svg class="w-6 h-6 mr-2" fill="#FECF08" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
              </svg>
              <span>flancilounge@gmail.com</span>
            </div>
            <div class="flex items-center">
              <svg class="w-6 h-6 mr-2" fill="#FECF08" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
              </svg>
              <span>Cabana street, ML Tagarao Corner, Lucena, Philippines</span>
            </div>
            <div class="flex items-center">
              <svg class="w-6 h-6 mr-2" fill="#FECF08" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"></path>
              </svg>
              <span>09974025470</span>
            </div>
            <div class="flex items-center">
              <svg class="w-6 h-6 mr-2" fill="#FECF08" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path d="M18.896 0H1.104C.494 0 0 .494 0 1.104v17.793C0 19.506.494 20 1.104 20h9.58v-7.745H8.076V9.237h2.606V7.01c0-2.583 1.578-3.99 3.883-3.99 1.104 0 2.052.082 2.329.119v2.7h-1.598c-1.254 0-1.496.597-1.496 1.47v1.928h2.989l-.39 3.018h-2.6V20h5.098c.608 0 1.102-.494 1.102-1.104V1.104C20 .494 19.506 0 18.896 0z" />
              </svg>
              <span>Flanci's Concept Lounge</span>
            </div>
          </div>
        </div>
        <div class="md:w-1/2">
          <form id="contactForm" class="space-y-4">
            @csrf
            <div>
              <input type="text" id="name" name="name" placeholder="Your Name" class="w-full px-3 py-2 bg-transparent border-b border-white text-white placeholder-white focus:outline-none focus:border-yellow-400" required>
            </div>
            <div>
              <input type="email" id="email" name="email" placeholder="Your Email" class="w-full px-3 py-2 bg-transparent border-b border-white text-white placeholder-white focus:outline-none focus:border-yellow-400" required>
            </div>
            <div>
              <textarea id="message" name="message" rows="4" placeholder="Message" class="w-full px-3 py-2 bg-transparent border-b border-white text-white placeholder-white focus:outline-none focus:border-yellow-400" required></textarea>
            </div>
            <button type="submit" class="bg-yellow-400 text-[#7D4D00] text-black font-bold py-3 px-6 rounded-full hover:bg-yellow-500 transition duration-300">Send Message</button>
          </form>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="bg-[#000] text-white py-8">
    <div class="container mx-auto px-4 max-w-7xl">
      <div class="flex flex-wrap justify-between items-center">
        <div class="w-full md:w-1/2 mb-6 md:mb-0">
          <h3 class="text-xl font-bold mb-4 font-playfair">Flanci's Concept Lounge</h3>
        </div>
        <div class="w-full md:w-1/2">
          <nav class="flex justify-end space-x-6">
            <a href="#home" class="nav-link text-gray-300 hover:text-white">Home</a>
            <a href="#features" class="nav-link text-gray-300 hover:text-white">Features</a>
            <a href="#services" class="nav-link text-gray-300 hover:text-white">Services</a>
            <a href="#about" class="nav-link text-gray-300 hover:text-white">About</a>
            <a href="#contact" class="nav-link text-gray-300 hover:text-white">Contact</a>
          </nav>
        </div>
      </div>
      <div class="mt-8 text-center">
        <p class="text-[#A89C93] text-sm">&copy; 2024 FLANCI'S CONCEPT LOUNGE. ALL RIGHTS RESERVED</p>
      </div>
    </div>
  </footer>

  <div id="successModal" class="fixed bottom-5 right-5 bg-white border border-green-500 rounded-lg shadow-lg p-6 hidden z-50">
    <div class="flex items-center">
      <svg class="w-6 h-6 text-green-500 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
      </svg>
      <p class="text-gray-800 font-semibold" id="modalMessage"></p>
    </div>
    <button id="closeModal" class="absolute top-2 right-2 text-gray-600 hover:text-gray-800">
      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
      </svg>
    </button>
  </div>



  <script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>

  <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>

  <script>
    $(document).ready(function() {
      // Mobile menu toggle
      $('#mobile-menu-button').click(function() {
        $('#mobile-menu').toggleClass('hidden');
      });

      // Smooth scrolling and active nav link
      function setActiveNavLink() {
        var hash = window.location.hash;
        $('.nav-link').each(function() {
          if ($(this).attr('href') === hash) {
            $(this).addClass('font-bold');
          } else {
            $(this).removeClass('font-bold');
          }
        });
      }

      $('.nav-link').click(function(e) {
        e.preventDefault();
        $('#mobile-menu').addClass('hidden');

        var targetId = $(this).attr('href');
        $('html, body').animate({
          scrollTop: $(targetId).offset().top
        }, 1000);

        // Update URL hash without scrolling
        history.pushState(null, null, targetId);
        setActiveNavLink();
      });

      $(window).on('hashchange', setActiveNavLink);
      $(window).on('load', setActiveNavLink);

      // Initialize Swiper
      var swiper = new Swiper('.swiper-container', {
        slidesPerView: 1,
        spaceBetween: 10,
        navigation: {
          nextEl: '.swiper-button-next',
          prevEl: '.swiper-button-prev',
        },
        breakpoints: {
          640: {
            slidesPerView: 2,
            spaceBetween: 20,
          },
          768: {
            slidesPerView: 3,
            spaceBetween: 30,
          },
          1024: {
            slidesPerView: 4,
            spaceBetween: 40,
          },
        },
      });

      $('#contactForm').on('submit', function(e) {
        e.preventDefault();

        var formData = $(this).serialize();

        $.ajax({
          url: "/contact",
          type: 'POST',
          data: formData,
          dataType: 'json',
          success: function(response) {
            console.log('Success:', response);
            // Show success modal
            $('#modalMessage').text(response.message);
            $('#successModal').removeClass('hidden');

            // Clear form fields
            $('#contactForm')[0].reset();

            // Auto-hide modal after 5 seconds
            setTimeout(function() {
              $('#successModal').addClass('hidden');
            }, 5000);
          },
          error: function(xhr, status, error) {
            console.error('Error:', xhr.responseText);
            // Show error message
            alert('An error occurred. Please try again later.');
          }
        });
      });
    });
  </script>
</body>

</html>