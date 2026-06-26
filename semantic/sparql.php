<?php

session_start();

if(!isset($_SESSION['entered'])){
    header("Location: ../welcome.php");
    exit;
}

require_once '../config/config.php';
require_once '../config/database.php';
require_once '../config/helper.php';

$pageTitle = "SPARQL Query";

$profil = selectOne("SELECT * FROM profil LIMIT 1");
$skills = select("SELECT * FROM skill");
$organisasi = select("SELECT * FROM organisasi");
$projects = select("SELECT * FROM project");

include '../includes/header.php';
include '../includes/sidebar.php';
include '../includes/navbar.php';

?>

<div class="container-fluid">

<div class="page-title">

SPARQL Query

</div>

<div class="card mb-4">

<div class="card-header">

Tentang SPARQL

</div>

<div class="card-body">

<p>

SPARQL (SPARQL Protocol and RDF Query Language)
merupakan bahasa query yang digunakan
untuk mengambil informasi dari data RDF.

Pada halaman ini ditampilkan contoh query
beserta hasil simulasinya berdasarkan
data Smart Academic Profile.

</p>

</div>

</div>

<!-- QUERY 1 -->

<div class="card mb-4">

<div class="card-header bg-success text-white">

Query 1 - Data Mahasiswa

</div>

<div class="card-body">

<pre>
PREFIX schema: <https://schema.org/>

SELECT ?nama ?nim
WHERE {

?person a schema:Person .

?person schema:name ?nama .

?person schema:identifier ?nim .

}
</pre>

<h5>Hasil Simulasi</h5>

<table class="table table-bordered">

<tr>

<th>Nama</th>

<th>NIM</th>

</tr>

<tr>

<td><?= e($profil['nama']) ?></td>

<td><?= e($profil['nim']) ?></td>

</tr>

</table>

</div>

</div>

<!-- QUERY 2 -->

<div class="card mb-4">

<div class="card-header bg-primary text-white">

Query 2 - Skill Mahasiswa

</div>

<div class="card-body">

<pre>
PREFIX schema: <https://schema.org/>

SELECT ?skill

WHERE{

?person schema:knowsAbout ?skill .

}
</pre>

<h5>Hasil Simulasi</h5>

<table class="table table-bordered">

<tr>

<th>Skill</th>

</tr>

<?php foreach($skills as $s){ ?>

<tr>

<td>

<?= e($s['nama_skill']) ?>

</td>

</tr>

<?php } ?>

</table>

</div>

</div>

<!-- QUERY 3 -->

<div class="card mb-4">

<div class="card-header bg-warning">

Query 3 - Organisasi

</div>

<div class="card-body">

<pre>
PREFIX schema: <https://schema.org/>

SELECT ?organisasi

WHERE{

?person schema:memberOf ?organisasi .

}
</pre>

<h5>Hasil Simulasi</h5>

<table class="table table-bordered">

<tr>

<th>Organisasi</th>

</tr>

<?php foreach($organisasi as $o){ ?>

<tr>

<td>

<?= e($o['nama_organisasi']) ?>

</td>

</tr>

<?php } ?>

</table>

</div>

</div>

<!-- QUERY 4 -->

<div class="card mb-4">

<div class="card-header bg-danger text-white">

Query 4 - Project

</div>

<div class="card-body">

<pre>
PREFIX schema: <https://schema.org/>

SELECT ?project

WHERE{

?person schema:subjectOf ?project .

}
</pre>

<h5>Hasil Simulasi</h5>

<table class="table table-bordered">

<tr>

<th>Project</th>

</tr>

<?php foreach($projects as $p){ ?>

<tr>

<td>

<?= e($p['judul']) ?>

</td>

</tr>

<?php } ?>

</table>

</div>

</div>

<div class="card">

<div class="card-header">

Kesimpulan

</div>

<div class="card-body">

<p>

Keempat query SPARQL di atas menunjukkan
bagaimana data RDF dapat diakses menggunakan
bahasa query SPARQL.

Query dapat digunakan untuk mengambil
informasi mengenai mahasiswa,
skill,
organisasi,
dan project
yang telah dimodelkan menggunakan
Schema.org.

</p>

</div>

</div>

</div>

<?php

include '../includes/footer.php';

?>