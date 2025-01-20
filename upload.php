<?php
session_start();
include "koneksi.php";

if (!isset($_SESSION['UserID'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['upload'])) {
    $judulFoto = mysqli_real_escape_string($con, $_POST['judulFoto']);
    $deskripsiFoto = mysqli_real_escape_string($con, $_POST['deskripsiFoto']);
    $albumID = mysqli_real_escape_string($con, $_POST['albumID']);
    $tanggalUnggah = date('Y-m-d');
    $userID = $_SESSION['UserID'];

    // Proses upload file
    if (isset($_FILES['berkas'])) {
        $file = $_FILES['berkas'];
        $fileName = $file['name'];
        $fileTmp = $file['tmp_name'];
        $fileSize = $file['size'];
        $fileError = $file['error'];

        // Mendapatkan ekstensi file
        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        // Ekstensi yang diperbolehkan
        $allowed = array('jpg', 'jpeg', 'png', 'gif');

        if (in_array($fileExt, $allowed)) {
            if ($fileError === 0) {
                if ($fileSize <= 5000000) { // Maksimal 5MB
                    // Buat nama file unik
                    $fileNameNew = uniqid('', true) . "." . $fileExt;
                    $fileDestination = 'berkas/' . $fileNameNew;

                    if (move_uploaded_file($fileTmp, $fileDestination)) {
                        // Insert ke database
                        $query = "INSERT INTO foto (JudulFoto, DeskripsiFoto, TanggalUnggah, LokasiFoto, AlbumID, UserID) 
                                 VALUES ('$judulFoto', '$deskripsiFoto', '$tanggalUnggah', '$fileNameNew', '$albumID', '$userID')";
                        
                        if (mysqli_query($con, $query)) {
                            header("Location: dashboard.php?status=success");
                            exit();
                        } else {
                            header("Location: create.php?error=db_error");
                            exit();
                        }
                    } else {
                        header("Location: create.php?error=upload_failed");
                        exit();
                    }
                } else {
                    header("Location: create.php?error=file_too_large");
                    exit();
                }
            } else {
                header("Location: create.php?error=file_error");
                exit();
            }
        } else {
            header("Location: create.php?error=invalid_type");
            exit();
        }
    }
}

header("Location: create.php?error=unknown");
exit();
?>
