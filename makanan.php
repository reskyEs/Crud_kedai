<?php
session_start(); // Ensure the session is started before using session variables
include 'koneksi.php';

if (!isset($_SESSION['id_user'])) {
  $_SESSION['error'] = "Anda harus login terlebih dahulu.";
  header("Location: login.php");
  exit;
}
$id_user = $_SESSION['id_user'];

$kategori = isset($_GET['kategori']) ? mysqli_real_escape_string($koneksi, $_GET['kategori']) : '';

// Query untuk mengambil produk berdasarkan kategori
if ($kategori) {
    $query = "SELECT * FROM produk WHERE kategori = '$kategori' ORDER BY Id_makan ASC";
} else {
    $query = "SELECT * FROM produk ORDER BY Id_makan ASC";
}

$result = mysqli_query($koneksi, $query);

// Check for errors in the query
if (!$result) {
    die("Query Error: " . mysqli_errno($koneksi) . " - " . mysqli_error($koneksi));
}
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Menu Kedai Makanan</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <style>
      .nav {
        width: 100%;
        position: fixed;
        top: 0;
      }
      .active {
        background-color: gray;
      }

    
      .card {
  height: 100%; 
  display: flex;
  flex-direction: column;
  margin-bottom: 20px; 
}

.card img {
  height: 225px;
  object-fit: cover;
}

.card-body {
  flex-grow: 1; 
}
.row {
  margin-bottom: 20px; 
}

.lead {
  color:gray;
}



    </style>
  </head>
  <body id="page-top">
      
      <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
        <a class="navbar-brand" href="index.php">Kedai makanan</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
      
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav ">
            <li class="nav-item">
              <a class="nav-link " href="index.php">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="data_pembelian.php">Pembelian</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="akun.php">akun</a>
            </li>
             <li class="nav-item">
             <a class="nav-link" href="profile.php?id_user=<?php echo $id_user; ?>">Profile</a>
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

<main>
  <section class="py-2 text-center container">
    <div class="row py-lg-5">
      <div class="col-lg-6 col-md-8 mx-auto">
        <h1 class="fw-light">Menu Makanan Dan Minuman</h1>
        <p class="lead text-body-secondary">Warung Kedai adalah Warung Makanan</p>
        <p>
          <a href="tmb_produk.php" class="btn btn-primary my-2">Tambah Produk</a>
        </p>
      </div>
    </div>
  </section>

  <div class="album py-5 bg-body-tertiary">
  <div class="container">
    <?php
    $count = 0; 
    while ($row = mysqli_fetch_assoc($result)) {
        

        if ($count % 3 === 0) {
            echo '<div class="row">';
        }
    ?>
        <div class="col-md-4 mb-4"> 
          <div class="card shadow-sm h-100">
            <img src="gambar/<?php echo $row['gambar']; ?>" class="card-img-top" alt="Thumbnail">
            <div class="card-body">
              <p class="card-text"><?php echo $row['nama']; ?></p>
              <small class="text-body-secondary">Stok <?php echo $row['stok']; ?></small>
              <p class="card-text"><?php echo substr($row['tentang'], 0, 100); ?></p>
              <div class="d-flex justify-content-between align-items-center">
                <div class="btn-group">
                  <button type="button" class="btn btn-sm btn-outline-danger" onclick="hapusProduk(<?php echo $row['Id_makan']; ?>)">Hapus</button>
                  <button type="button" class="btn btn-sm btn-outline-secondary" onclick="window.location.href='edit_produk.php?Id_makan=<?php echo $row['Id_makan']; ?>'">Edit</button>
                  <button type="button" class="btn btn-sm btn-outline-primary" onclick="window.location.href='tambah_stock.php?Id_makan=<?php echo $row['Id_makan']; ?>'">tambah stock</button>
                </div>
                <small class="text-body-secondary">Rp <?php echo number_format($row['harga'], 0, ',', '.'); ?></small>
              </div>
            </div>
          </div>
        </div>
    <?php
        $count++;

       
        if ($count % 3 === 0) {
            echo '</div>';
        }
    }

   
    if ($count % 3 !== 0) {
        echo '</div>';
    }
    ?>
  </div>
</div>

</main>

<script>
function hapusProduk(id) {
  if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
    window.location.href = 'hapus_produk.php?Id_makan=' + id;
  }
}
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
