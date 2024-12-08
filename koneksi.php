<?php
$host = "localhost"; // atau nama host lainnya
$username = "root";  // ganti dengan username database Anda
$password = "root";      // ganti dengan password database Anda
$database = "letsplaybyyups";  // ganti dengan nama database Anda

// Membuat koneksi ke database
$koneksi = mysqli_connect($host, $username, $password, $database);

// Cek koneksi
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
