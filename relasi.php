<?php
// relasi.php
require_once 'config/db.php';
require_once 'helpers/semantic.php';

// Memproses penambahan relasi dinamis untuk tabel SPO
$profil = $pdo->query("SELECT * FROM profil LIMIT 1")->fetch();
$skills = $pdo->query("SELECT * FROM skill")->fetchAll();

$triples = [
    ["s" => $profil['nama'], "p" => "kuliahDi", "o" => $profil['universitas']],
    ["s" => $profil['nama'], "p" => "menggunakanPlatform", "o" => "GitHub"],
    ["s" => $profil['nama'], "p" => "memilikiKontak", "o" => $profil['email']]
];

foreach ($skills as $sk) {
    $triples[] = ["s" => $profil['nama'], "p" => "menguasaiBahasa", "o" => $sk['nama']];
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Jaringan Relasi Semantik Dinamis</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

    <?php include 'navbar.php'; ?>

    <div class="asymmetric-grid" style="margin-top: 20px;">
        <div class="panel">
            <h3 style="margin-top: 0;" class="text-acidic">🌐 Graf Visualisasi Dinamis</h3>
            <canvas id="brutalCanvas" width="550" height="450" style="background: rgba(0,0,0,0.2); border: 1px dashed var(--neon-acidic); max-width: 100%;"></canvas>
        </div>

        <div class="panel" style="max-height: 520px; overflow-y: auto;">
            <h3 style="margin-top: 0;" class="text-acidic">📋 Tabel Triple RDF (Subject-Predicate-Object)</h3>
            <table style="width: 100%; text-align: left; font-size: 0.8rem;" cellpadding="10">
                <thead>
                    <tr style="border-bottom: 2px solid var(--neon-acidic); color: var(--neon-acidic);">
                        <th>Subject (S)</th>
                        <th>Predicate (P)</th>
                        <th>Object (O)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($triples as $t): ?>
                    <tr style="border-bottom: 1px solid rgba(255,255,255,0.05);">
                        <td><strong><?= htmlspecialchars($t['s']) ?></strong></td>
                        <td style="color: var(--neon-acidic); font-family: monospace;">ex:<?= htmlspecialchars($t['p']) ?></td>
                        <td style="color: white;"><?= htmlspecialchars($t['o']) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        const canvas = document.getElementById('brutalCanvas');
        const ctx = canvas.getContext('2d');
        const cX = canvas.width / 2;
        const cY = canvas.height / 2;
        const triplesData = <?php echo json_encode($triples); ?>;

        function drawBrutalGraph() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            
            triplesData.forEach((t, i) => {
                const angle = (i * 2 * Math.PI) / triplesData.length;
                const dist = 160;
                const x = cX + dist * Math.cos(angle);
                const y = cY + dist * Math.sin(angle);

                // Garis Penghubung Relasi
                ctx.beginPath();
                ctx.moveTo(cX, cY);
                ctx.lineTo(x, y);
                ctx.strokeStyle = 'rgba(255, 255, 255, 0.1)';
                ctx.stroke();

                // Node Object Berbentuk Kotak Monospace
                ctx.fillStyle = 'oklch(0.12 0.02 165)';
                ctx.strokeStyle = 'var(--neon-acidic)';
                ctx.lineWidth = 1;
                ctx.fillRect(x - 55, y - 12, 110, 24);
                ctx.strokeRect(x - 55, y - 12, 110, 24);

                ctx.fillStyle = '#ffffff';
                ctx.font = '9px "JetBrains Mono"';
                ctx.textAlign = 'center';
                ctx.textBaseline = 'middle';
                ctx.fillText(t.o.length > 14 ? t.o.substring(0,11)+'...' : t.o, x, y);
            });

            // Node Subject Pusat Bersudut Tajam
            ctx.fillStyle = 'var(--neon-acidic)';
            ctx.fillRect(cX - 50, cY - 20, 100, 40);
            ctx.fillStyle = '#000000';
            ctx.font = 'bold 11px "JetBrains Mono"';
            ctx.textAlign = 'center';
            ctx.textBaseline = 'middle';
            ctx.fillText('Subject: Node', cX, cY);
        }
        drawBrutalGraph();
    </script>
</body>
</html>