<!DOCTYPE html>
<html lang="zxx">
<head>
    <meta charset="UTF-8">
    <title>Picture</title>
    <link rel="icon" href="img/logo4.jpg" type="image/jpg">
    <meta name="description" content="Tulen Photography HTML Template">
    <meta name="keywords" content="photo, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Stylesheets -->
    <link rel="stylesheet" href="css/bootstrap.min.css"/>
    <link rel="stylesheet" href="css/font-awesome.min.css"/>
    <link rel="stylesheet" href="css/themify-icons.css"/>
    <link rel="stylesheet" href="css/accordion.css"/>
    <link rel="stylesheet" href="css/owl.carousel.min.css"/>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Main Stylesheets -->
    <link rel="stylesheet" href="css/style.css"/>
    <style>
        .row {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            padding: 15px;
        }

        .col-md-4 {
            flex: 1 1 300px; /* Base width of 300px, but allows growth and shrinking */
            max-width: calc(33.333% - 20px); /* Maintain 3 columns with gap consideration */
            margin: 0; /* Remove default margins */
        }

        .card {
            height: 100%;
            display: flex;
            flex-direction: column;
            transition: transform 0.3s ease;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card-img-top {
            height: 200px;
            object-fit: cover;
        }

        .card-body {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .card-text {
            flex-grow: 1;
        }

        /* Responsive adjustments */
        @media (max-width: 992px) {
            .col-md-4 {
                max-width: calc(50% - 20px);
            }
        }

        @media (max-width: 576px) {
            .col-md-4 {
                max-width: 100%;
            }
        }

        /* Add these new styles after existing styles */
        .about-container {
            padding: 80px 0;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        }

        .about-header {
            text-align: center;
            margin-bottom: 50px;
        }

        .about-header h1 {
            font-size: 3.5rem;
            color: #333;
            margin-bottom: 20px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
            position: relative;
            display: inline-block;
        }

        .about-header h1:after {
            content: '';
            position: absolute;
            width: 60%;
            height: 3px;
            background: #007bff;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
        }

        .about-content {
            max-width: 800px;
            margin: 0 auto;
            padding: 30px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        .about-content p {
            font-size: 1.1rem;
            line-height: 1.8;
            color: #555;
            margin-bottom: 25px;
        }

        .highlight {
            color: #007bff;
            font-weight: 600;
            position: relative;
            display: inline-block;
        }

        .highlight:after {
            content: '';
            position: absolute;
            width: 100%;
            height: 2px;
            background: rgba(0,123,255,0.2);
            bottom: -2px;
            left: 0;
        }

        .about-features {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            margin-top: 40px;
        }

        .feature-item {
            text-align: center;
            padding: 20px;
            flex-basis: 250px;
            margin: 15px;
            background: #f8f9fa;
            border-radius: 10px;
            transition: transform 0.3s ease;
        }

        .feature-item:hover {
            transform: translateY(-5px);
        }

        .feature-icon {
            font-size: 2.5rem;
            color: #007bff;
            margin-bottom: 15px;
        }

        .feature-title {
            font-weight: 600;
            color: #333;
            margin-bottom: 10px;
        }

        .contact-container {
            padding: 80px 0;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        }

        .contact-header {
            text-align: center;
            margin-bottom: 50px;
        }

        .contact-header h1 {
            font-size: 3.5rem;
            color: #333;
            margin-bottom: 20px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
            position: relative;
            display: inline-block;
        }

        .contact-header h1:after {
            content: '';
            position: absolute;
            width: 60%;
            height: 3px;
            background: #007bff;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
        }

        .contact-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 30px;
        }

        .contact-info-box {
            background: white;
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }

        .contact-info-box:hover {
            transform: translateY(-5px);
        }

        .contact-info-item {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            padding: 15px;
            border-radius: 10px;
            background: #f8f9fa;
        }

        .contact-icon {
            font-size: 2rem;
            color: #007bff;
            margin-right: 20px;
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(0,123,255,0.1);
            border-radius: 50%;
        }

        .contact-text h3 {
            font-size: 1.2rem;
            color: #333;
            margin-bottom: 5px;
        }

        .contact-text p {
            color: #666;
            margin: 0;
        }

        .social-links {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 30px;
        }

        .social-link {
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: white;
            border-radius: 50%;
            color: #007bff;
            font-size: 1.5rem;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .social-link:hover {
            background: #007bff;
            color: white;
            transform: translateY(-3px);
        }

        .map-container {
            height: 100%;
            min-height: 450px;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            display: flex;
        }

        .map-container iframe {
            width: 100%;
            height: 100%;
            display: block;
            flex: 1;
        }

        /* Add these button styles to your existing style section */
        .btn-custom {
            padding: 10px 20px;
            margin: 5px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            transition: all 0.3s ease;
            color: white;
            background-size: 200% auto;
        }

        /* Style for both buttons - blue to orange gradient */
        .btn-custom {
            background: linear-gradient(45deg, #007bff, #00c6ff, #ff6b00, #ff9500);
            background-size: 300% 100%;
            transition: all 0.5s ease;
        }

        /* Hover effect - animate gradient */
        .btn-custom:hover {
            background-position: 100% 0;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 123, 255, 0.3);
        }
    </style>
</head>
<body>
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <!-- Offcanvas Menu Section -->
    <div class="menu-wrapper">
        <div class="menu-switch">
            <i class="ti-menu"></i>
        </div>
        <div class="menu-social-warp">
            <div class="menu-social">
                <a href="#"><i class="ti-facebook"></i></a>
                <a href="#"><i class="ti-twitter-alt"></i></a>
                <a href="#"><i class="ti-linkedin"></i></a>
                <a href="#"><i class="ti-instagram"></i></a>
            </div>
        </div>
    </div>

    <div class="side-menu-wrapper">
        <div class="sm-header">
            <div class="menu-close">
                <i class="ti-arrow-left"></i>
            </div>
            <a href="index.php" class="site-logo">
                <h2 style="color: white;">Picture</h2>
            </a>
        </div>
        <nav class="main-menu">
            <ul>
                <li><a href="user_dashboard.php" class="active">Home</a></li>
                </ul>
        </nav>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  document.getElementById('logoutButton').addEventListener('click', function(event) {
    event.preventDefault(); // Mencegah logout langsung
    Swal.fire({
      title: "Yakin ingin keluar?",
      text: "Anda akan diarahkan ke halaman utama.",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Ya",
      cancelButtonText: "Tidak",
      reverseButtons: true 
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = 'index.php';
      } 
    });
  });
</script>


        <div class="sm-footer">
            <div class="sm-socail">
                <a href="#"><i class="ti-facebook"></i></a>
                <a href="#"><i class="ti-twitter-alt"></i></a>
                <a href="#"><i class="ti-linkedin"></i></a>
                <a href="#"><i class="ti-instagram"></i></a>
            </div>
            <div class="copyright-text">
                <p>Copyright &copy;<script>document.write(new Date().getFullYear());</script></p>
            </div>
        </div>
    </div>
    <!-- Offcanvas Menu Section end -->

    <!-- Hero Section start -->
    <section class="hero-section">
        <div class="pana-accordion" id="accordion">
            <div class="pana-accordion-wrap">
                <div class="pana-accordion-item set-bg" data-setbg="berkas/animal.jpg">
                    <div class="pa-text">
                        <button class="btn-custom" onclick="window.location.href='login.php'">Login</button>
                        <button class="btn-custom" onclick="window.location.href='register.php'">Register</button>
                        <h2>Animal</h2>
                    </div>
                </div>
                <div class="pana-accordion-item set-bg" data-setbg="img/hero/1.jpg">
                    <div class="pa-text">
                        <button class="btn-custom" onclick="window.location.href='login.php'">Login</button>
                        <button class="btn-custom" onclick="window.location.href='register.php'">Register</button>
                        <h2>Style</h2>
                    </div>
                </div>
                <div class="pana-accordion-item set-bg" data-setbg="img/hero/2.jpg">
                    <div class="pa-text">
                        <button class="btn-custom" onclick="window.location.href='login.php'">Login</button>
                        <button class="btn-custom" onclick="window.location.href='register.php'">Register</button>
                        <h2>Pet</h2>
                    </div>
                </div>
                <div class="pana-accordion-item set-bg" data-setbg="berkas/mali.jpg">
                    <div class="pa-text">
                        <button class="btn-custom" onclick="window.location.href='login.php'">Login</button>
                        <button class="btn-custom" onclick="window.location.href='register.php'">Register</button>
                        <h2>Country</h2>
                    </div>
                </div>
                <div class="pana-accordion-item set-bg" data-setbg="img/hero/4.jpg">
                    <div class="pa-text">
                        <button class="btn-custom" onclick="window.location.href='login.php'">Login</button>
                        <button class="btn-custom" onclick="window.location.href='register.php'">Register</button>
                        <h2>Hobbies</h2>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Hero Section end -->

    <!-- Javascripts & Jquery -->
    <script src="js/vendor/jquery-3.2.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/imagesloaded.pkgd.min.js"></script>
    <script src="js/isotope.pkgd.min.js"></script>
    <script src="js/jquery.nicescroll.min.js"></script>
    <script src="js/circle-progress.min.js"></script>
    <script src="js/pana-accordion.js"></script>
    <script src="js/main.js"></script>
</body>
</html>
