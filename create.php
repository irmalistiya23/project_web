<?php
session_start(); // Memulai session

include "koneksi.php";

$search = ""; // Variabel pencarian kosong secara default

// Jika ada input pencarian, gunakan input tersebut untuk query
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
    <!-- Main Stylesheets -->
    <link rel="stylesheet" href="css/style.css"/>
    <style>
        /* Styling untuk buttons */
        .btn {
            background: linear-gradient(45deg, #1e90ff, #ff8c00);
            background-size: 200% auto;
            color: white;
            border: none;
            padding: 10px 25px;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s ease;
            margin: 5px;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .btn:hover {
            background-position: right center;
            transform: scale(1.05);
            box-shadow: 0 5px 15px rgba(30, 144, 255, 0.3);
            color: white;
        }

        /* Khusus untuk button secondary (Kembali) */
        .btn-secondary {
            background: linear-gradient(45deg, #ff8c00, #1e90ff);
            background-size: 200% auto;
        }

        /* Styling untuk form container */
        .container {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
            margin-bottom: 50px;
        }

        /* Styling untuk form groups */
        .form-group {
            margin-bottom: 20px;
        }

        .form-control {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 10px;
        }

        .form-control:focus {
            border-color: #1e90ff;
            box-shadow: 0 0 5px rgba(30, 144, 255, 0.3);
        }
    </style>
</head>
<body>
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
                <li><a href="create.php" class="active">Create</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="contact.php">Contact</a></li>
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
      reverseButtons: true // Membalik posisi tombol Ya dan Tidak
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = 'index.php'; // Arahkan ke halaman index
      } 
      // Jika "Tidak" dipilih, tidak perlu aksi, tetap di halaman
    });
  });
</script>
        </nav>
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

    <!-- Form untuk Upload Foto -->
    <div class="container mt-5">
        <h2 class="text-center">Upload Foto</h2>

        <form action="user_dashboard.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="judulFoto">Judul Foto:</label>
                <input type="text" class="form-control" name="judulFoto" id="judulFoto" required>
            </div>

            <div class="form-group">
                <label for="deskripsiFoto">Deskripsi Foto:</label>
                <textarea class="form-control" name="deskripsiFoto" id="deskripsiFoto" rows="3" required></textarea>
            </div>

            <div class="form-group">
                <label for="berkas">Pilih Foto:</label>
                <input type="file" class="form-control-file" name="berkas" id="berkas" required>
            </div>

            <div class="form-group">
                <label for="albumID">Pilih Album:</label>
                <select class="form-control" name="albumID" id="albumID" required>
                    <?php
                    // Mengambil daftar album dari database
                    $albumQuery = mysqli_query($con, "SELECT * FROM album");
                    while ($album = mysqli_fetch_assoc($albumQuery)) {
                        echo "<option value='" . $album['AlbumID'] . "'>" . htmlspecialchars($album['NamaAlbum']) . " (" . htmlspecialchars($album['JenisAlbum']) . ")</option>";
                    }
                    ?>
                </select>
            </div>

            <button type="submit" class="btn" name="upload">Unggah Foto</button>
            <a href="user_dashboard.php" class="btn btn-secondary">Kembali ke Dashboard</a>
        </form>
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
