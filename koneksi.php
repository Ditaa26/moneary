<?php
// Konfigurasi koneksi database
$servername = "localhost"; // Nama server MySQL
$username = "root";        // Username MySQL (biasanya 'root' di XAMPP)
$password = "";            // Password MySQL (biasanya kosong di XAMPP)
$dbname = "moneary";       // Nama database

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Check koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Set karakter encoding
$conn->set_charset("utf8");
?>