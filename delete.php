<?php
session_start();
include "koneksi.php"; // Pastikan file koneksi ke database sudah benar

// Cek apakah user sudah login dan memiliki role admin
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit;
}

// Cek apakah ada parameter id
if (isset($_GET['id'])) {
    $fotoID = $_GET['id'];
    
    // Hapus data foto
    $query = mysqli_query($con, "DELETE FROM foto WHERE FotoID = '$fotoID'");
    
    if ($query) {
        // Jika berhasil, redirect ke admin_dashboard.php
        header("Location: admin_dashboard.php");
        exit;
    } else {
        // Jika gagal, redirect dengan pesan error
        header("Location: admin_dashboard.php?error=1");
        exit;
    }
} else {
    // Jika tidak ada parameter id, redirect ke admin_dashboard
    header("Location: admin_dashboard.php");
    exit;
}
?>