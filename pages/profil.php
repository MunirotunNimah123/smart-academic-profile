<?php
/**
 * ==========================================================
 * SMART ACADEMIC PROFILE
 * Profil Mahasiswa
 * ==========================================================
 */

session_start();

if(!isset($_SESSION['entered'])){
    header("Location: ../welcome.php");
    exit;
}

require_once '../config/config.php';
require_once '../config/database.php';
require_once '../config/helper.php';

$pageTitle="Profil Mahasiswa";

$profil = selectOne("SELECT * FROM profil LIMIT 1");

include '../includes/header.php';
include '../includes/sidebar.php';
include '../includes/navbar.php';

?>

<div class="container-fluid">

<div class="page-title">

Profil Mahasiswa

</div>

<div class="row">

<div class="col-lg-4">

<div class="card profile-card">

<div class="card-body text-center">

<img src="../assets/uploads/<?= $profil['foto'] ?: 'default.png'; ?>">

<h2>

<?= e($profil['nama']); ?>

</h2>

<p class="text-muted">

<?= e($profil['program_studi']); ?>

</p>

<hr>

<p>

<b>NIM</b>

<br>

<?= e($profil['nim']); ?>

</p>

<p>

<b>Universitas</b>

<br>

<?= e($profil['universitas']); ?>

</p>

<p>

<b>Email</b>

<br>

<?= e($profil['email']); ?>

</p>

<p>

<b>No HP</b>

<br>

<?= e($profil['telepon']); ?>

</p>

</div>

</div>

</div>

<div class="col-lg-8">

<div class="card mb-4">

<div class="card-header">

Tentang Saya

</div>

<div class="card-body">

<p>

<?= nl2br(e($profil['bio'])); ?>

</p>

</div>

</div>

<div class="card mb-4">

<div class="card-header">

Informasi Lengkap

</div>

<div class="card-body">

<table class="table table-bordered">

<tr>

<th width="220">

Nama Lengkap

</th>

<td>

<?= e($profil['nama']); ?>

</td>

</tr>

<tr>

<th>

NIM

</th>

<td>

<?= e($profil['nim']); ?>

</td>

</tr>

<tr>

<th>

Program Studi

</th>

<td>

<?= e($profil['program_studi']); ?>

</td>

</tr>

<tr>

<th>

Universitas

</th>

<td>

<?= e($profil['universitas']); ?>

</td>

</tr>

<tr>

<th>

Alamat

</th>

<td>

<?= e($profil['alamat']); ?>

</td>

</tr>

<tr>

<th>

Email

</th>

<td>

<?= e($profil['email']); ?>

</td>

</tr>

<tr>

<th>

Nomor HP

</th>

<td>

<?= e($profil['telepon']); ?>

</td>

</tr>

<tr>

<th>

Github

</th>

<td>

<a
target="_blank"
href="<?= e($profil['github']); ?>">

<?= e($profil['github']); ?>

</a>

</td>

</tr>

<tr>

<th>

LinkedIn

</th>

<td>

<a
target="_blank"
href="<?= e($profil['linkedin']); ?>">

<?= e($profil['linkedin']); ?>

</a>

</td>

</tr>

<tr>

<th>

Website

</th>

<td>

<a
target="_blank"
href="<?= e($profil['website']); ?>">

<?= e($profil['website']); ?>

</a>

</td>

</tr>

</table>

</div>

</div>

<div class="card">

<div class="card-header">

Keahlian Utama

</div>

<div class="card-body">

<p>

Website ini menerapkan konsep

<strong>Semantic Web</strong>

dengan implementasi

Schema.org,

JSON-LD,

RDF,

OWL,

SPARQL,

Linked Data,

dan

DBpedia

untuk merepresentasikan profil akademik mahasiswa secara terstruktur sehingga dapat dipahami baik oleh manusia maupun mesin.

</p>

</div>

</div>

</div>

</div>

</div>

<?php

include '../includes/footer.php';

?>