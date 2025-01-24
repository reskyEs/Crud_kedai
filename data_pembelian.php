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
if ($role === 'admin') {
    $query = "SELECT pembelian.*, produk.nama AS nama_produk, user.username AS nama_user 
              FROM pembelian 
              LEFT JOIN produk ON pembelian.Id_makan = produk.Id_makan 
              LEFT JOIN user ON pembelian.id_user = user.id_user";
    $stmt = $koneksi->prepare($query);
} else {
    $query = "SELECT pembelian.*, produk.nama AS nama_produk 
              FROM pembelian 
              LEFT JOIN produk ON pembelian.Id_makan = produk.Id_makan 
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
                    <a class="nav-link" href="data_pembelian.php">Pembelian</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="akun.php">Akun</a>
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
    
    <div class="container mt-5">
        <h1 class="text-center mb-4">Data Pembelian</h1>
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>No</th>
                    <?php if ($role === 'admin') { echo "<th>CASHIER</th>"; } ?>
                    <th>Nama Pembeli</th>
                    <th>Produk</th>
                    <th>Jumlah</th>
                    <th>Total Harga</th>
                    <th>Catatan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$no}</td>";
                    if ($role === 'admin') {
                        echo "<td>{$row['nama_user']}</td>";
                    }
                    echo "
                                <td>{$row['nama_pembelian']}</td>

                    <td>{$row['nama_produk']}</td>
                          <td>{$row['jumlah']}</td>
                          <td>Rp " . number_format($row['total_harga'], 0, ',', '.') . "</td>
                          <td>{$row['catatan']}</td>
                          <td>
                              <a href='hapus_pembelian.php?id_beli={$row['id_beli']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Apakah Anda yakin ingin menghapus data ini?\");'>Hapus</a>
                          </td>
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
