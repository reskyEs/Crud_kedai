<?php
session_start();
require_once("koneksi.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password_verify = $_POST['password'];

    $sql = "SELECT * FROM user WHERE username = ?";
    $stmt = $koneksi->prepare($sql);
    
    $stmt->bind_param("s", $username); 
    
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password_verify, $user['password'])) {
            
            $_SESSION['id_user'] = $user['id_user'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role'];

            if ($user['role'] === 'admin') {
                header("Location: index.php");
            } elseif ($user['role'] === 'user') {
                header("Location: tampilan_user.php");
            }
            exit(); 
        } else {
           
            echo "<script>alert('Password salah!');</script>";
            echo "<script>window.location.href = 'login.php';</script>";
            exit();
        }
    } else {
        echo "<script>alert('Email tidak ditemukan!');</script>";
        echo "<script>window.location.href = 'login.php';</script>";
        exit();
    }
} else {

    
}

?>