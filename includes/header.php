<?php
/**
 * ==========================================================
 * Smart Academic Profile
 * Header Layout
 * ==========================================================
 */

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/helper.php';

$pageTitle = $pageTitle ?? APP_NAME;
?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title><?= e($pageTitle) ?> | <?= APP_NAME ?></title>

    <meta name="description"
        content="Smart Academic Profile - Semantic Web">

    <meta name="keywords"
        content="Semantic Web, JSON-LD, RDF, Schema.org, PHP, Mahasiswa">

    <meta name="author"
        content="<?= APP_AUTHOR ?>">

    <meta name="robots"
        content="index, follow">

    <!-- Bootstrap -->

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <!-- Bootstrap Icon -->

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"
        rel="stylesheet">

    <!-- Google Font -->

    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- CSS -->

    <link
        rel="stylesheet"
        href="<?= BASE_URL ?>assets/css/style.css">

    <!-- Favicon -->

    <link
        rel="icon"
        href="<?= BASE_URL ?>assets/images/logo.png">

</head>

<body>

<div class="wrapper">