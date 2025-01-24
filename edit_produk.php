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
    <title>Edit Produk - Gilacoding</title>
    <style type="text/css">
      * {
        font-family: "Trebuchet MS";
      }
      h1 {
        text-transform: uppercase;
        color: salmon;
      }
      button {
        background-color: salmon;
        color: #fff;
        padding: 10px;
        text-decoration: none;
        font-size: 12px;
        border: 0px;
        margin-top: 20px;
      }
      label {
        margin-top: 10px;
        float: left;
        text-align: left;
        width: 100%;
      }
      input, select {
        padding: 6px;
        width: 100%;
        box-sizing: border-box;
        background: #f8f8f8;
        border: 2px solid #ccc;
        outline-color: salmon;
      }
      div {
        width: 100%;
        height: auto;
      }
      .base {
        width: 400px;
        height: auto;
        padding: 20px;
        margin-left: auto;
        margin-right: auto;
        background: #ededed;
      }
      a {
        background-color:rgb(34, 119, 153);
        color: #fff;
        padding: 10px;
        text-decoration: none;
        font-size: 12px;
      }
      a:hover {
        background-color:rgb(17, 150, 203);
      }
    </style>
  </head>
  <body>
    <a class="log" href="makanan.php">Kembali</a>
    <center>
      <h1>Edit Produk</h1>
    </center>
    <form method="POST" action="process.edit.php" enctype="multipart/form-data">
      <section class="base">
        <!-- Menyimpan ID sebagai input hidden -->
        <input type="hidden" name="Id_makan" value="<?php echo $product['Id_makan']; ?>" />
        <div>
          <label>Nama Produk</label>
          <input type="text" name="nama" value="<?php echo $product['nama']; ?>" required />
        </div>
        <div>
          <label for="kategori">Kategori</label>
          <select name="kategori" id="kategori">
            <option value="makanan" <?php if ($product['kategori'] == 'makanan') echo 'selected'; ?>>Makanan</option>
            <option value="minuman" <?php if ($product['kategori'] == 'minuman') echo 'selected'; ?>>Minuman</option>
            <option value="dessert" <?php if ($product['kategori'] == 'dessert') echo 'selected'; ?>>Dessert</option>
          </select>
        </div>
        <div>
          <label>Harga</label>
          <input type="text" name="harga" value="<?php echo $product['harga']; ?>" required />
        </div>
        <div>
          <label>Gambar Produk</label>
          <input type="file" name="gambar" />
          <p>Gambar saat ini: <img src="gambar/<?php echo $product['gambar']; ?>" width="100"></p>
        </div>
        <div>
          <label>Tentang</label>
          <input type="text" name="tentang" value="<?php echo $product['tentang']; ?>" required />
        </div>
        <div>
          <label>Tambah Stok</label>
          <input type="number" name="stok" value="<?php echo $stok['stok']; ?>" required />
        </div>
        <div>
          <button type="submit">Update Produk</button>
        </div>
      </section>
    </form>
  </body>
</html>
