<?php

session_start();

if(!isset($_SESSION['entered'])){
    header("Location: ../welcome.php");
    exit;
}

require_once '../config/config.php';
require_once '../config/database.php';
require_once '../config/helper.php';

$pageTitle = "Linked Data";

$profil = selectOne("SELECT * FROM profil LIMIT 1");
$skills = select("SELECT * FROM skill");
$projects = select("SELECT * FROM project");
$organisasi = select("SELECT * FROM organisasi");

include '../includes/header.php';
include '../includes/sidebar.php';
include '../includes/navbar.php';

?>

<div class="container-fluid">

<div class="page-title">

Linked Data

</div>

<div class="card mb-4">

<div class="card-header">

Apa itu Linked Data?

</div>

<div class="card-body">

<p>

Linked Data merupakan konsep yang diperkenalkan oleh
<b>Sir Tim Berners-Lee</b> untuk menghubungkan data antar
website menggunakan URI sehingga data dapat dipahami
oleh manusia maupun mesin.

Dengan Linked Data, informasi tidak hanya berupa teks,
tetapi menjadi data yang saling terhubung dan dapat
diproses secara otomatis oleh aplikasi Semantic Web.

</p>

</div>

</div>

<div class="card mb-4">

<div class="card-header bg-success text-white">

Empat Prinsip Linked Data

</div>

<div class="card-body">

<table class="table table-bordered">

<thead class="table-success">

<tr>

<th width="80">No</th>

<th>Prinsip</th>

<th>Implementasi pada Website</th>

</tr>

</thead>

<tbody>

<tr>

<td>1</td>

<td>Menggunakan URI sebagai identitas setiap resource.</td>

<td>Mahasiswa, universitas, skill, organisasi, dan project memiliki URI unik.</td>

</tr>

<tr>

<td>2</td>

<td>Menggunakan HTTP URI agar dapat diakses melalui web.</td>

<td>URI dapat diakses menggunakan browser atau crawler.</td>

</tr>

<tr>

<td>3</td>

<td>Menyediakan informasi menggunakan RDF dan Schema.org.</td>

<td>Website menggunakan JSON-LD, RDF Triple, dan Schema.org.</td>

</tr>

<tr>

<td>4</td>

<td>Menghubungkan resource dengan resource lain.</td>

<td>Menggunakan DBpedia URI dan <b>owl:sameAs</b>.</td>

</tr>

</tbody>

</table>

</div>

</div>

<div class="card mb-4">

<div class="card-header">

Contoh URI Resource

</div>

<div class="card-body">

<pre style="
background:#1e293b;
color:#22c55e;
padding:20px;
border-radius:10px;
overflow:auto;
">

https://smartacademicprofile.my.id/person/<?= urlencode($profil['nim']); ?>


https://smartacademicprofile.my.id/university/<?= urlencode($profil['universitas']); ?>


https://smartacademicprofile.my.id/project/

</pre>

</div>

</div>

<div class="card mb-4">

<div class="card-header">

Contoh owl:sameAs

</div>

<div class="card-body">

<pre style="
background:#1e293b;
color:#22c55e;
padding:20px;
border-radius:10px;
overflow:auto;
">

@prefix owl: <http://www.w3.org/2002/07/owl#> .

@prefix schema: <https://schema.org/> .

schema:University

owl:sameAs

<https://dbpedia.org/resource/Halu_Oleo_University> .

</pre>

</div>

</div>

<div class="card mb-4">

<div class="card-header">

Implementasi Linked Data pada Smart Academic Profile

</div>

<div class="card-body">

<table class="table table-striped table-bordered">

<thead>

<tr>

<th>Subject</th>

<th>Predicate</th>

<th>Object</th>

</tr>

</thead>

<tbody>

<tr>

<td><?= e($profil['nama']) ?></td>

<td>schema:alumniOf</td>

<td><?= e($profil['universitas']) ?></td>

</tr>

<?php foreach($skills as $skill){ ?>

<tr>

<td><?= e($profil['nama']) ?></td>

<td>schema:knowsAbout</td>

<td><?= e($skill['nama_skill']) ?></td>

</tr>

<?php } ?>

<?php foreach($organisasi as $org){ ?>

<tr>

<td><?= e($profil['nama']) ?></td>

<td>schema:memberOf</td>

<td><?= e($org['nama_organisasi']) ?></td>

</tr>

<?php } ?>

<?php foreach($projects as $project){ ?>

<tr>

<td><?= e($profil['nama']) ?></td>

<td>schema:subjectOf</td>

<td><?= e($project['judul']) ?></td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

</div>

<div class="card mb-4">

<div class="card-header">

Manfaat Linked Data

</div>

<div class="card-body">

<ul>

<li>Meningkatkan interoperabilitas antar sistem.</li>

<li>Mempermudah mesin pencari memahami informasi.</li>

<li>Mendukung Knowledge Graph.</li>

<li>Membantu integrasi data lintas platform.</li>

<li>Meningkatkan kualitas Semantic Web.</li>

<li>Memudahkan pertukaran data secara terbuka.</li>

</ul>

</div>

</div>

<div class="card">

<div class="card-header">

Kesimpulan

</div>

<div class="card-body">

<p>

Implementasi Linked Data pada Smart Academic Profile
menghubungkan data mahasiswa dengan resource lain
menggunakan URI, RDF, Schema.org, dan DBpedia.
Melalui konsep ini, informasi tidak hanya dapat dibaca
oleh manusia, tetapi juga dipahami oleh mesin sehingga
mendukung interoperabilitas, pencarian semantik,
dan pengembangan Knowledge Graph.

</p>

</div>

</div>

</div>

<?php

include '../includes/footer.php';

?>