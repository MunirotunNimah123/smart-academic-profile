<?php

session_start();

if(!isset($_SESSION['entered'])){
    header("Location: ../welcome.php");
    exit;
}

require_once '../config/config.php';
require_once '../config/database.php';
require_once '../config/helper.php';

$pageTitle = "DBpedia";

$profil = selectOne("SELECT * FROM profil LIMIT 1");
$skills = select("SELECT * FROM skill");
$projects = select("SELECT * FROM project");

include '../includes/header.php';
include '../includes/sidebar.php';
include '../includes/navbar.php';

/*
|--------------------------------------------------------------------------
| URI DBpedia
|--------------------------------------------------------------------------
*/

$universityURI = "https://dbpedia.org/resource/Halu_Oleo_University";

?>
<div class="container-fluid">

<div class="page-title">

DBpedia & Linked Open Data

</div>

<div class="card mb-4">

<div class="card-header">

Apa itu DBpedia?

</div>

<div class="card-body">

<p>

DBpedia merupakan proyek Linked Open Data
yang mengekstrak informasi terstruktur dari
Wikipedia dan menyediakannya dalam bentuk RDF.

Dengan DBpedia, data pada website dapat
dihubungkan dengan knowledge graph global
menggunakan URI yang unik.

</p>

</div>

</div>

<div class="card mb-4">

<div class="card-header">

URI DBpedia yang Digunakan

</div>

<div class="card-body">

<table class="table table-bordered table-hover">

<thead class="table-success">

<tr>

<th width="220">

Entity

</th>

<th>

URI DBpedia

</th>

</tr>

</thead>

<tbody>

<tr>

<td>

Universitas

</td>

<td>

<a
href="<?= $universityURI ?>"
target="_blank">

<?= $universityURI ?>

</a>

</td>

</tr>

<?php foreach($skills as $skill){

$uri="https://dbpedia.org/resource/".urlencode($skill['nama_skill']);

?>

<tr>

<td>

Skill :
<?= e($skill['nama_skill']) ?>

</td>

<td>

<a
target="_blank"
href="<?= $uri ?>">

<?= $uri ?>

</a>

</td>

</tr>

<?php } ?>

<?php foreach($projects as $project){

$uri="https://example.org/project/".urlencode($project['judul']);

?>

<tr>

<td>

Project :
<?= e($project['judul']) ?>

</td>

<td>

<?= $uri ?>

</td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

</div>

<div class="card mb-4">

<div class="card-header">

Implementasi owl:sameAs

</div>

<div class="card-body">

<pre style="
background:#1e293b;
color:#22c55e;
padding:20px;
border-radius:10px;
overflow:auto;
">

@prefix owl: &lt;http://www.w3.org/2002/07/owl#&gt; .
@prefix schema: &lt;https://schema.org/&gt; .

schema:University

    owl:sameAs

&lt;<?= $universityURI ?>&gt; .

</pre>

<p>

Relasi <b>owl:sameAs</b> menunjukkan bahwa
entitas Universitas pada website ini identik
dengan entitas yang ada di DBpedia.

</p>

</div>

</div>

<div class="card mb-4">

<div class="card-header">

Keterkaitan dengan Semantic Web

</div>

<div class="card-body">

<table class="table table-bordered">

<thead>

<tr>

<th>Entity</th>

<th>Relasi</th>

<th>Target</th>

</tr>

</thead>

<tbody>

<tr>

<td>

<?= e($profil['nama']) ?>

</td>

<td>

schema:alumniOf

</td>

<td>

<?= e($profil['universitas']) ?>

</td>

</tr>

<?php foreach($skills as $skill){ ?>

<tr>

<td>

<?= e($profil['nama']) ?>

</td>

<td>

schema:knowsAbout

</td>

<td>

<?= e($skill['nama_skill']) ?>

</td>

</tr>

<?php } ?>

<?php foreach($projects as $project){ ?>

<tr>

<td>

<?= e($profil['nama']) ?>

</td>

<td>

schema:subjectOf

</td>

<td>

<?= e($project['judul']) ?>

</td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

</div>

<div class="card">

<div class="card-header">

Kesimpulan

</div>

<div class="card-body">

<p>

Dengan menghubungkan data lokal ke URI
DBpedia menggunakan konsep Linked Data,
informasi pada Smart Academic Profile
menjadi bagian dari ekosistem data terbuka
yang dapat dipahami oleh aplikasi Semantic
Web di seluruh dunia.

</p>

</div>

</div>

</div>

<?php

include '../includes/footer.php';

?>