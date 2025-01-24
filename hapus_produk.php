<?php
// Memanggil file koneksi.php untuk melakukan koneksi ke database
include 'koneksi.php';

// Mendapatkan ID produk dari URL
$id_produk = $_GET['Id_makan'];

// Pastikan ID produk ada
if (isset($id_produk)) {
    // Query untuk menghapus produk berdasarkan ID
    $query = "DELETE FROM produk WHERE Id_makan = $id_produk";
    $result = mysqli_query($koneksi, $query);

    // Mengecek apakah query berhasil
    if ($result) {
        echo "<script>alert('Produk berhasil dihapus.');window.location='makanan.php';</script>";
    } else {
        echo "<script>alert('Gagal menghapus produk.');window.location='makanan.php';</script>";
    }
} else {
    echo "<script>alert('ID produk tidak valid.');window.location='makanan.php';</script>";
}
?>
