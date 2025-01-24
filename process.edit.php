<?php
include('koneksi.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['Id_makan'];
    $nama = $_POST['nama'];
    $kategori = $_POST['kategori'];
    $harga = $_POST['harga'];
    $tentang = $_POST['tentang'];
    $stok    = $_POST['stok'];

    //  upload gambar jika ada
    if (isset($_FILES['gambar']) && $_FILES['gambar']['size'] > 0) {
        $gambar = $_FILES['gambar']['name'];
        $tmp = $_FILES['gambar']['tmp_name'];
        move_uploaded_file($tmp, "uploads/" . $gambar);

        $query = "UPDATE produk SET nama='$nama', kategori='$kategori', harga='$harga', tentang='$tentang', stok='$stok' gambar='$gambar' WHERE Id_makan='$id'";
    } else {
        $query = "UPDATE produk SET nama='$nama', kategori='$kategori', harga='$harga', tentang='$tentang', stok='$stok' WHERE Id_makan='$id'";
    }

    if (mysqli_query($koneksi, $query)) {
        header("Location: makanan.php");
    } else {
        echo "Gagal mengupdate data: " . mysqli_error($koneksi);
    }
}
?>
