<?php
// index.php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'config/db.php';
require_once 'helpers/semantic.php';

// Ambil data profil utama dari database
$profil = $pdo->query("SELECT * FROM profil LIMIT 1")->fetch();
$skills = $pdo->query("SELECT * FROM skill")->fetchAll();

// Generate dokumen JSON-LD secara otomatis untuk disematkan pada tag head [cite: 90, 123]
$jsonLD = getJSONLD($pdo);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($profil['nama']) ?> - Academic Node</title>
    <link rel="stylesheet" href="assets/style.css">
    
    <script type="application/ld+json">
    <?= $jsonLD; ?>
    </script>
</head>
<body class="grid-bg">

    <?php include 'navbar.php'; ?>

    <header style="max-width: 1300px; margin: 40px auto; width: 95%; display: flex; justify-content: space-between; align-items: center; gap: 40px; flex-wrap: wrap;">
        <div style="max-width: 750px; flex: 1; min-width: 300px;">
            <div style="color: var(--neon-acidic); font-size: 0.85rem; letter-spacing: 0.15em; margin-bottom: 12px; font-weight: 600;">✨ UAS SEMANTIK WEB • ILMU KOMPUTER</div>
            <h1 style="font-size: 4.5rem; line-height: 1.0; margin: 0 0 24px 0;" class="text-acidic"><?= htmlspecialchars($profil['nama']) ?></h1>
            <p style="color: oklch(0.72 0.05 150); font-size: 1.1rem; line-height: 1.6; margin-bottom: 30px;">
                Selamat datang di platform Smart Academic Profile. Profil ini memanfaatkan teknologi Semantic Web dengan pemodelan data Subject–Predicate–Object (JSON-LD Schema.org). Sistem ini mentransformasi informasi akademik konvensional menjadi jaringan data terstruktur (knowledge graph) yang siap dibaca oleh mesin.
            </p>
            
            <div style="display: flex; gap: 10px; margin-bottom: 40px; flex-wrap: wrap;">
                <span style="background: oklch(0.14 0.03 155); padding: 8px 16px; border-radius: 4px; font-size: 0.85rem; border: 1px solid var(--border-thick); font-weight: bold;"><?= htmlspecialchars($profil['nim']) ?></span>
                <span style="background: oklch(0.14 0.03 155); padding: 8px 16px; border-radius: 4px; font-size: 0.85rem; border: 1px solid var(--border-thick); font-weight: bold;"><?= htmlspecialchars($profil['program_studi']) ?></span>
                <span style="background: oklch(0.14 0.03 155); padding: 8px 16px; border-radius: 4px; font-size: 0.85rem; border: 1px solid var(--border-thick); font-weight: bold;"><?= htmlspecialchars($profil['universitas']) ?></span>
            </div>
            
            <div style="display: flex; gap: 16px;">
                <a href="relasi.php" class="neon-btn">Mulai Jelajahi ↗</a>
                <a href="schema.php" style="color: white; padding: 12px 24px; text-decoration: none; border-radius: var(--radius-brutal); background: oklch(0.14 0.03 155); border: 1px solid var(--border-thick); font-weight: bold;">JSON-LD Schema &lt;/&gt;</a>
            </div>
        </div>
        
        <div style="position: relative; border: 3px solid var(--neon-acidic); border-radius: var(--radius-brutal); padding: 12px; box-shadow: 0 0 40px oklch(0.85 0.28 135 / 20%); background: var(--dark-panel);">
            <div style="width: 280px; height: 320px; border-radius: var(--radius-brutal); overflow: hidden; display: flex; align-items: center; justify-content: center;">
                <img src="assets/images/profil.jpeg" alt="Foto <?= htmlspecialchars($profil['nama']) ?>" style="width: 100%; height: 100%; object-fit: cover;">
            </div>
            <div style="position: absolute; bottom: -10px; left: -10px; background: #000; border: 1px solid var(--neon-acidic); padding: 6px 14px; border-radius: var(--radius-brutal); font-size: 0.75rem; font-family: monospace;">
                @semantic-node<br><span style="color: var(--neon-acidic)">2026 • active</span>
            </div>
        </div>
    </header>

    <div class="asymmetric-grid" style="margin-top: 50px; margin-bottom: 60px;">
        <div class="panel">
            <h3 style="margin-top: 0; font-size: 1.6rem;" class="text-acidic">👤 Biodata Mahasiswa</h3>
            <p style="line-height: 1.7; color: oklch(0.85 0.02 150); font-size: 0.95rem; text-align: justify;"><?= htmlspecialchars($profil['bio']) ?></p>
            
            <table style="width: 100%; border-collapse: collapse; margin-top: 25px; font-size: 0.9rem;" cellpadding="10">
                <tr style="border-bottom: 1px solid rgba(255,255,255,0.05);"><td style="color: oklch(0.5 0.01 160); width: 30%;">Fakultas</td><td>: <?= htmlspecialchars($profil['fakultas']) ?></td></tr>
                <tr style="border-bottom: 1px solid rgba(255,255,255,0.05);"><td style="color: oklch(0.5 0.01 160);">Email Kampus</td><td style="color: var(--neon-acidic);">: <?= htmlspecialchars($profil['email']) ?></td></tr>
                <tr><td style="color: oklch(0.5 0.01 160);">Domisili</td><td>: <?= htmlspecialchars($profil['domisili']) ?></td></tr>
            </table>
        </div>
        
        <div class="panel">
            <h3 style="margin-top: 0; font-size: 1.6rem;" class="text-acidic">📊 Keterampilan Sistem</h3>
            <div style="display: flex; flex-direction: column; gap: 16px; margin-top: 20px;">
                <?php foreach($skills as $sk): ?>
                    <div>
                        <div style="display: flex; justify-content: space-between; font-size: 0.85rem; margin-bottom: 6px;">
                            <span>⚡ <?= htmlspecialchars($sk['nama']) ?> <span style="color: oklch(0.5 0.01 160); font-size: 0.75rem;">[<?= htmlspecialchars($sk['kategori']) ?>]</span></span>
                            <span style="color: var(--neon-acidic); font-weight: bold;"><?= isset($sk['persentase']) ? $sk['persentase'] . '%' : '90%' ?></span>
                        </div>
                        <div style="width: 100%; background: rgba(255,255,255,0.05); height: 6px; border-radius: 2px;">
                            <div style="width: <?= isset($sk['persentase']) ? $sk['persentase'] : '90' ?>%; background: var(--neon-acidic); height: 100%; box-shadow: 0 0 10px var(--neon-acidic);"></div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

</body>
</html>