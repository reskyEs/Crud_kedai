<?php
session_start();
require_once "koneksi.php";

if (!isset($_SESSION['id_user'])) {
    $_SESSION['error'] = "Anda harus login terlebih dahulu.";
    header("Location: login.php");
    exit;
}

$id_user = $_SESSION['id_user'];


$query = "SELECT pembelian.*, produk.nama AS nama_produk 
          FROM pembelian 
          LEFT JOIN produk ON pembelian.Id_makan = produk.Id_makan 
          WHERE pembelian.id_user = ?";
$stmt = $koneksi->prepare($query);
$stmt->bind_param("i", $id_user);
$stmt->execute();
$result = $stmt->get_result();
?>
    <!doctype html>
    <html lang="en">
      <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        


        <title>Hello, world!</title>
        <style>
          * {
            padding: 0;
            margin: 0;
          }
         
      body {
        background-color: #212529;
        height: 100vh;
        
        
      }
      .carousel-inner img {
    width: 70%; /* Sesuaikan lebar dengan container */
    height:92vb; /* Tinggi berdasarkan viewport */
    object-fit:fill; /* Hindari pemotongan gambar */
    background-color: black; /* Isi area kosong dengan warna hitam */
}


  .carousel-caption h5, .carousel-caption p {
      font-size: 1.2rem; /* Ukuran teks yang sesuai */
      padding: 10px;
      
  }

  .carousel-control-prev, .carousel-control-next {
    background-color: transparent;
    border-width: 0;
      width: 20px;
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
              <li class="nav-item active">
                <a class="nav-link " href="index.php">Home <span class="sr-only">(current)</span></a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="data_pembelian.php">Pembelian</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="akun.php ">akun</a>
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
        
        <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
          <div class="carousel-indicators">
              <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
              <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
              <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
          </div>
          <div class="carousel-inner">
              <!-- First Slide -->
              <div class="carousel-item active">
                
                  <a href="makanan.php?kategori=makanan">
                      <img src="gambar/makanan.jpg" class="d-block w-100" alt="First Slide">
                  </a>
                  <div class="carousel-caption d-none d-md-block">
                      <h5>Makanan</h5>
                      <p>makanan siap saji dan makanan besar.</p>
                  </div>
              </div>
              <!-- Second Slide -->
              <div class="carousel-item">
                  <a href="makanan.php?kategori=minuman">
                      <img src="gambar/minuman.jfif" class="d-block w-100" alt="Second Slide">
                  </a>
                  <div class="carousel-caption d-none d-md-block">
                      <h5>Minuman</h5>
                      <p>Minuman yang segar.</p>
                  </div>
              </div>
              <!-- Third Slide -->
              <div class="carousel-item">
                  <a href="makanan.php?kategori=dessert">
                      <img src="gambar/D.jfif" class="d-block w-100" alt="Third Slide">
                  </a>
                  <div class="carousel-caption d-none d-md-block">
                      <h5>Dessert</h5>
                      <p>cemelian atau makanan ringan</p>
                  </div>
              </div>
          </div>
          <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          </button>
          <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
          </button>
      </div>
      

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
          </body>
    </html>