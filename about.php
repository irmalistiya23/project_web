<?php
include "koneksi.php";

$search = ""; 

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['search'])) {
    $search = $_GET['search'];
}

$query = mysqli_query($con, "
    SELECT 
        foto.FotoID,
        foto.LokasiFoto,
        foto.JudulFoto,
        foto.DeskripsiFoto,
        foto.TanggalUnggah,
        foto.AlbumID,
        user.Username,
        album.NamaAlbum,
        COUNT(komentarfoto.KomentarID) AS JumlahKomentar,
        COUNT(likefoto.LikeID) AS JumlahLike
    FROM 
        foto
    INNER JOIN user ON foto.UserID = user.UserID
    INNER JOIN album ON foto.AlbumID = album.AlbumID
    LEFT JOIN komentarfoto ON foto.FotoID = komentarfoto.FotoID
    LEFT JOIN likefoto ON foto.FotoID = likefoto.FotoID
    " . ($search ? "WHERE foto.JudulFoto LIKE '%$search%' OR foto.DeskripsiFoto LIKE '%$search%'" : "") . "
    GROUP BY foto.FotoID
");
?>

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
                <li><a href="user_dashboard.php">Home</a></li>
                <li><a href="create.php">Create</a></li>
                <li><a href="about.php" class="active">About</a></li>
                <li><a href="contact.php">Contact</a></li>
                <li><a href="settings.php">Setting</a></li>
                <li><a href="index.php" id="logoutButton">Logout</a></li>
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

    <div class="about-container">
        <div class="container">
            <div class="about-header">
                <h1>About "Picture"</h1>
            </div>
            <div class="about-content">
                <p>Nama <span class="highlight">"Picture"</span> dipilih karena menggambarkan esensi utama dari platform ini, yaitu berbagi, mengabadikan, dan menghargai momen dalam bentuk foto. Setiap gambar adalah jendela ke dunia yang penuh warna, cerita, dan emosi, yang memungkinkan setiap orang untuk melihat dunia dari perspektif yang unik.</p>
                
                <p>Kata <span class="highlight">"Picture"</span> melambangkan lebih dari sekadar sebuah foto—ini adalah medium untuk mengekspresikan kreativitas, menggambarkan pengalaman, dan berbagi kisah hidup yang tak ternilai harganya. Dalam setiap gambar yang diabadikan, ada cerita yang menunggu untuk ditemukan, ada momen yang ingin dihargai, dan ada pesan yang ingin disampaikan kepada dunia.</p>
                
                <p>Dengan platform ini, <span class="highlight">"Picture"</span> bukan hanya tentang menyimpan gambar, tetapi juga tentang memberikan penghargaan pada setiap detik yang terabadikan melalui lensa kamera, serta menginspirasi orang lain dengan perspektif yang berbeda.</p>

                <div class="about-features">
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="ti-camera"></i>
                        </div>
                        <h3 class="feature-title">Berbagi Momen</h3>
                        <p>Abadikan dan bagikan momen spesial Anda</p>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="ti-heart"></i>
                        </div>
                        <h3 class="feature-title">Interaksi Sosial</h3>
                        <p>Terhubung dengan fotografer lainnya</p>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="ti-gallery"></i>
                        </div>
                        <h3 class="feature-title">Galeri Personal</h3>
                        <p>Kelola koleksi foto Anda</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--====== Javascripts & Jquery ======-->
    <script src="js/vendor/jquery-3.2.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/imagesloaded.pkgd.min.js"></script>
    <script src="js/isotope.pkgd.min.js"></script>
    <script src="js/jquery.nicescroll.min.js"></script>
    <script src="js/circle-progress.min.js"></script>
    <script src="js/pana-accordion.js"></script>
    <script src="js/fresco.min.js"></script>
    <script src="js/main.js"></script>
</body>
</html>