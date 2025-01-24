<?php
session_start();
include('koneksi.php');

// Check if the user is logged in
if (!isset($_SESSION['id_user'])) {
    $_SESSION['error'] = "Anda harus login terlebih dahulu.";
    header("Location: login.php");
    exit;
}

$id_user = $_SESSION['id_user']; // Get the id_user from the session

// Mengambil data produk dari database
$query_produk = "SELECT Id_makan, nama, harga FROM produk";
$result_produk = mysqli_query($koneksi, $query_produk);
if (!$result_produk) {
    die("Query gagal: " . mysqli_error($koneksi));
}

// Mengambil data user (cashier) dari database hanya yang memiliki role 'admin'
$query_user = "SELECT id_user, username FROM user WHERE role = 'admin'";
$result_user = mysqli_query($koneksi, $query_user);
if (!$result_user) {
    die("Query gagal: " . mysqli_error($koneksi));
}

// Get the username of the logged-in user
$query_user_details = "SELECT username FROM user WHERE id_user = '$id_user'";
$result_user_details = mysqli_query($koneksi, $query_user_details);
if ($result_user_details) {
    $user_details = mysqli_fetch_assoc($result_user_details);
    $username = $user_details['username'];
} else {
    die("Query gagal: " . mysqli_error($koneksi));
}
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Form Pembelian - Gilacoding</title>
    <style>
      /* CSS sama seperti sebelumnya */
      * { font-family: "Trebuchet MS"; }
      h1 { text-transform: uppercase; color: salmon; }
      button {
        background-color: rgb(34, 119, 153);
        color: #fff;
        padding: 10px;
        text-decoration: none;
        font-size: 12px;
        border: 0px;
        margin-top: 20px;
      }
      button:hover {
        background-color: rgb(17, 150, 203);
      }
      label { margin-top: 10px; float: left; text-align: left; width: 100%; }
      input, select { padding: 6px; width: 100%; box-sizing: border-box; background: #f8f8f8; border: 2px solid #ccc; outline-color: salmon; }
      div { width: 100%; height: auto; }
      .base { width: 400px; height: auto; padding: 20px; margin-left: auto; margin-right: auto; background: #ededed; }
      a { 
        background-color: rgb(34, 119, 153);
        color: #fff; 
        padding: 10px; text-decoration: none; font-size: 12px; }
      a:hover { 
        background-color: rgb(17, 150, 203);
      }
    </style>
  </head>
  <body>
    <a class="log" href="tampilan_produk_user.php">Kembali</a>
    <center>
      <h1>Form Pembelian</h1>
    </center>
    <form method="POST" action="process.beli.php">
      <section class="base">
        <div>
          <label>Nama Pembelian</label>
          <input type="text" name="nama_pembelian" value="<?php echo $username; ?>" readonly required />
        </div>
        <div>
          <label>Nama Produk</label>
          <select name="Id_makan" id="Id_makan" required onchange="updateHarga()">
            <option value="" disabled selected>Pilih Produk</option>
            <?php while ($row = mysqli_fetch_assoc($result_produk)): ?>
              <option value="<?php echo $row['Id_makan']; ?>" data-harga="<?php echo $row['harga']; ?>">
                <?php echo $row['nama']; ?>
              </option>
            <?php endwhile; ?>
          </select>
        </div>
        <div>
          <label>Cashier</label>
          <select name="id_user" required>
            <option value="" disabled selected>Pilih Cashier</option>
            <?php while ($row_user = mysqli_fetch_assoc($result_user)): ?>
              <option value="<?php echo $row_user['id_user']; ?>">
                <?php echo $row_user['username']; ?> <!-- Menampilkan username -->
              </option>
            <?php endwhile; ?>
          </select>
        </div>
        <div>
          <label>Harga Satuan</label>
          <input type="text" name="harga_satuan" id="harga_satuan" readonly required />
        </div>
        <div>
          <label>Jumlah</label>
          <input type="number" name="jumlah" required />
        </div>
        <div>
          <label>Catatan (Opsional)</label>
          <input type="text" name="catatan" />
        </div>
        <div>
          <button type="submit">Proses Pembelian</button>
        </div>
      </section>
    </form>
    <script>
      function updateHarga() {
        const select = document.getElementById('Id_makan');
        const hargaSatuanInput = document.getElementById('harga_satuan');
        const selectedOption = select.options[select.selectedIndex];

        // Ambil data-harga dari opsi yang dipilih
        const harga = selectedOption.getAttribute('data-harga');
        hargaSatuanInput.value = harga ? harga : '';
      }
    </script>
  </body>
</html>
      