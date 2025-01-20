<?php
// Koneksi ke database
$con = mysqli_connect("localhost", "root", "", "galdb");

if (!$con) {
    die('Koneksi database gagal: ' . mysqli_connect_error());
}
?>