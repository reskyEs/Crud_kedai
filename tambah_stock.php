<?php
  include('koneksi.php'); // Menghubungkan ke database
  // Mendapatkan ID produk dari URL
  if (isset($_GET['Id_makan'])) {
    $id = $_GET['Id_makan'];
    $query = "SELECT * FROM produk WHERE Id_makan = '$id'";
    $result = mysqli_query($koneksi, $query);

    // Mengecek apakah data ditemukan
    if (mysqli_num_rows($result) > 0) {
        $product = mysqli_fetch_assoc($result);
    } else {
        echo "Produk dengan ID tersebut tidak ditemukan!";
        exit;
    }
  } else {
    echo "ID produk tidak ditemukan!";
    exit;
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Detail Produk - Gilacoding</title>
    <style type="text/css">
      * {
        font-family: "Trebuchet MS";
      }
      h1 {
        text-transform: uppercase;
        color: black;
      }
      .detail {
        background: #f8f8f8;
        width: 400px;
        margin: 20px auto;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 8px;
      }
      .detail label {
        font-weight: bold;
        display: block;
        margin-top: 10px;
      }
      
     
      .back-link {
        text-align: center;
        margin-top: 20px;
      }
      .back-link a {
        background-color:rgb(34, 119, 153);

        color: #fff;
        padding: 10px 20px;
        text-decoration: none;
        border-radius: 5px;
      }
     a:hover {
      background-color:rgb(17, 150, 203);

      }
      button {
        background-color:rgb(34, 119, 153);
        color: #fff;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
      }
     button:hover {
        background-color:rgb(17, 150, 203);
      }
    </style>
  </head>
  <body>
    <div class="detail">
      <h1>Detail Produk</h1>
      <label>Nama Produk:</label>
      <span><?php echo htmlspecialchars($product['nama']); ?></span>

      
      <label>Stok:</label>
      <form method="POST" action="update_stok.php" class="update-stok">
        <input type="hidden" name="Id_makan" value="<?php echo htmlspecialchars($product['Id_makan']); ?>">
        <input type="number" name="stok" required>
        <button type="submit">Update Stock</button>
      </form>
    </div>
    <div class="back-link">
      <a href="makanan.php">Kembali</a>
    </div>
  </body>
</html>
