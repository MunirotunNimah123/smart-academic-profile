<?php
// relasi.php - Versi sinkron database (Live dari Admin Panel)
require_once 'config/db.php';
require_once 'helpers/semantic.php';

// Ambil data profil
$profil = $pdo->query("SELECT * FROM profil LIMIT 1")->fetch();

// Ambil semua data relasi langsung dari tabel database 'relasi' (hasil input admin)
try {
    $triples = $pdo->query("SELECT subject as s, predicate as p, object as o FROM relasi")->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $triples = [];
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Jaringan Relasi Semantik Dinamis</title>
    <link rel="stylesheet" href="assets/style.css">
    <style>
        .relasi-table { width: 100%; text-align: left; font-size: 0.85rem; border-collapse: collapse; }
        .relasi-table th { border-bottom: 2px solid var(--neon-acidic); color: var(--neon-acidic); padding: 12px; }
        .relasi-table td { border-bottom: 1px solid rgba(255,255,255,0.05); padding: 12px; }
    </style>
</head>
<body class="grid-bg">

    <?php include 'navbar.php'; ?>

    <main class="asymmetric-grid" style="margin-top: 20px;">
        <div class="panel">
            <h3 style="margin-top: 0;" class="text-acidic">🌐 Graf Visualisasi Dinamis</h3>
            <canvas id="brutalCanvas" width="550" height="450" style="background: rgba(0,0,0,0.2); border: 1px dashed var(--neon-acidic); max-width: 100%; border-radius: 4px;"></canvas>
        </div>

        <div class="panel" style="max-height: 520px; overflow-y: auto;">
            <h3 style="margin-top: 0;" class="text-acidic">📋 Tabel Triple RDF (Data dari Admin)</h3>
            <table class="relasi-table">
                <thead>
                    <tr>
                        <th>Subject (S)</th>
                        <th>Predicate (P)</th>
                        <th>Object (O)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($triples)): ?>
                        <tr><td colspan="3" style="text-align:center; padding:20px; color:var(--text-gray);">Belum ada data relasi. Tambahkan via Panel Admin.</td></tr>
                    <?php else: ?>
                        <?php foreach($triples as $t): ?>
                        <tr>
                            <td><strong><?= htmlspecialchars($t['s']) ?></strong></td>
                            <td style="color: var(--neon-acidic); font-family: monospace;">ex:<?= htmlspecialchars($t['p']) ?></td>
                            <td style="color: white;"><?= htmlspecialchars($t['o']) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>

    <script>
        const canvas = document.getElementById('brutalCanvas');
        const ctx = canvas.getContext('2d');
        const cX = canvas.width / 2;
        const cY = canvas.height / 2;
        // Data diambil langsung dari PHP ke JavaScript
        const triplesData = <?php echo json_encode($triples); ?>;

        function drawBrutalGraph() {
            if (triplesData.length === 0) return;
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            
            triplesData.forEach((t, i) => {
                const angle = (i * 2 * Math.PI) / triplesData.length;
                const dist = 160;
                const x = cX + dist * Math.cos(angle);
                const y = cY + dist * Math.sin(angle);

                ctx.beginPath();
                ctx.moveTo(cX, cY);
                ctx.lineTo(x, y);
                ctx.strokeStyle = 'rgba(56, 189, 248, 0.2)';
                ctx.stroke();

                ctx.fillStyle = '#0f172a';
                ctx.strokeStyle = '#38bdf8';
                ctx.lineWidth = 1;
                ctx.fillRect(x - 60, y - 15, 120, 30);
                ctx.strokeRect(x - 60, y - 15, 120, 30);

                ctx.fillStyle = '#f8fafc';
                ctx.font = '10px "JetBrains Mono"';
                ctx.textAlign = 'center';
                ctx.textBaseline = 'middle';
                ctx.fillText(t.o.length > 15 ? t.o.substring(0,12)+'...' : t.o, x, y);
            });

            ctx.fillStyle = '#38bdf8';
            ctx.fillRect(cX - 50, cY - 20, 100, 40);
            ctx.fillStyle = '#020617';
            ctx.font = 'bold 11px "JetBrains Mono"';
            ctx.fillText('Subject: Node', cX, cY);
        }
        drawBrutalGraph();
    </script>
</body>
</html>