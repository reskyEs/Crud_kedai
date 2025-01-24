<?php


$host = "localhost"; 
$username = "root";  
$password = "koishi123";      
$database = "kedai"; 

$koneksi = new mysqli($host, $username, $password, $database);

if ($koneksi->connect_error) {
    die("Connection failed: " . $koneksi->connect_error);
}
?>
