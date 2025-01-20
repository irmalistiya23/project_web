<?php
include "koneksi.php"; // Sertakan file koneksi

// Ambil data dari form login
$username = $_POST['username'] ?? '';
$password = md5($_POST['password'] ?? ''); // Enkripsi password

// Query untuk memeriksa kecocokan username dan password
$query = "SELECT * FROM user WHERE username = ? AND Password = ?";
$stmt = $con->prepare($query);
$stmt->bind_param("ss", $username, $password);

// Eksekusi query
$stmt->execute();
$result = $stmt->get_result();

// Cek apakah ada data yang cocok
if ($result->num_rows > 0) {
    // Ambil data pengguna
    $user = $result->fetch_assoc();

    // Periksa apakah username adalah 'admin' dan password adalah '123'
    if ($username == 'admin' && $password == md5('123')) {
        // Set session dan redirect ke halaman admin
        session_start();
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = 'admin';
        header("Location: admin_dashboard.php"); // Halaman admin
        exit();
    } else {
        // Set session dan redirect ke halaman user
        session_start();
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = 'user';
        header("Location: user_dashboard.php"); // Halaman user
        exit();
    }
} else {
    // Tampilkan pesan error jika login gagal
    echo "Username atau password salah.";
}

$stmt->close();
?>
