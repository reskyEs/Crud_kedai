<?php
include('koneksi.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $Id_produk = $_POST['Id_makan'];
    $id_user   = $_POST['id_user'];
    $jumlah = $_POST['jumlah'];
    $harga_satuan = $_POST['harga_satuan'];
    $catatan = isset($_POST['catatan']) ? $_POST['catatan'] : '';
    $nama_pembelian = isset($_POST['nama_pembelian']) ? $_POST['nama_pembelian'] : 'Pembelian Default';


    // Hitung total harga
    $total_harga = $jumlah * $harga_satuan;

    // Mulai transaksi
    mysqli_begin_transaction($koneksi);

    try {
        // Masukkan data pembelian ke tabel
        $query = "INSERT INTO pembelian (Id_makan, id_user, jumlah, harga_satuan, total_harga, catatan,nama_pembelian) 
                  VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($koneksi, $query);
        if (!$stmt) {
            throw new Exception("Gagal menyiapkan pernyataan SQL: " . mysqli_error($koneksi));
        }

        mysqli_stmt_bind_param($stmt, 'iiiidss', $Id_produk, $id_user, $jumlah, $harga_satuan, $total_harga, $catatan,$nama_pembelian);
        if (!mysqli_stmt_execute($stmt)) {
            throw new Exception("Gagal menjalankan pernyataan SQL: " . mysqli_stmt_error($stmt));
        }

        // Kurangi stok produk
        $update_stok_query = "UPDATE produk SET stok = stok - ? WHERE Id_makan = ? AND stok >= ?";
        $update_stmt = mysqli_prepare($koneksi, $update_stok_query);
        if (!$update_stmt) {
            throw new Exception("Gagal menyiapkan pernyataan pengurangan stok: " . mysqli_error($koneksi));
        }

        mysqli_stmt_bind_param($update_stmt, 'iii', $jumlah, $Id_produk, $jumlah);
        if (!mysqli_stmt_execute($update_stmt)) {
            throw new Exception("Gagal mengurangi stok: " . mysqli_stmt_error($update_stmt));
        }

        // Pastikan stok cukup
        if (mysqli_stmt_affected_rows($update_stmt) === 0) {
            throw new Exception("Stok tidak mencukupi.");
           
        }

        // Commit transaksi
        mysqli_commit($koneksi);
        echo "<script>alert('Terima kasih, pembelian berhasil.');window.location='tampilan_produk_user.php';</script>";
    } catch (Exception $e) {
        // Rollback jika ada kesalahan
        mysqli_rollback($koneksi);
        echo "Gagal memproses pembelian: " . $e->getMessage();
    } finally {
        // Tutup semua statement dan koneksi
        if (isset($stmt)) mysqli_stmt_close($stmt);
        if (isset($update_stmt)) mysqli_stmt_close($update_stmt);
        if (isset($update_dana_stmt)) mysqli_stmt_close($update_dana_stmt);

        mysqli_close($koneksi);
    }
}
?>
