<?php
  include('koneksi.php'); //agar index terhubung dengan database, maka koneksi sebagai penghubung harus di include
  
?>
<!DOCTYPE html>
<html>
  <head>
    <title>CRUD Produk dengan gambar - Gilacoding</title>
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
    input {
      padding: 6px;
      width: 100%;
      box-sizing: border-box;
      background: #f8f8f8;
      border: 2px solid #ccc;
      outline-color: salmon;
    }
    select{
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
            background-color: salmon;
            color: #fff;
            padding: 10px;
            text-decoration: none;
            font-size: 12px;
        }
        a:hover {
  background-color: #E9967A;
  
}
    </style>
  </head>
  <body>
  <a class="log" href="makanan.php">keluar</a>
        <center>
        <h1>Tambah Produk</h1>
      <center>
      <form method="POST" action="process.tambah.php" enctype="multipart/form-data" >
      <section class="base">
        <div>
          <label>Nama Produk</label>
          <input type="text" name="nama" autofocus="" required="" />
        </div>
        <div>
    <label for="kategori">Kategori</label>
    <select name="kategori" id="kategori">
        <option value="makanan">Makanan</option>
        <option value="minuman">Minumana</option>
        <option value="dessert">Dessert</option>
       
    </select>
</div>
        <div>
          <label>Harga</label>
         <input type="text" name="harga" required="" />
        </div>
        <div>
          <label>Gambar Produk </label>
         <input type="file" name="gambar" required="" />
        </div>
        <div>
        <div>
          <label>tentang</label>
         <input type="text" name="tentang" required="" />
        </div>
        <div>
          <label>stok</label>
         <input type="number" name="stok" required="" />

        </div>
        <div>
         <button type="submit">Simpan Produk</button>
        </div>
        </section>
      </form>
  </body>
</html>