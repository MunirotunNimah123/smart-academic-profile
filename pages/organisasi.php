<?php
/**
 * ==========================================================
 * SMART ACADEMIC PROFILE
 * Halaman Organisasi
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

$pageTitle = "Riwayat Organisasi";

$organisasi = select("
SELECT *
FROM organisasi
ORDER BY tahun_masuk DESC
");

include '../includes/header.php';
include '../includes/sidebar.php';
include '../includes/navbar.php';

?>

<div class="container-fluid">

    <div class="page-title">

        Riwayat Organisasi

    </div>

    <?php if(count($organisasi)>0){ ?>

        <div class="row">

        <?php foreach($organisasi as $org){ ?>

            <div class="col-lg-12 mb-4">

                <div class="card">

                    <div class="card-body">

                        <div class="d-flex justify-content-between align-items-center">

                            <div>

                                <h4>

                                    <i class="bi bi-people-fill text-success"></i>

                                    <?= e($org['nama_organisasi']) ?>

                                </h4>

                                <span class="badge bg-success">

                                    <?= e($org['jabatan']) ?>

                                </span>

                            </div>

                            <div class="text-end">

                                <strong>

                                    <?= e($org['tahun_masuk']) ?>

                                    -

                                    <?= e($org['tahun_selesai']) ?>

                                </strong>

                            </div>

                        </div>

                        <hr>

                        <p>

                            <?= nl2br(e($org['deskripsi'])) ?>

                        </p>

                    </div>

                </div>

            </div>

        <?php } ?>

        </div>

    <?php }else{ ?>

        <div class="alert alert-warning">

            Data organisasi belum tersedia.

        </div>

    <?php } ?>

    <br>

    <div class="card">

        <div class="card-header">

            Relasi Semantic Web

        </div>

        <div class="card-body">

            <p>

                Riwayat organisasi direpresentasikan menggunakan
                properti <strong>schema:memberOf</strong>
                sehingga hubungan mahasiswa dengan organisasi
                dapat dipahami oleh mesin.

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

                <?php foreach($organisasi as $org){ ?>

                    <tr>

                        <td>

                            <?= APP_AUTHOR ?>

                        </td>

                        <td>

                            schema:memberOf

                        </td>

                        <td>

                            <?= e($org['nama_organisasi']) ?>

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

            Kontribusi Organisasi

        </div>

        <div class="card-body">

            <p>

                Kegiatan organisasi membantu mahasiswa
                mengembangkan kemampuan kepemimpinan,
                komunikasi, kerja sama tim,
                serta pengalaman dalam mengelola berbagai kegiatan.

            </p>

            <p>

                Informasi ini juga menjadi bagian penting
                dari profil akademik mahasiswa
                pada implementasi Semantic Web.

            </p>

        </div>

    </div>

</div>

<?php

include '../includes/footer.php';

?>