<?php
$host   = 'localhost';   // host database
$dbname = 'rpl';  // ganti dengan nama database kamu
$user   = 'root';        // ganti jika username DB kamu berbeda
$pass   = '';            // ganti jika ada password DB

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
} catch (PDOException $e) {
    die("Koneksi gagal: " . $e->getMessage());
}
