<?php
/**
 * ==========================================================
 * SMART ACADEMIC PROFILE
 * Dashboard
 * ==========================================================
 */

session_start();

if (!isset($_SESSION['entered'])) {
    header("Location: welcome.php");
    exit;
}

require_once 'config/config.php';
require_once 'config/database.php';
require_once 'config/helper.php';

$pageTitle = "Dashboard";

/*
|--------------------------------------------------------------------------
| Statistik
|--------------------------------------------------------------------------
*/

$totalSkill = countData("skill");

$totalPendidikan = countData("pendidikan");

$totalOrganisasi = countData("organisasi");

$totalProject = countData("project");

/*
|--------------------------------------------------------------------------
| Profil
|--------------------------------------------------------------------------
*/

$profil = selectOne("SELECT * FROM profil LIMIT 1");

/*
|--------------------------------------------------------------------------
| Featured Project
|--------------------------------------------------------------------------
*/

$featured = selectOne("SELECT * FROM project
WHERE featured=1
ORDER BY id DESC
LIMIT 1");

include 'includes/header.php';
include 'includes/sidebar.php';
include 'includes/navbar.php';

?>

<div class="container-fluid">

<div class="page-title">

Dashboard

</div>

<!-- ========================= -->

<div class="row">

<div class="col-lg-3">

<div class="stat-card bg-green">

<h5>Total Skill</h5>

<h2 class="counter"
data-target="<?= $totalSkill ?>">

<?= $totalSkill ?>

</h2>

</div>

</div>

<div class="col-lg-3">

<div class="stat-card bg-blue">

<h5>Pendidikan</h5>

<h2 class="counter"
data-target="<?= $totalPendidikan ?>">

<?= $totalPendidikan ?>

</h2>

</div>

</div>

<div class="col-lg-3">

<div class="stat-card bg-orange">

<h5>Organisasi</h5>

<h2 class="counter"
data-target="<?= $totalOrganisasi ?>">

<?= $totalOrganisasi ?>

</h2>

</div>

</div>

<div class="col-lg-3">

<div class="stat-card bg-purple">

<h5>Project</h5>

<h2 class="counter"
data-target="<?= $totalProject ?>">

<?= $totalProject ?>

</h2>

</div>

</div>

</div>

<!-- ========================= -->

<div class="row mt-4">

<div class="col-lg-4">

<div class="card profile-card">

<div class="card-body">

<img src="assets/uploads/<?= $profil['foto'] ?? 'default.png'; ?>">

<h2>

<?= e($profil['nama'] ?? '-') ?>

</h2>

<p>

<?= e($profil['program_studi'] ?? '-') ?>

</p>

<hr>

<p>

<b>NIM</b>

<br>

<?= e($profil['nim'] ?? '-') ?>

</p>

<p>

<b>Universitas</b>

<br>

<?= e($profil['universitas'] ?? '-') ?>

</p>

<a href="pages/profil.php"

class="btn btn-success w-100">

Lihat Profil

</a>

</div>

</div>

</div>

<div class="col-lg-8">

<div class="card">

<div class="card-header">

Tentang Website

</div>

<div class="card-body">

<p>

<b>Smart Academic Profile</b>

merupakan website profil akademik mahasiswa
yang dibangun menggunakan

PHP Native,

MySQL,

Bootstrap,

PDO,

serta menerapkan konsep

Semantic Web

menggunakan

Schema.org,

JSON-LD,

RDF,

OWL,

Linked Data,

DBpedia,

dan SPARQL.

</p>

<p>

Website ini dibuat untuk memenuhi

Ujian Akhir Semester

mata kuliah

Semantic Web.

</p>

</div>

</div>

</div>

</div>

<!-- ========================= -->

<div class="row mt-4">

<div class="col-lg-12">

<div class="card">

<div class="card-header">

Featured Project

</div>

<div class="card-body">

<?php if($featured){ ?>

<div class="project-card featured">

<div class="content">

<h3>

<?= e($featured['judul']) ?>

</h3>

<p>

<?= e($featured['deskripsi']) ?>

</p>

<hr>

<p>

<b>Teknologi</b>

<br>

<?= e($featured['teknologi']) ?>

</p>

<p>

<b>Tahun</b>

<?= e($featured['tahun']) ?>

</p>

<a

href="<?= e($featured['github']) ?>"

target="_blank"

class="btn btn-dark">

Github

</a>

<a

href="<?= e($featured['demo']) ?>"

target="_blank"

class="btn btn-success">

Demo

</a>

</div>

</div>

<?php }else{ ?>

<div class="alert alert-warning">

Belum ada Featured Project.

</div>

<?php } ?>

</div>

</div>

</div>

</div>

<!-- ========================= -->

<div class="row mt-4">

<div class="col-lg-12">

<div class="card">

<div class="card-header">

Implementasi Semantic Web

</div>

<div class="card-body">

<div class="row text-center">

<div class="col-md-2">

<h1>🌐</h1>

<p>Schema.org</p>

</div>

<div class="col-md-2">

<h1>🔗</h1>

<p>Linked Data</p>

</div>

<div class="col-md-2">

<h1>📚</h1>

<p>OWL</p>

</div>

<div class="col-md-2">

<h1>🧠</h1>

<p>SPARQL</p>

</div>

<div class="col-md-2">

<h1>🗂</h1>

<p>DBpedia</p>

</div>

<div class="col-md-2">

<h1>📄</h1>

<p>JSON-LD</p>

</div>

</div>

</div>

</div>

</div>

</div>

</div>

<?php

include 'includes/footer.php';

?>