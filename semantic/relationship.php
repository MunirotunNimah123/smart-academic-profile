<?php
session_start();

if (!isset($_SESSION['entered'])) {
    header("Location: ../welcome.php");
    exit;
}

require_once '../config/config.php';
require_once '../config/database.php';
require_once '../config/helper.php';

$pageTitle = "Semantic Relationship";

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

        Semantic Relationship (RDF Graph)

    </div>

    <div class="card mb-4">

        <div class="card-header">

            Visualisasi RDF Graph

        </div>

        <div class="card-body text-center">

            <canvas
                id="rdfCanvas"
                width="1000"
                height="650"
                style="border:1px solid #ddd;max-width:100%;">

            </canvas>

            <p class="mt-3 text-muted">

                Klik salah satu node untuk melihat informasinya.

            </p>

        </div>

    </div>

    <div class="card">

        <div class="card-header">

            RDF Triple (Subject - Predicate - Object)

        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-hover">

                    <thead class="table-success">

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

                    <?php foreach($skills as $s){ ?>

                    <tr>

                        <td><?= e($profil['nama']) ?></td>

                        <td>schema:knowsAbout</td>

                        <td><?= e($s['nama_skill']) ?></td>

                    </tr>

                    <?php } ?>

                    <?php foreach($organisasi as $o){ ?>

                    <tr>

                        <td><?= e($profil['nama']) ?></td>

                        <td>schema:memberOf</td>

                        <td><?= e($o['nama_organisasi']) ?></td>

                    </tr>

                    <?php } ?>

                    <?php foreach($projects as $p){ ?>

                    <tr>

                        <td><?= e($profil['nama']) ?></td>

                        <td>schema:subjectOf</td>

                        <td><?= e($p['judul']) ?></td>

                    </tr>

                    <?php } ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

<script>

const canvas=document.getElementById("rdfCanvas");
const ctx=canvas.getContext("2d");

const nodes=[];

nodes.push({
x:500,
y:90,
r:35,
color:"#16a34a",
label:"Person",
info:"<?= addslashes($profil['nama']) ?>"
});

nodes.push({
x:500,
y:250,
r:35,
color:"#2563eb",
label:"University",
info:"<?= addslashes($profil['universitas']) ?>"
});

<?php
$x=120;
foreach($skills as $s){
?>

nodes.push({
x:<?= $x ?>,
y:520,
r:28,
color:"#f59e0b",
label:"Skill",
info:"<?= addslashes($s['nama_skill']) ?>"
});

<?php
$x+=170;
}
?>

<?php
$x=170;
foreach($organisasi as $o){
?>

nodes.push({
x:<?= $x ?>,
y:360,
r:28,
color:"#ef4444",
label:"Organization",
info:"<?= addslashes($o['nama_organisasi']) ?>"
});

<?php
$x+=250;
}
?>

<?php
$x=780;
foreach($projects as $p){
?>

nodes.push({
x:<?= $x ?>,
y:520,
r:28,
color:"#8b5cf6",
label:"Project",
info:"<?= addslashes($p['judul']) ?>"
});

<?php
$x-=180;
}
?>

function line(a,b){

ctx.beginPath();

ctx.moveTo(a.x,a.y);

ctx.lineTo(b.x,b.y);

ctx.strokeStyle="#888";

ctx.lineWidth=2;

ctx.stroke();

}

line(nodes[0],nodes[1]);

for(let i=2;i<nodes.length;i++){

line(nodes[0],nodes[i]);

}

for(let n of nodes){

ctx.beginPath();

ctx.arc(n.x,n.y,n.r,0,Math.PI*2);

ctx.fillStyle=n.color;

ctx.fill();

ctx.fillStyle="#fff";

ctx.font="bold 13px Arial";

ctx.textAlign="center";

ctx.fillText(n.label,n.x,n.y+5);

}

canvas.addEventListener("click",function(e){

const rect=canvas.getBoundingClientRect();

const x=e.clientX-rect.left;

const y=e.clientY-rect.top;

for(let n of nodes){

const d=Math.sqrt((x-n.x)*(x-n.x)+(y-n.y)*(y-n.y));

if(d<n.r){

alert(
n.label+
"\n\n"+
n.info
);

}

}

});

</script>

<?php

include '../includes/footer.php';

?>