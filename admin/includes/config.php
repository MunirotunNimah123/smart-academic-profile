<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "smart_academic_profile";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
?>