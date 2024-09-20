<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Flanci's Concept Lounge</title>

  <!-- CSS -->
  <link rel="stylesheet" href="{{ asset('css/sb-admin-2.css') }}">
  <link rel="stylesheet" href="{{ asset('css/main.css') }}">
  <link rel="stylesheet" href="{{ asset('css/overrides.css') }}">
  <link rel="stylesheet" href="{{ asset('css/home/hero.css') }}">
  <link rel="stylesheet" href="{{ asset('css/home/about-us.css') }}">
  <link rel="stylesheet" href="{{ asset('css/home/services.css') }}">
  <link rel="stylesheet" href="{{ asset('css/home/features.css') }}">
  <link rel="stylesheet" href="{{ asset('css/home/contact-us.css') }}">
  <link rel="stylesheet" href="{{ asset('css/home/footer.css') }}">


  <link rel="stylesheet" href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}">
</head>

<body>
  <!-- NAV BAR  -->
  <nav class="navbar navbar-expand-lg navbar-dark fixed-top" style="background-color: var(--primary-bg)">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">
        <img src="{{ asset('img/logo.png') }}" alt="Flanci's Concept Lounge" height="40" class="logo d-inline-block mr-2">
        Flanci's Concept Lounge
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link" href="#hero">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#about-us">About Us</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#services">Services</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#features">Features</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#contact-us">Contact Us</a>
          </li>
          <li class="nav-item">
            <a class="btn btn-outline-primary ml-2" href="/signup">Register Now!</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Add this alert section just after the navbar -->
  @if(session('success'))
  <div class="alert alert-success alert-dismissible fade show" role="alert" style="margin-top: 56px;">
    {{ session('success') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  @endif


  <!-- HERO SECTION  -->
  <section id="hero">
    <div class="left-container">
      <div class="text-container">
        <div class="text">
          <div class="icon">
            <!-- <i class="bx bxs-crown"></i> -->
          </div>
          <p class="top">
            <span>Relax </span>
            <span>and Pamper</span>
            <span>Yourself</span>
          </p>
          <p>Join us for an unforgettable experience and discover the true meaning of indulgence. Your journey to relaxation and beauty begins here.</p>
          <a href="/signin" class="button">Book Now</a>
        </div>
      </div>
    </div>

    <div class="right-container">
      <div class="carousel-container">
        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
          <ol class="carousel-indicators">
            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
          </ol>
          <div class="carousel-inner">
            <div class="carousel-item active">
              <img src="{{ asset('img/home7.jpg') }}" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
              <img src="{{ asset('img/home2jpg.jpg') }}" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
              <img src="{{ asset('img/home3.jpg') }}" class="d-block w-100" alt="...">
            </div>
          </div>
          <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
          </a>
          <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
          </a>
        </div>
      </div>
    </div>
  </section>

  <!-- ABOUT US SECTION  -->
  <section id="about-us" class="py-5">
    <div class="container">
      <h1 class="text-center mb-5">About Us</h1>
      <div class="row">
        <div class="col-md-4 mb-4">
          <div class="card h-100">
            <div class="card-body text-center">
              <i class="fas fa-building fa-3x mb-3 text-primary"></i>
              <h2 class="card-title">Our Beauty Lounge</h2>
              <p class="card-text">At Flanci's Concept Lounge, we provide a luxurious and relaxing environment where you can unwind and indulge in top-notch beauty treatments. Our lounge is designed to offer a serene and rejuvenating experience, with a team dedicated to your comfort and well-being.</p>
            </div>
          </div>
        </div>
        <div class="col-md-4 mb-4">
          <div class="card h-100">
            <div class="card-body text-center">
              <i class="fas fa-spa fa-3x mb-3 text-primary"></i>
              <h2 class="card-title">Our Services</h2>
              <p class="card-text">We offer a wide range of beauty services, including handcare and footcare treatments, manicures, pedicures, gluta drips, and more. Our experienced professionals use the latest techniques and high-quality products to ensure you leave feeling refreshed and beautiful.</p>
            </div>
          </div>
        </div>
        <div class="col-md-4 mb-4">
          <div class="card h-100">
            <div class="card-body text-center">
              <i class="fas fa-users fa-3x mb-3 text-primary"></i>
              <h2 class="card-title">Our Team</h2>
              <p class="card-text">Our team consists of highly trained and passionate beauty experts who are committed to providing exceptional service. They stay up-to-date with the latest trends and techniques to ensure you receive the best care and advice.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- SERVICES SECTION  -->
  <section id="services">
    <h1>Available Services</h1>
    <div class="container2">
      <div class="service">
        <img src="{{ asset('img/handcare.jpg') }}" alt="Hand Care">
        <h2 class="service-title">Hand Care</h2>
        <div class="service-details">
          <ul>
            <li>Manicure</li>
            <li>Nail Art</li>
            <li>Hand Massage</li>
          </ul>
        </div>
      </div>

      <div class="service">
        <img src="{{ asset('img/footcare.jpg') }}" alt="Foot Care">
        <h2 class="service-title">Foot Care</h2>
        <div class="service-details">
          <ul>
            <li>Pedicure</li>
            <li>Foot Massage</li>
            <li>Callus Removal</li>
          </ul>
        </div>
      </div>

      <div class="service">
        <img src="{{ asset('img/massage.jpg') }}" alt="Body Massage">
        <h2 class="service-title">Body Massage</h2>
        <div class="service-details">
          <ul>
            <li>Swedish Massage</li>
            <li>Deep Tissue Massage</li>
            <li>Hot Stone Massage</li>
          </ul>
        </div>
      </div>

      <div class="service">
        <img src="{{ asset('img/bodyscrub.jpg') }}" alt="Body Scrub">
        <h2 class="service-title">Body Scrub</h2>
        <div class="service-details">
          <ul>
            <li>Salt Scrub</li>
            <li>Sugar Scrub</li>
            <li>Coffee Scrub</li>
          </ul>
        </div>
      </div>

      <div class="service">
        <img src="{{ asset('img/eyelash.jpg') }}" alt="Eyelash">
        <h2 class="service-title">Eyelash</h2>
        <div class="service-details">
          <ul>
            <li>Eyelash Extensions</li>
            <li>Lash Lift</li>
            <li>Lash Tinting</li>
          </ul>
        </div>
      </div>

      <div class="service">
        <img src="{{ asset('img/waxing.jpg') }}" alt="Waxing">
        <h2 class="service-title">Waxing</h2>
        <div class="service-details">
          <ul>
            <li>Facial Waxing</li>
            <li>Body Waxing</li>
            <li>Brazilian Wax</li>
          </ul>
        </div>
      </div>

      <div class="service">
        <img src="{{ asset('img/gluta.jpg') }}" alt="Gluta">
        <h2 class="service-title">Gluta</h2>
        <div class="service-details">
          <ul>
            <li>Glutathione IV Drip</li>
            <li>Gluta Skin Whitening</li>
            <li>Gluta Supplements</li>
          </ul>
        </div>
      </div>
    </div>
  </section>

  <!-- FEATURES SECTION  -->
  <section id="features">
    <div class="container">
      <h1>Features</h1>
      <div class="feature-list">
        <div class="feature-item">
          <div class="feature-icon">
            <i class="fas fa-check-circle"></i>
          </div>
          <div class="feature-details">
            <h2>Real-time Updates</h2>
            <p>Stay informed with instant updates on your appointments and bookings.</p>
          </div>
        </div>
        <div class="feature-item">
          <div class="feature-icon">
            <i class="fas fa-calendar-alt"></i>
          </div>
          <div class="feature-details">
            <h2>Flexible Scheduling</h2>
            <p>Easily manage your schedule with flexible appointment booking options.</p>
          </div>
        </div>
        <div class="feature-item">
          <div class="feature-icon">
            <i class="fas fa-user-friends"></i>
          </div>
          <div class="feature-details">
            <h2>Customer Management</h2>
            <p>Efficiently track and manage customer information and preferences.</p>
          </div>
        </div>
      </div>
    </div>
  </section>


  <!-- CONTACT US SECTION  -->
  <section id="contact-us">
    <div class="container">
      <div class="contact-card">
        <div class="contact-details">
          <h1>Contact Us!</h1>
          <div class="social-media">
            <div class="social-icon-container">
              <i class="fas fa-map-marker-alt"></i>
              <a href="https://www.google.com/maps/place/83+M.+L.+Tagarao/@13.9368356,121.6082728,17z/data=!3m1!4b1!4m6!3m5!1s0x33bd4b64cfe6e53f:0xb4b04cbb094c6af1!8m2!3d13.9368304!4d121.6108477!16s%2Fg%2F11sm_8mkn_?entry=ttu" target="_blank" class="social-text">
                Cabana street, ML Tagarao Corner, Lucena, Philippines
              </a>
            </div>
            <div class="social-icon-container">
              <i class="fab fa-facebook-f"></i>
              <a href="https://www.facebook.com/profile.php?id=100092218879409&mibextid=ZbWKwL" target="_blank" class="social-text">
                Flanci's Concept Lounge
              </a>
            </div>
            <div class="social-icon-container">
              <i class="fas fa-phone"></i>
              <a href="tel:+639974025470" class="social-text">
                09974025470
              </a>
            </div>
            <div class="social-icon-container">
              <i class="fas fa-envelope"></i>
              <a href="mailto:flancilounge@gmail.com" class="social-text">
                flancilounge@gmail.com
              </a>
            </div>
          </div>
        </div>
        <div class="contact-form">
          <h2>Send us a Message</h2>
          <form id="contactForm">
            @csrf
            <div class="form-group">
              <label for="name">Name:</label>
              <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
              <label for="email">Email:</label>
              <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
              <label for="message">Message:</label>
              <textarea id="message" name="message" rows="4" required></textarea>
            </div>
            <button type="submit">Send Message</button>
          </form>
        </div>
      </div>
    </div>
  </section>

  <footer class="text-center py-3">
    <p class="mb-0">&copy; 2024 Flanci's Concept Lounge | All rights reserved.</p>
  </footer>

  <!-- JavaScript -->
  <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
  <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>
  <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>

  <!-- Add this script to auto-hide the alert after 5 seconds -->
  <script>
    $(document).ready(function() {
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
            // Show success message
            var alertHtml = `
              <div class="alert alert-success alert-dismissible fade show" role="alert" style="position: fixed; bottom: 20px; left: 20px; z-index: 1050; max-width: 300px;">
                ${response.message}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
            `;
            $('body').append(alertHtml);

            // Clear form fields
            $('#contactForm')[0].reset();

            // Auto-hide alert after 5 seconds
            setTimeout(function() {
              $('.alert').alert('close');
            }, 5000);
          },
          error: function(xhr, status, error) {
            console.error('Error:', xhr.responseText);
            // Show error message
            var alertHtml = `
              <div class="alert alert-danger alert-dismissible fade show" role="alert" style="position: fixed; bottom: 20px; left: 20px; z-index: 1050; max-width: 300px;">
                An error occurred. Please try again later.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
            `;
            $('body').append(alertHtml);
          }
        });
      });
    });
  </script>
</body>

</html>