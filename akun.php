<?php
session_start();
require_once 'koneksi.php';

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['id_user'])) {
    $_SESSION['error'] = "Anda harus login terlebih dahulu.";
    header("Location: login.php");
    exit;
}

// Periksa apakah role adalah 'user'
if ($_SESSION['role'] !== 'admin') {
    $_SESSION['error'] = "Anda tidak memiliki akses ke halaman ini.";
    header("Location: index.php");
    exit;
}

// Ambil ID user dari sesi
$id_user = $_SESSION['id_user'];

// Query untuk mengambil data akun user yang sedang login
$query = "SELECT username, email FROM user WHERE id_user = ?";
$stmt = $koneksi->prepare($query);
$stmt->bind_param("i", $id_user);
$stmt->execute();
$result = $stmt->get_result();

if (!$result) {
    die("Query Error: " . $koneksi->error);
}

$user = $result->fetch_assoc();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" crossorigin="anonymous">
    <title>Kedai Makanan - Akun</title>
    <style>
        body {
            color: black;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
        <a class="navbar-brand" href="index.php">Kedai Makanan</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="data_pembelian.php">Pembelian</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="akun.php">Akun<span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
               <a class="nav-link" href='profile.php?id_user=<?php echo $id_user; ?>'">Profile</a>
              </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Kategori</a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="makanan.php?kategori=makanan">Makanan</a></li>
                        <li><a class="dropdown-item" href="makanan.php?kategori=minuman">Minuman</a></li>
                        <li><a class="dropdown-item" href="makanan.php?kategori=dessert">Dessert</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="makanan.php">Semua Menu</a></li>
                    </ul>
                </li>
            </ul>
            <li class="navbar-nav ml-auto">
                <a class="nav-link" href="logout.php">Logout</a>
            </li>
        </div>
    </nav>

    <?php
include('koneksi.php');

// Mengambil data user dan saldo dana dari tabel user
$query = "SELECT user.username, user.email
          FROM user";
$result = mysqli_query($koneksi, $query);

if (!$result) {
    die("Query Error: " . mysqli_error($koneksi));
}
?>

    <div class="container mt-5">
        <h1 class="text-center mb-4">Data akun</h1>
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                 
                    <th>Nama</th>
                    <th>Email</th>
                    
                  
                </tr>
            </thead>
            <tbody>
            <?php 
           
            while ($row = mysqli_fetch_assoc($result)) { ?>
      <tr>
        <td><?php echo htmlspecialchars($row['username']); ?></td>
        <td><?php echo htmlspecialchars($row['email']); ?></td>
      </tr>
    <?php } ?>
            </tbody>
        </table>  
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
