<?php
/**
 * ==========================================================
 * SMART ACADEMIC PROFILE
 * Halaman Pendidikan
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

$pageTitle = "Riwayat Pendidikan";

$pendidikan = select("
SELECT *
FROM pendidikan
ORDER BY tahun_masuk DESC
");

include '../includes/header.php';
include '../includes/sidebar.php';
include '../includes/navbar.php';
?>

<div class="container-fluid">

    <div class="page-title">

        Riwayat Pendidikan

    </div>

    <div class="card">

        <div class="card-header">

            <i class="bi bi-mortarboard-fill"></i>

            Riwayat Pendidikan

        </div>

        <div class="card-body">

            <?php if(count($pendidikan)>0){ ?>

            <div class="table-responsive">

                <table class="table table-hover table-bordered align-middle">

                    <thead>

                        <tr>

                            <th width="70">No</th>

                            <th>Jenjang</th>

                            <th>Nama Sekolah / Universitas</th>

                            <th>Jurusan</th>

                            <th>Tahun Masuk</th>

                            <th>Tahun Lulus</th>

                        </tr>

                    </thead>

                    <tbody>

                    <?php

                    $no=1;

                    foreach($pendidikan as $row){

                    ?>

                    <tr>

                        <td><?= $no++ ?></td>

                        <td>

                            <span class="badge bg-success">

                                <?= e($row['jenjang']) ?>

                            </span>

                        </td>

                        <td>

                            <?= e($row['nama_sekolah']) ?>

                        </td>

                        <td>

                            <?= e($row['jurusan']) ?>

                        </td>

                        <td>

                            <?= e($row['tahun_masuk']) ?>

                        </td>

                        <td>

                            <?= e($row['tahun_lulus']) ?>

                        </td>

                    </tr>

                    <?php } ?>

                    </tbody>

                </table>

            </div>

            <?php }else{ ?>

                <div class="alert alert-warning">

                    Data pendidikan belum tersedia.

                </div>

            <?php } ?>

        </div>

    </div>

    <br>

    <div class="card">

        <div class="card-header">

            Ringkasan Pendidikan

        </div>

        <div class="card-body">

            <p>

                Riwayat pendidikan merupakan salah satu informasi penting
                dalam Smart Academic Profile yang digunakan untuk
                mendeskripsikan latar belakang akademik mahasiswa.

            </p>

            <p>

                Informasi ini nantinya akan dihubungkan dengan
                <strong>Schema.org</strong> menggunakan tipe
                <strong>CollegeOrUniversity</strong> sehingga dapat
                dipahami oleh mesin pencari maupun aplikasi Semantic Web.

            </p>

        </div>

    </div>

</div>

<?php

include '../includes/footer.php';

?>