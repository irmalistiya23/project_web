<?php
session_start(); 

include "koneksi.php";

// Debug session
error_log("Detail page session: " . print_r($_SESSION, true));

$search = ""; 

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['search'])) {
    $search = $_GET['search'];
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

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
            COUNT(DISTINCT komentarfoto.KomentarID) AS JumlahKomentar,
            COUNT(DISTINCT LikeFoto.LikeID) AS JumlahLike
        FROM 
            foto
        INNER JOIN user ON foto.UserID = user.UserID
        INNER JOIN album ON foto.AlbumID = album.AlbumID
        LEFT JOIN komentarfoto ON foto.FotoID = komentarfoto.FotoID
        LEFT JOIN LikeFoto ON foto.FotoID = LikeFoto.FotoID
        WHERE foto.LokasiFoto = '$id'
        GROUP BY foto.FotoID
    ");

    $row = mysqli_fetch_assoc($query);
} else {
    // Jika ID tidak ada, redirect ke halaman utama (gallery)
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="zxx">
<head>
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
    <link href="https://cdn.jsdelivr.net/npm/boxicons/css/boxicons.min.css" rel="stylesheet">
    <!-- Main Stylesheets -->
    <link rel="stylesheet" href="css/style.css"/>
    <style>
        .gallery-warp {
            display: flex;
            flex-wrap: wrap;
            gap: 10px; /* Adjust the space between images if needed */
        }

        .gallery-item {
            flex: 1 1 100%;
            max-width: 100%;
            position: relative;
        }

        .image-container {
            position: relative;
            overflow: hidden;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 100%;  
        }

        .image-container img {
            width: 100%;
            height: auto;
            display: block;
        }

        .image-container:hover img {
            transform: scale(1.05); /* ngezoom pas diarahin kursor */
            transition: transform 0.3s ease;
        }

        /* Main image in detail view */
        .image-wrapper {
            width: 100%;
            max-height: 600px;
            overflow: hidden;
            border-radius: 8px;
        }

        .image-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .thumbnail-gallery {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 20px;
            padding: 20px 0;
        }

        .thumbnail-gallery a {
            display: block;
            aspect-ratio: 1;
            overflow: hidden;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .thumbnail-gallery img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .thumbnail-gallery img:hover {
            transform: scale(1.05);
        }

        .btn-save {
        background-color: #007bff; /* Biru */
        color: white;
        border: none;
        padding: 10px 20px;
        font-size: 16px;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
        }

        .btn-save:hover {
            background-color: #0056b3; /* Biru gelap saat hover */
        }        
    </style>
</head>
<body>
    <div id="preloder">
        <div class="loader"></div>
    </div>

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
                <li><a href="index.php">Logout</a></li>
            </ul>
        </nav>
        <div class="sm-footer">
            <div class="sm-socail">
                <a href="#"><i class="ti-facebook"></i></a>
                <a href="#"><i class="ti-twitter-alt"></i></a>
                <a href="#"><i class="ti-linkedin"></i></a>
                <a href="#"><i class="ti-instagram"></i></a>
            </div>
            <div class="copyright-text">
                <p>Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="ti-heart" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a></p>
            </div>
        </div>
    </div>

    <p style="display: flex; align-items: center; gap: 10px;">
        <a href="user_dashboard.php" class="back-arrow">
            <i class="bx bx-left-arrow-alt"></i>
        </a>
        <h2>Detail:</h2>
    </p>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6">
                <div class="image-wrapper">
                <img src="berkas/<?php echo htmlspecialchars($row['LokasiFoto']); ?>" class="img-fluid" alt="<?php echo htmlspecialchars($row['JudulFoto']); ?>">
                </div>
            </div>

            <div class="col-md-6">
                <div class="container">
                    <div class="notification" style="display: flex; align-items: center; justify-content: space-between;">
                        <div class="like-info">
                            <?php
                            if (isset($_SESSION['UserID'])) {
                                $userID = $_SESSION['UserID'];
                                $fotoID = $row['FotoID'];
                                $checkLike = mysqli_query($con, "SELECT LikeID FROM likefoto WHERE UserID='$userID' AND FotoID='$fotoID'");
                                $isLiked = mysqli_num_rows($checkLike) > 0;
                            } else {
                                $isLiked = false;
                            }
                            ?>
                            <i class="bx <?php echo $isLiked ? 'bxs-heart' : 'bx-heart'; ?>" 
                               style="color: <?php echo $isLiked ? 'red' : 'inherit'; ?>; cursor: pointer; font-size: 24px;">
                            </i>
                            <span id="like-count"><?php echo $row['JumlahLike']; ?></span>
                        </div>

                        <div class="info-icon">
                            <i class="bx bx-upload" id="shareButton" style="cursor: pointer;"></i>
                        </div>

                        <div class="info-icon">
                            <i class="bx bx-dots-horizontal-rounded"></i>
                        </div>

                        <!-- Download Button -->
                        <a href="berkas/<?php echo htmlspecialchars($row['LokasiFoto']); ?>" download="<?php echo htmlspecialchars($row['JudulFoto']); ?>">
                            <button class="btn-save">Download</button>
                        </a>
                    </div>

                    <script>
                        const likeButton = document.querySelector('.bx-heart, .bxs-heart');
                        const likeCountSpan = document.getElementById('like-count');
                        const fotoID = <?php echo $row['FotoID']; ?>;

                        likeButton.addEventListener('click', function() {
                            const formData = new FormData();
                            formData.append('fotoID', fotoID);

                            fetch('like_photo.php', {
                                method: 'POST',
                                body: formData
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    // Update like count
                                    likeCountSpan.textContent = data.likeCount;
                                    
                                    // Toggle heart icon and color
                                    if (data.isLiked) {
                                        likeButton.classList.remove('bx-heart');
                                        likeButton.classList.add('bxs-heart');
                                        likeButton.style.color = 'red';
                                    } else {
                                        likeButton.classList.remove('bxs-heart');
                                        likeButton.classList.add('bx-heart');
                                        likeButton.style.color = 'inherit';
                                    }
                                } else {
                                    alert('Please login to like photos');
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                alert('Error processing like');
                            });
                        });
                    </script>

                    <div class="description">
                        <h1><?php echo htmlspecialchars($row['JudulFoto']); ?></h1>
                        <p><?php echo htmlspecialchars($row['DeskripsiFoto']); ?></p>
                    </div>

                    <!-- Comments Section -->
                    <div class="comments">
                        <p><strong>Comments</strong></p>
                        <div id="comments-container">
                            <?php
                            // Get comments for this photo
                            $commentQuery = mysqli_query($con, "
                                SELECT k.*, u.Username, u.Profile 
                                FROM komentarfoto k 
                                JOIN user u ON k.UserID = u.UserID 
                                WHERE k.FotoID = '{$row['FotoID']}'
                                ORDER BY k.TanggalKomentar DESC
                            ");

                            while ($comment = mysqli_fetch_assoc($commentQuery)) {
                                $profileImage = isset($comment['Profile']) ? $comment['Profile'] : 'default.jpg';
                                echo '<div class="comment" style="display: flex; align-items: center; margin-bottom: 20px;">';
                                echo '<p><img src="berkas/' . htmlspecialchars($profileImage) . '" alt="Profile" style="width: 50px; height: 50px; border-radius: 50%; margin-right: 10px;">' . htmlspecialchars($comment['IsiKomentar']) . '</p>';
                                echo '<p><small>' . htmlspecialchars($comment['TanggalKomentar']) . '</small></p>';
                                echo '</div>';
                            }
                            ?>
                        </div>
                    </div>

                    <!-- Comment Form -->
                    <div class="comments-box">
                        <form id="commentForm">
                            <div class="comments-container" style="display: flex; align-items: center; gap: 10px;">
                                <input type="text" name="comment" placeholder="Add a comment" class="comments-input" required style="flex-grow: 1;">
                                <input type="hidden" name="fotoID" value="<?= $row['FotoID']; ?>">
                                <div class="comments-icon" style="display: flex; align-items: center; gap: 10px;">
                                    <i class='bx bxs-smile'></i>
                                    <i class='bx bx-sticker'></i>
                                    <i class='bx bx-image'></i>
                                    <button type="submit" style="background: none; border: none; cursor: pointer;">
                                        <i class='bx bx-send'></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <script>
                        document.getElementById('commentForm').addEventListener('submit', function(e) {
                            e.preventDefault();
                            
                            const formData = new FormData(this);
                            
                            fetch('add_comment.php', {
                                method: 'POST',
                                body: formData
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    // Create new comment element
                                    const commentDiv = document.createElement('div');
                                    commentDiv.className = 'comment';
                                    commentDiv.style.display = 'flex';
                                    commentDiv.style.alignItems = 'center';
                                    commentDiv.style.marginBottom = '20px';
                                    
                                    commentDiv.innerHTML = `
                                        <p><img src="berkas/${data.profile}" alt="Profile" style="width: 50px; height: 50px; border-radius: 50%; margin-right: 10px;">
                                        ${data.comment}</p>
                                        <p><small>${data.date}</small></p>
                                    `;
                                    
                                    // Add new comment to the top of the comments container
                                    const container = document.getElementById('comments-container');
                                    container.insertBefore(commentDiv, container.firstChild);
                                    
                                    // Clear the input field
                                    this.reset();
                                } else {
                                    alert('Error adding comment: ' + data.message);
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                alert('Error adding comment');
                            });
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>

    <div class="container my-5">
        <div class="thumbnail-gallery">
            <?php
            $thumbnailQuery = mysqli_query($con, "
                SELECT 
                    foto.LokasiFoto, 
                    foto.JudulFoto, 
                    foto.DeskripsiFoto, 
                    foto.TanggalUnggah, 
                    album.NamaAlbum
                FROM foto
                INNER JOIN album ON foto.AlbumID = album.AlbumID
                ORDER BY foto.TanggalUnggah DESC
            ");
            if (mysqli_num_rows($thumbnailQuery) > 0) {
                while ($thumbnailRow = mysqli_fetch_assoc($thumbnailQuery)) {
                    echo '<a href="detail.php?id=' . urlencode($thumbnailRow['LokasiFoto']) . '">';
                    echo '<img src="berkas/' . htmlspecialchars($thumbnailRow['LokasiFoto']) . '" alt="' . htmlspecialchars($thumbnailRow['JudulFoto']) . '">';
                    echo '</a>';
                }
            } else {
                echo '<p class="text-center">Belum ada gambar yang diunggah.</p>';
            }
            ?>
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

    <!-- Add this modal after the info-icon div -->
    <div class="modal fade" id="shareModal" tabindex="-1" role="dialog" aria-labelledby="shareModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="shareModalLabel">Share Image</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="shareForm">
                            <input type="hidden" name="fotoID" value="<?php echo $row['FotoID']; ?>">
                            <div class="form-group">
                                <label for="recipientUsername">Recipient's Username</label>
                                <input type="text" class="form-control" id="recipientUsername" name="recipientUsername" required>
                            </div>
                            <div class="form-group">
                                <label for="message">Message (Optional)</label>
                                <textarea class="form-control" id="message" name="message" rows="3"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Share</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add this script before the closing body tag -->
    <script>
        $(document).ready(function() {
            // Show modal when upload icon is clicked
            $('#shareButton').click(function() {
                $('#shareModal').modal('show');
            });

            // Handle form submission
            $('#shareForm').submit(function(e) {
                e.preventDefault();
                
                const formData = new FormData(this);
                
                fetch('share_photo.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Image shared successfully!');
                        $('#shareModal').modal('hide');
                    } else {
                        alert('Error sharing image: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error sharing image');
                });
            });
        });
    </script>
</body>
</html>
