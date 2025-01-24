<?php
// Memanggil file koneksi.php untuk melakukan koneksi ke database
include 'koneksi.php';

// Mendapatkan ID pembelian dari URL
$id_beli = $_GET['id_beli'];

// Pastikan ID pembelian ada
if (isset($id_beli)) {
    // Query untuk mendapatkan data pembelian
    $query_pembelian = "SELECT id_user, Id_makan, jumlah, total_harga FROM pembelian WHERE id_beli = $id_beli";
    $result_pembelian = mysqli_query($koneksi, $query_pembelian);

    if (mysqli_num_rows($result_pembelian) > 0) {
        $pembelian = mysqli_fetch_assoc($result_pembelian);
        $id_user = $pembelian['id_user'];
        $id_makan = $pembelian['Id_makan'];
        $jumlah = $pembelian['jumlah'];
        $total_harga = $pembelian['total_harga'];

        // 1. Perbarui stok produk (kurangi sesuai jumlah yang dibeli)
        $query_stok = "SELECT stok FROM produk WHERE Id_makan = $id_makan";
        $result_stok = mysqli_query($koneksi, $query_stok);
        if (mysqli_num_rows($result_stok) > 0) {
            $produk = mysqli_fetch_assoc($result_stok);
            $stok_lama = $produk['stok'];
            
            // Pastikan stok tidak menjadi negatif
            $stok_baru = $stok_lama + $jumlah;  // Menambahkan jumlah kembali ke stok lama
            if ($stok_baru < 0) {
                $stok_baru = 0;  // Jangan biarkan stok menjadi negatif
            }
            $query_update_stok = "UPDATE produk SET stok = $stok_baru WHERE Id_makan = $id_makan";
            mysqli_query($koneksi, $query_update_stok);
        }

        // 2. Perbarui dana pengguna (kurangi sesuai total harga yang dibayar)
        $query_user = "SELECT dana FROM user WHERE id_user = $id_user";
        $result_user = mysqli_query($koneksi, $query_user);
        if (mysqli_num_rows($result_user) > 0) {
            $user = mysqli_fetch_assoc($result_user);
            $dana_user = $user['dana'];
            $dana_baru = $dana_user  + $total_harga;  // Mengembalikan dana pengguna sesuai total harga
            $query_update_dana = "UPDATE user SET dana = $dana_baru WHERE id_user = $id_user";
            mysqli_query($koneksi, $query_update_dana);
        }

        // 3. Hapus data pembelian
        $query_delete = "DELETE FROM pembelian WHERE id_beli = $id_beli";
        $result_delete = mysqli_query($koneksi, $query_delete);

        // Mengecek apakah query berhasil
        if ($result_delete) {
            echo "<script>alert('Pembelian berhasil dihapus dan stok serta dana diperbarui.');window.location='data_pembelian.php';</script>";
        } else {
            echo "<script>alert('Gagal menghapus pembelian.');window.location='data_pembelian.php';</script>";
        }
    } else {
        echo "<script>alert('Pembelian tidak ditemukan.');window.location='data_pembelian.php';</script>";
    }
} else {
    echo "<script>alert('ID pembelian tidak valid.');window.location='data_pembelian.php';</script>";
}
?>
