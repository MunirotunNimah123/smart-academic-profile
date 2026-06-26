<?php
// schema.php
require_once 'config/db.php';
require_once 'helpers/semantic.php';
$jsonLD = getJSONLD($pdo);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Struktur Schema.org JSON-LD Metadata</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body class="grid-bg">
    <?php include 'navbar.php'; ?>

    <div style="max-width: 1000px; margin: 40px auto; width: 95%;">
        <h2 style="font-size: 2rem; margin-bottom: 10px;">Struktur Metadata Schema.org</h2>
        <p style="color: oklch(0.72 0.05 150); margin-bottom: 25px;">Berikut merupakan injeksi data terstruktur berformat <strong style="color:var(--lime)">JSON-LD</strong> yang ditanamkan secara dinamis pada header website untuk dibaca oleh mesin perayap bot.</p>
        
        <div class="panel" style="background: #090d16; border: 1px solid var(--border);">
            <pre class="code-font" style="color: #a7f3d0; white-space: pre-wrap; margin: 0; font-size: 0.9rem;"><?= htmlspecialchars($jsonLD) ?></pre>
        </div>
    </div>
</body>
</html>