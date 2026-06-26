<?php
/**
 * ==========================================================
 * SMART ACADEMIC PROFILE
 * Halaman Project
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

$pageTitle = "Project";

$projects = select("
SELECT *
FROM project
ORDER BY featured DESC, tahun DESC
");

include '../includes/header.php';
include '../includes/sidebar.php';
include '../includes/navbar.php';
?>

<div class="container-fluid">

    <div class="page-title">

        Project Portfolio

    </div>

    <?php if(count($projects)>0){ ?>

    <div class="row">

    <?php foreach($projects as $project){ ?>

    <div class="col-lg-6 mb-4">

        <div class="card h-100 shadow-sm">

            <div class="card-body">

                <?php if($project['featured']==1){ ?>

                    <span class="badge bg-warning text-dark mb-2">

                        ⭐ Featured Project

                    </span>

                <?php } ?>

                <h3>

                    <?= e($project['judul']) ?>

                </h3>

                <p>

                    <?= nl2br(e($project['deskripsi'])) ?>

                </p>

                <hr>

                <p>

                    <strong>Teknologi</strong>

                    <br>

                    <?= e($project['teknologi']) ?>

                </p>

                <p>

                    <strong>Tahun</strong>

                    <br>

                    <?= e($project['tahun']) ?>

                </p>

                <div class="d-flex gap-2 flex-wrap">

                    <?php if(!empty($project['github'])){ ?>

                    <a
                        href="<?= e($project['github']) ?>"
                        target="_blank"
                        class="btn btn-dark">

                        <i class="bi bi-github"></i>

                        Github

                    </a>

                    <?php } ?>

                    <?php if(!empty($project['demo'])){ ?>

                    <a
                        href="<?= e($project['demo']) ?>"
                        target="_blank"
                        class="btn btn-success">

                        <i class="bi bi-globe"></i>

                        Demo

                    </a>

                    <?php } ?>

                </div>

            </div>

        </div>

    </div>

    <?php } ?>

    </div>

    <?php }else{ ?>

        <div class="alert alert-warning">

            Belum ada data project.

        </div>

    <?php } ?>

    <br>

    <div class="card">

        <div class="card-header">

            Semantic Relationship Project

        </div>

        <div class="card-body">

            <p>

                Setiap project direpresentasikan sebagai
                <strong>CreativeWork</strong>
                dan dihubungkan dengan mahasiswa
                menggunakan properti
                <strong>schema:subjectOf</strong>.

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

                <?php foreach($projects as $project){ ?>

                    <tr>

                        <td>

                            <?= APP_AUTHOR ?>

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

    <br>

    <div class="card">

        <div class="card-header">

            Penjelasan

        </div>

        <div class="card-body">

            <p>

                Halaman ini menampilkan seluruh proyek yang
                pernah dikembangkan mahasiswa.

                Informasi project nantinya digunakan
                sebagai bagian dari implementasi
                Semantic Web menggunakan
                Schema.org bertipe
                <strong>CreativeWork</strong>.

            </p>

            <p>

                Project unggulan diberi status
                <strong>Featured</strong>
                sehingga lebih mudah dikenali
                oleh pengunjung.

            </p>

        </div>

    </div>

</div>

<?php

include '../includes/footer.php';

?>