<?php
// riwayat.php
require_once 'config/db.php';
$pendidikan = $pdo->query("SELECT * FROM pendidikan ORDER BY tahun_masuk ASC")->fetchAll();
$organisasi = $pdo->query("SELECT * FROM organisasi ORDER BY tahun DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Riwayat & Organisasi - Smart Academic</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body class="grid-bg">
    <?php include 'navbar.php'; ?>

    <div class="main-layout" style="margin-top: 40px;">
        <div class="panel">
            <h3 style="color: var(--lime); margin-top: 0;">🎓 Jejak Akademik</h3>
            <div style="border-left: 2px solid var(--border); padding-left: 20px; margin-left: 10px;">
                <?php foreach($pendidikan as $p): ?>
                    <div style="position: relative; margin-bottom: 25px;">
                        <span style="position: absolute; left: -26px; top: 4px; width: 10px; height: 10px; background: var(--lime); border-radius: 50%; box-shadow: 0 0 10px var(--lime);"></span>
                        <div style="font-weight: bold; font-size: 1.1rem;"><?= $p['institusi'] ?></div>
                        <div style="font-size: 0.85rem; color: var(--lime); font-family: monospace;"><?= $p['jenjang'] ?> • <?= $p['tahun_masuk'] ?> - <?= $p['tahun_keluar'] ?></div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="panel">
            <h3 style="color: oklch(0.85 0.22 160); margin-top: 0;">👥 Keterlibatan Organisasi</h3>
            <?php foreach($organisasi as $o): ?>
                <div style="border-bottom: 1px solid var(--border); padding-bottom: 15px; margin-bottom: 15px;">
                    <div style="font-weight: bold; color: white;"><?= $o['nama'] ?></div>
                    <div style="font-size: 0.85rem; color: oklch(0.85 0.22 160); margin: 4px 0;"><?= $o['jabatan'] ?> (<?= $o['tahun'] ?>)</div>
                    <p style="font-size: 0.9rem; margin: 0; color: oklch(0.72 0.05 150);"><?= $o['deskripsi'] ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>