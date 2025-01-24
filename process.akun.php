<?php
session_start();
include('koneksi.php'); // Menghubungkan ke database

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = mysqli_real_escape_string($koneksi, $_POST['password']);
    $email = mysqli_real_escape_string($koneksi, $_POST['email']);

    // Validasi email unik
    $checkEmail = mysqli_query($koneksi, "SELECT * FROM user WHERE email = '$email'");
    if (mysqli_num_rows($checkEmail) > 0) {
        $_SESSION['error'] = "Email sudah terdaftar.";
        header("Location: tambah_akun.php"); // Kembali ke halaman form
        exit;
    }

    // Hash password untuk keamanan
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Masukkan data ke tabel users
    $query = "INSERT INTO user (username, password, email, role) VALUES ('$username', '$hashedPassword', '$email', 'user')";
    $result = mysqli_query($koneksi, $query);

    if ($result) {
        $_SESSION['success'] = "Akun berhasil dibuat.";
        header("Location: login.php"); // Redirect ke halaman login
    } else {
        $_SESSION['error'] = "Terjadi kesalahan: " . mysqli_error($koneksi);
        header("Location: tambah_akun.php");
    }
} else {
    // Jika bukan POST request, redirect ke halaman form
    header("Location: tambah_akun.php");
}
?>
