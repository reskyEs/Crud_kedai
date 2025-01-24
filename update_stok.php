<?php
include('koneksi.php');

// Memulai session untuk mendapatkan ID user
session_start();

// Pastikan user sudah login dan memiliki ID user
if (!isset($_SESSION['id_user'])) {
    echo "<script>alert('Anda harus login terlebih dahulu!');window.location='login.php';</script>";
    exit;
}

$id_user = $_SESSION['id_user']; // ID user yang login

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $id_makan = mysqli_real_escape_string($koneksi, $_POST['Id_makan']);
    $stok_tambah = (int)$_POST['stok']; // Jumlah stok yang ingin ditambahkan

    if ($stok_tambah <= 0) {
        echo "<script>alert('Jumlah stok harus lebih dari 0!');window.location='makanan.php';</script>";
        exit;
    }

    // Ambil data produk
    $query_produk = "SELECT stok FROM produk WHERE Id_makan = $id_makan";
    $result_produk = mysqli_query($koneksi, $query_produk);

    if (mysqli_num_rows($result_produk) > 0) {
        $produk = mysqli_fetch_assoc($result_produk);
        $stok_sekarang = $produk['stok'];

        // Tambahkan stok baru
        $stok_baru = $stok_sekarang + $stok_tambah;

        // Update stok di database
        $query_update = "UPDATE produk SET stok = $stok_baru WHERE Id_makan = $id_makan";
        $result_update = mysqli_query($koneksi, $query_update);

        if ($result_update) {
            echo "<script>alert('Stok berhasil ditambahkan!');window.location='makanan.php';</script>";
        } else {
            echo "<script>alert('Gagal memperbarui stok!');window.location='makanan.php';</script>";
        }
    } else {
        echo "<script>alert('Produk tidak ditemukan!');window.location='makanan.php';</script>";
    }
} else {
    echo "<script>alert('Akses tidak valid!');window.location='makanan.php';</script>";
}
?>
