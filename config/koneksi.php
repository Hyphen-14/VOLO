<?php
$host = "localhost";
$user = "root";
$pass = ""; // Kosongkan jika pakai XAMPP default
$db   = "volo_db";

// Melakukan koneksi ke MySQL
$conn = mysqli_connect($host, $user, $pass, $db);

// Cek jika error
if (!$conn) {
    die("Koneksi Gagal: " . mysqli_connect_error());
}
?>