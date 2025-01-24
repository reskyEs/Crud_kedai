<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css">
    <title>Login Page</title>
    <style>
        body { 
            display: flex; 
            justify-content: center; 
            align-items: center; 
            height: 100vh; 
            margin: 0;
            background-color: #f8f9fa; 
            background-image: url('gambar/1.jpg'); 
            background-size: cover; /* Membuat gambar memenuhi layar */
            background-position: center; /* Memusatkan gambar */
            background-repeat: no-repeat; /* Tidak mengulang gambar */
        }
        .login-form { background-color: white; padding: 30px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); }
        .btn-primary { width: 100%; }
        .guest { text-align: center; margin-top: 10px; display: block; }
    </style>
</head>
<body>
    <form method="POST" action="process_login.php" class="login-form">
        <h3 class="text-center">Login</h3>
        <div class="form-group">
            <label>Username</label>
            <input type="text" class="form-control" name="username" placeholder="Masukkan username Anda" required>
        </div>
        <div class="form-group">
            <label>Password</label>
            <input type="password" class="form-control" name="password" placeholder="Masukkan password" required>
        </div>
        <button type="submit" name="submit" class="btn btn-primary">Login</button>
<div class="form-link">
    <a href="tambah_akun.php">buat akun</a>
</div>

    </form>
</body>
</html>
