<?php
// Memanggil file koneksi.php untuk melakukan koneksi ke database
include 'koneksi.php';

// Membuat variabel untuk menampung data dari form
$nama_produk   = $_POST['nama'];
$tentang       = $_POST['tentang'];
$harga         = $_POST['harga'];
$kategori      = $_POST['kategori'];
$stok          = $_POST['stok'];
$gambar_produk = $_FILES['gambar']['name'];

// Sanitasi input data untuk menghindari SQL Injection
$nama_produk   = mysqli_real_escape_string($koneksi, $nama_produk);
$tentang       = mysqli_real_escape_string($koneksi, $tentang);
$harga         = mysqli_real_escape_string($koneksi, $harga);
$kategori      = mysqli_real_escape_string($koneksi, $kategori);
$stok          = mysqli_real_escape_string($koneksi, $stok);

// Cek apakah ada gambar produk, jika ada lakukan proses upload gambar
if($gambar_produk != "") {
    $ekstensi_diperbolehkan = array('png', 'jpg', 'jpeg','jfif'); 
    $x = explode('.', $gambar_produk); 
    $ekstensi = strtolower(end($x));
    $file_tmp = $_FILES['gambar']['tmp_name'];   
    $angka_acak = rand(1, 999); 
    $nama_gambar_baru = $angka_acak . '-' . $gambar_produk;

    // Validasi ekstensi file gambar
    if(in_array($ekstensi, $ekstensi_diperbolehkan) === true) {
        // Memindahkan file gambar ke folder 'gambar'
        if (move_uploaded_file($file_tmp, 'gambar/' . $nama_gambar_baru)) {
            // Query untuk memasukkan data ke database
            $query = "INSERT INTO produk (nama, kategori, harga, tentang, stok, gambar) 
                      VALUES ('$nama_produk', '$kategori', '$harga', '$tentang', '$stok', '$nama_gambar_baru')";
            $result = mysqli_query($koneksi, $query);

            // Mengecek apakah query berhasil
            if (!$result) {
                die("Query gagal dijalankan: " . mysqli_errno($koneksi) . " - " . mysqli_error($koneksi));
            } else {
                // Menampilkan pesan sukses dan redirect ke halaman index.php
                echo "<script>alert('Data berhasil ditambah.');window.location='makanan.php';</script>";
            }
        } else {
            echo "<script>alert('Gagal mengupload gambar.');window.location='tambah_produk.php';</script>";
        }
    } else {
        // Jika ekstensi gambar tidak sesuai
        echo "<script>alert('Ekstensi gambar yang boleh hanya jpg atau png.');window.location='tambah_produk.php';</script>";
    }
} else {
    $query = "INSERT INTO produk (nama, kategori, harga, tentang, stok,  gambar) 
              VALUES ('$nama_produk', '$kategori', '$harga', '$tentang', '$stok', null)";
    $result = mysqli_query($koneksi, $query);

    if (!$result) {
        die("Query gagal dijalankan: " . mysqli_errno($koneksi) . " - " . mysqli_error($koneksi));
    } else {
        echo "<script>alert('Data berhasil ditambah.');window.location='makanan.php';</script>";
    }
}
?>
