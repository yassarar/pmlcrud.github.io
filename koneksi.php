<?php
// Koneksi ke database
$host = "localhost"; // Ganti dengan server database Anda
$user = "root"; // Ganti dengan username database Anda
$password = ""; // Ganti dengan password database Anda
$dbname = "crud"; // Ganti dengan nama database Anda

// Membuat koneksi
$kon = mysqli_connect($host, $user, $password, $dbname);

// Cek koneksi
if (!$kon) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>