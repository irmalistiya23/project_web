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
                <li><a href="create.php">Create</a></li>
                <li><a href="about.php">About</a></li>
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

    <div class="container mt-5">
        <h1 class="text-center">Photo Gallery</h1>

        <form method="GET" action="" class="mb-4">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Search photos..." value="<?php echo htmlspecialchars($search); ?>">
                <button type="submit" class="btn btn-primary">Search</button>
            </div>
        </form>

        <div class="row">
            <?php if (mysqli_num_rows($query) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($query)): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <img src="berkas/<?php echo htmlspecialchars($row['LokasiFoto']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($row['JudulFoto']); ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($row['JudulFoto']); ?></h5>
                                <p class="card-text"><?php echo htmlspecialchars($row['DeskripsiFoto']); ?></p>
                                <p class="card-text"><small>Uploaded on: <?php echo htmlspecialchars($row['TanggalUnggah']); ?></small></p>
                                <p class="card-text">
                                    <i class="fa fa-heart"></i> <?php echo htmlspecialchars($row['JumlahLike']); ?> Likes
                                    <i class="fa fa-comment"></i> <?php echo htmlspecialchars($row['JumlahKomentar']); ?> Comments
                                </p>
                                <a href="detail.php?id=<?php echo urlencode($row['LokasiFoto']); ?>" class="btn btn-primary">View Details</a>
                                </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="text-center">No photos found.</p>
            <?php endif; ?>
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

    <script>
        function searchGallery() {
            var input, filter, galleryItems, title, i, txtValue;
            input = document.getElementById('searchInput');
            filter = input.value.toUpperCase();
            galleryItems = document.getElementsByClassName('gallery-item');
            
            for (i = 0; i < galleryItems.length; i++) {
                title = galleryItems[i].getElementsByTagName("h6")[0];
                if  (title) {
                    txtValue = title.textContent || title.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        galleryItems[i].style.display = "";
                    } else {
                        galleryItems[i].style.display = "none";
                    }
                }       
            }
        }
    </script>
</body>
</html>
