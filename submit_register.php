<?php
include "koneksi.php"; // Sertakan file koneksi

// Ambil data dari form registrasi
$username = $_POST['username'] ?? '';
$password = md5($_POST['password'] ?? ''); // Enkripsi password
$email = $_POST['email'] ?? '';
$namaLengkap = $_POST['namalengkap'] ?? '';
$alamat = $_POST['alamat'] ?? '';
$profile = ''; // Profile default kosong

// Role default adalah 'user'
$role = 'user';

// Query untuk menyimpan data pengguna baru
$query = "INSERT INTO user (username, Password, Email, NamaLengkap, Alamat, Role, profile) VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmt = $con->prepare($query);
$stmt->bind_param("sssssss", $username, $password, $email, $namaLengkap, $alamat, $role, $profile);

// Eksekusi query dan tangani hasilnya
if ($stmt->execute()) {
    header("Location: login.php?success=1"); // Redirect ke halaman login dengan notifikasi sukses
    exit();
} else {
    // Tampilkan error jika query gagal
    echo "Error: " . $stmt->error;
    exit();
}

$stmt->close();
?>
