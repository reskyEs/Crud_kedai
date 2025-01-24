<?php
include 'koneksi.php';

// Ambil kategori dari URL, jika ada
$kategori = isset($_GET['kategori']) ? mysqli_real_escape_string($koneksi, $_GET['kategori']) : '';

// Query untuk mengambil produk berdasarkan kategori
if ($kategori) {
  $query = "SELECT * FROM produk WHERE kategori = '$kategori' AND stok > 0 ORDER BY Id_makan ASC";
} else {
  $query = "SELECT * FROM produk WHERE stok > 0 ORDER BY Id_makan ASC";
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
      body{
      
      background-image: url('gambar/1.jpg'); 
      background-size: cover; 
      background-position: center; 
      margin: 0;
      

    }
    </style>
  </head>
  <body id="page-top">
      
      <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
        <a class="navbar-brand" href="tampilan_user.php">Kedai makanan</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
      
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav ">
            <li class="nav-item">
              <a class="nav-link " href="tampilan_user.php">Home <span class="sr-only">(current)</span></a>
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
            <a class="nav-link" href="logout.php">Keluar</a>
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
         
        </p>
      </div>
    </div>
  </section>

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
                <button type="button" class="btn btn-sm btn-outline-primary" onclick="window.location.href='beli.php'">beli</button>
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
