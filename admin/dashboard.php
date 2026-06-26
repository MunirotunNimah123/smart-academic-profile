<?php
include "includes/auth.php";
include "includes/config.php";
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-4">

    <h3>Dashboard Admin</h3>
    <p>Selamat datang, <?= $_SESSION['admin']; ?></p>

    <div class="row">

        <div class="col-md-3">
            <div class="card bg-primary text-white p-3">
                Profil
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-success text-white p-3">
                Skill
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-warning text-dark p-3">
                Project
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-danger text-white p-3">
                Komentar
            </div>
        </div>

    </div>

</div>

</body>
</html>