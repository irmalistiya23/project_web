<?php
session_start();
include 'koneksi.php'; // Koneksi ke database menggunakan $con

// Check if user is logged in
if (!isset($_SESSION['UserID'])) {
    header("Location: set.php");
    exit();
}

// Ambil UserID dari session
$loggedInUserId = $_SESSION['UserID'];

// Ambil data pengguna
$query = "SELECT * FROM user WHERE UserID = ?";
$stmt = $con->prepare($query);  // Menggunakan $con bukan $conn
if ($stmt === false) {
    die('Prepare failed: ' . $con->error);
}

$stmt->bind_param('i', $loggedInUserId);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Proses jika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $profileImage = $_FILES['profile']['name'];

    // Update username
    if (!empty($username)) {
        $updateQuery = "UPDATE user SET Username = ? WHERE UserID = ?";
        $stmt = $con->prepare($updateQuery);
        if ($stmt === false) {
            die('Prepare failed: ' . $con->error);
        }
        $stmt->bind_param('si', $username, $loggedInUserId);
        $stmt->execute();
    }

    // Update profile picture jika ada file diupload
    if (!empty($profileImage)) {
        $targetDir = "berkas/"; // Folder untuk menyimpan foto
        $targetFile = $targetDir . basename($_FILES["profile"]["name"]);

        // Pastikan file berhasil di-upload
        if (move_uploaded_file($_FILES["profile"]["tmp_name"], $targetFile)) {
            $updateQuery = "UPDATE user SET Profile = ? WHERE UserID = ?";
            $stmt = $con->prepare($updateQuery);
            if ($stmt === false) {
                die('Prepare failed: ' . $con->error);
            }
            $stmt->bind_param('si', $profileImage, $loggedInUserId);
            $stmt->execute();
        } else {
            echo "Error uploading file.";
        }
    }

    // Refresh halaman setelah update
    header("Location: settings.php");
    exit();
}

// Ambil foto yang diunggah oleh pengguna
$queryPhotos = "SELECT * FROM foto WHERE UserID = ?";
$stmt = $con->prepare($queryPhotos);
if ($stmt === false) {
    die('Prepare failed: ' . $con->error);
}

$stmt->bind_param('i', $loggedInUserId);
$stmt->execute();
$resultPhotos = $stmt->get_result();
?>