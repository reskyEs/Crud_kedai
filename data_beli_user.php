<?php
session_start();
require_once "koneksi.php";

if (!isset($_SESSION['id_user'])) {
    $_SESSION['error'] = "Anda harus login terlebih dahulu.";
    header("Location: login.php");
    exit;
}

$id_user = $_SESSION['id_user'];
$role = $_SESSION['role']; // Ambil peran dari sesi

// Query berbeda berdasarkan role
if ($role === 'user') {
    $query = "SELECT pembelian.*, pembelian.nama_pembelian, user.username AS nama_user 
              FROM pembelian 
              LEFT JOIN user ON pembelian.id_user = user.id_user";
    $stmt = $koneksi->prepare($query);
} else {
    $query = "SELECT pembelian.*, pembelian.nama_pembelian 
              FROM pembelian 
              WHERE pembelian.id_user = ?";
    $stmt = $koneksi->prepare($query);
    $stmt->bind_param("i", $id_user);
}

$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <title>Data Pembelian</title>
</head>

<body id="page-top">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
        <a class="navbar-brand" href="index.php">Kedai Makanan</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ">
                <li class="nav-item active">
                    <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="data_beli_user.php">Pembelian</a>
                </li>
                
                <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Kategori</a>
      <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
        <li><a class="dropdown-item "href="tampilan_produk_user.php?kategori=makanan">Makanan</a></li>
        <li><a class="dropdown-item" href="tampilan_produk_user.php?kategori=minuman">Minuman</a></li>
        <li><a class="dropdown-item" href="tampilan_produk_user.php?kategori=dessert">Dessert</a></li>
        <li><hr class="dropdown-divider"></li>
        <li><a class="dropdown-item" href="tampilan_produk_user.php">Semua Menu</a></li>
      </ul>
    </li>
            </ul>
            <li class="navbar-nav ml-auto">
                <a class="nav-link" href="logout.php">Logout</a>
            </li>
        </div>
    </nav>
    
    <div class="container mt-5">
        <h1 class="text-center mb-4">Data Pembelian</h1>
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>No</th>
                    <?php if ($role === 'user') { echo "<th>Cashier</th>"; } ?>
                    <th>Nama Pembelian</th>
                    <th>Jumlah</th>
                    <th>Total Harga</th>
                    <th>Catatan</th>
                   
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
               while ($row = $result->fetch_assoc()) {
    echo "<tr>
            <td>{$no}</td>
            <td>{$row['nama_user']}</td>
            <td>{$row['nama_pembelian']}</td>
            <td>{$row['jumlah']}</td>
            <td>Rp " . number_format($row['total_harga'], 0, ',', '.') . "</td>
            <td>{$row['catatan']}</td>
          </tr>";
          $no++;

    }
                ?>
            </tbody>
        </table>  
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
