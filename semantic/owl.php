<?php

session_start();

if(!isset($_SESSION['entered'])){
    header("Location: ../welcome.php");
    exit;
}

require_once '../config/config.php';
require_once '../config/database.php';
require_once '../config/helper.php';

$pageTitle="OWL Ontology";

$profil=selectOne("SELECT * FROM profil LIMIT 1");
$skills=select("SELECT * FROM skill");
$organisasi=select("SELECT * FROM organisasi");
$projects=select("SELECT * FROM project");

include '../includes/header.php';
include '../includes/sidebar.php';
include '../includes/navbar.php';

$ttl = "";

$ttl .= "@prefix rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#> .\n";
$ttl .= "@prefix owl: <http://www.w3.org/2002/07/owl#> .\n";
$ttl .= "@prefix schema: <https://schema.org/> .\n";
$ttl .= "@prefix sap: <https://smartacademicprofile.my.id/ontology#> .\n\n";

$ttl .= "#########################################################\n";
$ttl .= "# Classes\n";
$ttl .= "#########################################################\n\n";

$ttl .= "sap:Person rdf:type owl:Class .\n";
$ttl .= "sap:EducationalOrg rdf:type owl:Class .\n";
$ttl .= "sap:Organization rdf:type owl:Class .\n";
$ttl .= "sap:Skill rdf:type owl:Class .\n";
$ttl .= "sap:Project rdf:type owl:Class .\n";
$ttl .= "sap:DefinedTerm rdf:type owl:Class .\n\n";

$ttl .= "#########################################################\n";
$ttl .= "# Object Property\n";
$ttl .= "#########################################################\n\n";

$ttl .= "schema:alumniOf rdf:type owl:ObjectProperty .\n";
$ttl .= "schema:knowsAbout rdf:type owl:ObjectProperty .\n";
$ttl .= "schema:memberOf rdf:type owl:ObjectProperty .\n";
$ttl .= "schema:author rdf:type owl:ObjectProperty .\n\n";

$ttl .= "#########################################################\n";
$ttl .= "# Individual\n";
$ttl .= "#########################################################\n\n";

$ttl .= "sap:Mahasiswa rdf:type sap:Person ;\n";
$ttl .= "    schema:name \"" . $profil['nama'] . "\" ;\n";
$ttl .= "    schema:identifier \"" . $profil['nim'] . "\" ;\n";
$ttl .= "    schema:alumniOf sap:Universitas ;\n";

foreach($skills as $s){
    $ttl .= "    schema:knowsAbout sap:" .
        str_replace(" ","",$s['nama_skill']) .
        " ;\n";
}

foreach($organisasi as $o){
    $ttl .= "    schema:memberOf sap:" .
        str_replace(" ","",$o['nama_organisasi']) .
        " ;\n";
}

$ttl .= ".\n\n";

$ttl .= "sap:Universitas rdf:type sap:EducationalOrg ;\n";
$ttl .= "    schema:name \"" . $profil['universitas'] . "\" .\n\n";

foreach($skills as $s){

$ttl .= "sap:" .
str_replace(" ","",$s['nama_skill']) .
" rdf:type sap:Skill ;\n";

$ttl .= "    schema:name \"" .
$s['nama_skill'] .
"\" .\n\n";

}

foreach($organisasi as $o){

$ttl .= "sap:" .
str_replace(" ","",$o['nama_organisasi']) .
" rdf:type sap:Organization ;\n";

$ttl .= "    schema:name \"" .
$o['nama_organisasi'] .
"\" .\n\n";

}

foreach($projects as $p){

$ttl .= "sap:" .
str_replace(" ","",$p['judul']) .
" rdf:type sap:Project ;\n";

$ttl .= "    schema:name \"" .
$p['judul'] .
"\" ;\n";

$ttl .= "    schema:author sap:Mahasiswa .\n\n";

}

?>

<div class="container-fluid">

<div class="page-title">

OWL Ontology (Turtle)

</div>

<div class="card mb-4">

<div class="card-header">

Ontology Menggunakan Format Turtle

</div>

<div class="card-body">

<p>

Ontology berikut digunakan untuk
mendeskripsikan hubungan antar entitas
pada Smart Academic Profile menggunakan
OWL (Web Ontology Language).

</p>

<pre style="
background:#1e293b;
color:#22c55e;
padding:20px;
border-radius:10px;
overflow:auto;
max-height:700px;
font-size:14px;
"><?= htmlspecialchars($ttl) ?></pre>

</div>

</div>

<div class="card">

<div class="card-header">

Penjelasan Ontology

</div>

<div class="card-body">

<table class="table table-bordered">

<thead>

<tr>

<th>Komponen</th>

<th>Keterangan</th>

</tr>

</thead>

<tbody>

<tr>

<td>Person</td>

<td>Merepresentasikan mahasiswa.</td>

</tr>

<tr>

<td>EducationalOrg</td>

<td>Universitas tempat mahasiswa belajar.</td>

</tr>

<tr>

<td>Organization</td>

<td>Organisasi yang pernah diikuti.</td>

</tr>

<tr>

<td>Skill</td>

<td>Keahlian mahasiswa.</td>

</tr>

<tr>

<td>Project</td>

<td>Project yang dibuat mahasiswa.</td>

</tr>

<tr>

<td>DefinedTerm</td>

<td>Istilah atau kategori skill.</td>

</tr>

<tr>

<td>schema:alumniOf</td>

<td>Relasi mahasiswa dengan universitas.</td>

</tr>

<tr>

<td>schema:knowsAbout</td>

<td>Relasi mahasiswa dengan skill.</td>

</tr>

<tr>

<td>schema:memberOf</td>

<td>Relasi mahasiswa dengan organisasi.</td>

</tr>

<tr>

<td>schema:author</td>

<td>Relasi mahasiswa sebagai pembuat project.</td>

</tr>

</tbody>

</table>

</div>

</div>

</div>

<?php

include '../includes/footer.php';

?>