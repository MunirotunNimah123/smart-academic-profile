<?php
/**
 * ==========================================================
 * Smart Academic Profile
 * Welcome Page
 * ==========================================================
 */

session_start();

require_once 'config/config.php';

if(isset($_POST['enter'])){

    $_SESSION['entered']=true;

    header("Location: index.php");

    exit;

}
?>

<!DOCTYPE html>

<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Welcome | <?= APP_NAME ?></title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<link rel="stylesheet" href="assets/css/style.css">

</head>

<body>

<section class="welcome-section">

<div class="welcome-card">

<img src="assets/images/profile.jpg"
     alt="Profile">

<h2>Munirotun Ni'mah</h2>

<p>

<b>NIM :</b> F1G123010

</p>

<p>

<b>Program Studi :</b>

Ilmu Komputer

</p>

<p>

<b>Universitas :</b>

Universitas Halu Oleo

</p>

<p>

<b>Mata Kuliah :</b>

Semantic Web

</p>

<hr>

<p>

Selamat datang di website

<b>Smart Academic Profile</b>

yang menerapkan konsep

<b>Semantic Web</b>,

<b>Schema.org</b>,

<b>RDF</b>,

<b>JSON-LD</b>,

dan

<b>Linked Data</b>

untuk merepresentasikan profil akademik mahasiswa.

</p>

<form method="POST">

<button

type="submit"

name="enter"

class="btn btn-success btn-lg w-100 mt-3">

<i class="bi bi-box-arrow-in-right"></i>

Masuk ke Website

</button>

</form>

<div class="mt-4">

<small>

© <?= date("Y") ?>

Smart Academic Profile

</small>

</div>

</div>

</section>

</body>

</html>