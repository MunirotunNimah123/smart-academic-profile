<?php
/**
 * ==========================================================
 * SMART ACADEMIC PROFILE
 * Halaman Skill
 * ==========================================================
 */

session_start();

if (!isset($_SESSION['entered'])) {
    header("Location: ../welcome.php");
    exit;
}

require_once '../config/config.php';
require_once '../config/database.php';
require_once '../config/helper.php';

$pageTitle = "Daftar Skill";

$skills = select("
SELECT *
FROM skill
ORDER BY level DESC, kategori ASC
");

include '../includes/header.php';
include '../includes/sidebar.php';
include '../includes/navbar.php';
?>

<div class="container-fluid">

    <div class="page-title">

        Daftar Skill

    </div>

    <?php if(count($skills)>0){ ?>

    <div class="row">

    <?php foreach($skills as $skill){ ?>

        <div class="col-lg-6 mb-4">

            <div class="card">

                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div>

                            <h4>

                                <?= e($skill['icon']) ?>

                                <?= e($skill['nama_skill']) ?>

                            </h4>

                            <span class="badge bg-success">

                                <?= e($skill['kategori']) ?>

                            </span>

                        </div>

                        <div>

                            <strong>

                                <?= $skill['level']; ?>%

                            </strong>

                        </div>

                    </div>

                    <br>

                    <div class="progress">

                        <div
                            class="progress-bar bg-success"
                            role="progressbar"
                            style="width: <?= $skill['level']; ?>%;"
                            aria-valuenow="<?= $skill['level']; ?>"
                            aria-valuemin="0"
                            aria-valuemax="100">

                            <?= $skill['level']; ?>%

                        </div>

                    </div>

                    <br>

                    <small class="text-muted">

                        Skill ini digunakan dalam pengembangan
                        Smart Academic Profile
                        berbasis Semantic Web.

                    </small>

                </div>

            </div>

        </div>

    <?php } ?>

    </div>

    <?php }else{ ?>

    <div class="alert alert-warning">

        Belum ada data skill.

    </div>

    <?php } ?>

    <br>

    <div class="card">

        <div class="card-header">

            Hubungan Dengan Semantic Web

        </div>

        <div class="card-body">

            <p>

                Data skill akan direpresentasikan menggunakan
                <strong>Schema.org</strong>
                dengan properti

                <code>knowsAbout</code>

                sehingga mesin pencari dapat memahami bidang
                keahlian mahasiswa.

            </p>

            <table class="table table-bordered">

                <thead>

                    <tr>

                        <th>Subject</th>

                        <th>Predicate</th>

                        <th>Object</th>

                    </tr>

                </thead>

                <tbody>

                <?php foreach($skills as $skill){ ?>

                    <tr>

                        <td>

                            <?= APP_AUTHOR ?>

                        </td>

                        <td>

                            schema:knowsAbout

                        </td>

                        <td>

                            <?= e($skill['nama_skill']) ?>

                        </td>

                    </tr>

                <?php } ?>

                </tbody>

            </table>

        </div>

    </div>

</div>

<?php

include '../includes/footer.php';

?>