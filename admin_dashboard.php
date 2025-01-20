<?php
session_start();
include "koneksi.php";

$search = ""; // Variabel pencarian kosong secara default

// Cek jika pengguna sudah login dan simpan role di session
if (!isset($_SESSION['role'])) {
    header("Location: login.php");
    exit;
}

$role = $_SESSION['role']; // Admin atau User
$search = "";

// Jika ada input pencarian, gunakan input tersebut untuk query
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['search'])) {
    $search = $_GET['search'];
}

// Query untuk mendapatkan data portfolio foto berdasarkan role
if ($role == 'admin') {
    // Admin dapat melihat semua foto dan user
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
        " . ($search ? "WHERE (foto.JudulFoto LIKE '%$search%' OR foto.DeskripsiFoto LIKE '%$search%')" : "") . "
        GROUP BY foto.FotoID
    ");

    $user_query = mysqli_query($con, "SELECT Username, Email FROM user WHERE Role = 'user'");
} elseif ($role == 'user') {
    // User hanya bisa melihat fotonya sendiri
    $userID = $_SESSION['userID'];  // ID pengguna yang login
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
        WHERE foto.UserID = '$userID'
        " . ($search ? "AND (foto.JudulFoto LIKE '%$search%' OR foto.DeskripsiFoto LIKE '%$search%')" : "") . "
        GROUP BY foto.FotoID
    ");
}
?>

<!DOCTYPE html>
<html lang="zxx">
<head>
    <title>Picture</title>
    <link rel="icon" href="img/logo4.jpg" type="image/jpg">
    <meta charset="UTF-8">
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
        .gallery-warp {
            display: flex;
            flex-wrap: wrap;
            gap: 10px; /* Adjust the space between images if needed */
        }

        .gallery-item {
            flex: 1 1 100%; /* This ensures each item takes up full width */
            max-width: 100%;
            position: relative;
        }

        .image-container {
            position: relative;
            overflow: hidden;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 100%; /* Ensure it takes full width */
        }

        .image-container img {
            width: 100%;
            height: auto;
            display: block;
        }

        .image-container:hover img {
            transform: scale(1.05); /* Slight zoom effect on hover */
            transition: transform 0.3s ease;
        }

        /* Styling untuk tabel */
.table {
    border-collapse: collapse;
    width: 100%;
    margin-bottom: 1rem;
    background-color: #fff;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.1); /* Menambah shadow untuk depth */
}

.table th, .table td {
    padding: 0.75rem;
    vertical-align: top;
    text-align: left;
    border-top: 1px solid #e0e0e0;
}

.table th {
    background-color: #1e90ff; /* Warna biru untuk header */
    color: white;
    font-weight: bold;
}

.table img {
    width: 100px;
    height: auto;
    border-radius: 8px;
    transition: transform 0.3s ease;
}

.table img:hover {
    transform: scale(1.1);
}

.table td {
    vertical-align: middle;
}

/* Responsif untuk tampilan mobile */
.table-responsive {
    overflow-x: auto;
}

/* Styling untuk tombol delete */
.delete-btn {
    background: linear-gradient(45deg, #1e90ff, #ff8c00);
    background-size: 200% auto;
    color: white;
    border: none;
    padding: 8px 15px;
    border-radius: 4px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.delete-btn:hover {
    background-position: right center;
    transform: scale(1.05);
    box-shadow: 0 5px 15px rgba(30, 144, 255, 0.3);
}

/* Styling untuk heading */
.content-container h3 {
    font-size: 1.8rem;
    color: #333; /* Mengubah warna menjadi hitam */
    margin-bottom: 1.5rem;
    text-align: center;
    font-weight: bold;
    padding-bottom: 10px;
    border-bottom: 2px solid #1e90ff;
}

/* Styling untuk container konten */
.content-container {
    background-color: #ffffff;
    padding: 25px;
    border-radius: 10px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    margin-bottom: 30px;
}

/* Styling untuk baris tabel yang di-hover */
.table tbody tr:hover {
    background-color: #f8f9ff; /* Warna biru sangat muda saat hover */
}

/* Styling untuk notifikasi kosong */
.text-center {
    font-style: italic;
    color: #888;
}

/* Styling untuk tabel data user */
.table.user-table {
    width: 80%; /* Mengatur lebar tabel */
    margin: 0 auto; /* Membuat tabel berada di tengah */
    border: 1px solid #e0e0e0; /* Menambah border untuk tabel */
}

.table.user-table th,
.table.user-table td {
    border: 1px solid #e0e0e0; /* Menambah border untuk setiap sel */
    text-align: center; /* Teks di tengah */
    padding: 12px; /* Padding yang lebih besar */
}

.table.user-table th {
    background-color: #1e90ff;
    color: white;
    font-weight: bold;
    border-color: #187bcd; /* Border header yang lebih gelap */
}

.table.user-table tbody tr:nth-child(even) {
    background-color: #f8f9ff; /* Warna strip-strip pada baris */
}

.table.user-table tbody tr:hover {
    background-color: #e8f0fe; /* Warna hover yang lebih jelas */
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
                <li><a href="userdashboard.php" class="active">Home</a></li>
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

    <!-- Content Section -->
    <div class="container mt-5">
        <!-- Admin Section: Menampilkan foto dan data user -->
        <?php if ($role == 'admin'): ?>
        <div class="content-container">
            <h3>Data Portfolio User:</h3>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Foto</th>
                        <th>Judul Foto</th>
                        <th>Deskripsi Foto</th>
                        <th>Tanggal</th>
                        <th>Album</th>
                        <th>User Upload</th>
                        <th>Jumlah Komentar</th>
                        <th>Jumlah Like</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (mysqli_num_rows($query) > 0) {
                        $no = 1;
                        while ($row = mysqli_fetch_assoc($query)) {
                            ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><img src="berkas/<?= htmlspecialchars($row['LokasiFoto']) ?>" alt="Foto"></td>
                                <td><?= htmlspecialchars($row['JudulFoto']) ?></td>
                                <td><?= htmlspecialchars($row['DeskripsiFoto']) ?></td>
                                <td><?= htmlspecialchars($row['TanggalUnggah']) ?></td>
                                <td><?= htmlspecialchars($row['NamaAlbum']) ?></td>
                                <td><?= htmlspecialchars($row['Username']) ?></td>
                                <td><?= htmlspecialchars($row['JumlahKomentar']) ?></td>
                                <td><?= htmlspecialchars($row['JumlahLike']) ?></td>
                                <td>
                                    <button class="delete-btn" 
                                            onclick="window.location.href='delete.php?id=<?= $row['FotoID'] ?>'">
                                        Delete
                                    </button>
                                </td>
                            </tr>
                            <?php
                        }
                    } else {
                        echo "<tr><td colspan='10' class='text-center'>Tidak ada data ditemukan</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- Data User Section: Tampil hanya untuk admin -->
        <div class="content-container mt-5">
            <h3>Data User:</h3>
            <table class="table table-striped user-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Username</th>
                        <th>Email</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (mysqli_num_rows($user_query) > 0) {
                        $no = 1;
                        while ($row = mysqli_fetch_assoc($user_query)) {
                            ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= htmlspecialchars($row['Username']) ?></td>
                                <td><?= htmlspecialchars($row['Email']) ?></td>
                            </tr>
                            <?php
                        }
                    } else {
                        echo "<tr><td colspan='3' class='text-center'>Tidak ada data user ditemukan</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <?php elseif ($role == 'user'): ?>
        <!-- User Section: Menampilkan foto hanya milik user -->
        <div class="content-container">
            <h3>Data Portfolio Anda:</h3>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Foto</th>
                        <th>Judul Foto</th>
                        <th>Deskripsi Foto</th>
                        <th>Tanggal</th>
                        <th>Album</th>
                        <th>Jumlah Komentar</th>
                        <th>Jumlah Like</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (mysqli_num_rows($query) > 0) {
                        $no = 1;
                        while ($row = mysqli_fetch_assoc($query)) {
                            ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><img src="berkas/<?= htmlspecialchars($row['LokasiFoto']) ?>" alt="Foto"></td>
                                <td><?= htmlspecialchars($row['JudulFoto']) ?></td>
                                <td><?= htmlspecialchars($row['DeskripsiFoto']) ?></td>
                                <td><?= htmlspecialchars($row['TanggalUnggah']) ?></td>
                                <td><?= htmlspecialchars($row['NamaAlbum']) ?></td>
                                <td><?= htmlspecialchars($row['JumlahKomentar']) ?></td>
                                <td><?= htmlspecialchars($row['JumlahLike']) ?></td>
                            </tr>
                            <?php
                        }
                    } else {
                        echo "<tr><td colspan='8' class='text-center'>Tidak ada data ditemukan</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>
    </div>

    <!-- Javascripts -->
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