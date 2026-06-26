<?php
// proyek.php
require_once 'config/db.php';
$proyek = $pdo->query("SELECT * FROM proyek ORDER BY tahun DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Gudang Proyek - Cyber Profile</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body class="grid-bg">
    <?php include 'navbar.php'; ?>

    <div style="max-width: 1200px; margin: 40px auto; width: 95%;">
        <h2 style="font-size: 2rem; margin-bottom: 24px;" class="text-acidic">💻 Daftar Proyek & Tugas Akhir</h2>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px;">
            <?php foreach($proyek as $pr): ?>
                <div class="panel" style="display: flex; flex-direction: column; justify-content: space-between;">
                    <div>
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
                            <span class="code-font" style="color: var(--lime); font-size: 0.85rem;"><?= $pr['kode'] ?></span>
                            <span style="font-size: 0.85rem; color: oklch(0.6 0.02 150);"><?= $pr['tahun'] ?></span>
                        </div>
                        <h4 style="margin: 0 0 10px 0; font-size: 1.25rem; color: white;"><?= $pr['judul'] ?></h4>
                        <p style="font-size: 0.9rem; color: oklch(0.72 0.05 150); line-height: 1.5;"><?= $pr['deskripsi'] ?></p>
                    </div>
                    <div style="margin-top: 20px; font-size: 0.8rem; font-family: monospace; color: var(--lime); background: rgba(0,0,0,0.2); padding: 6px 12px; border-radius: 6px;">
                        🛠️ <?= $pr['teknologi'] ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>