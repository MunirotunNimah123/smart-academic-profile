<?php
// config/db.php
$host = 'localhost';
$db   = 'smart_academic_profile';
$user = 'root';
$pass = ''; // Kosongkan jika pakai Laragon default
$charset = 'utf8mb4';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=$charset", $user, $pass, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ]);
} catch (\PDOException $e) {
    die("Koneksi database gagal: " . $e->getMessage());
}

define('BASE_URL', 'http://localhost/smart-academic-profile/');
?>