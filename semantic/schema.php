<?php

session_start();

if(!isset($_SESSION['entered'])){
    header("Location: ../welcome.php");
    exit;
}

require_once '../config/config.php';
require_once '../config/database.php';
require_once '../config/helper.php';

$pageTitle="Schema.org JSON-LD";

$profil=selectOne("SELECT * FROM profil LIMIT 1");

$skills=select("SELECT * FROM skill");

$organisasi=select("SELECT * FROM organisasi");

$project=select("SELECT * FROM project");

include '../includes/header.php';
include '../includes/sidebar.php';
include '../includes/navbar.php';

/*
==========================================================
JSON LD
==========================================================
*/

$json=[
"@context"=>"https://schema.org",
"@graph"=>[]
];