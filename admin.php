<?php
// admin.php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Pindahkan session_start ke paling atas sebelum meload db.php agar tidak bentrok
if (session_status() == PHP_SESSION_NONE) { 
    session_start(); 
}

require_once 'config/db.php';

$success = "";
$error = "";

// 1. PROSES AUTENTIKASI MASUK LANGSUNG (TANPA DATABASE COCOK TEKS)
if (isset($_POST['execute_login'])) {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if ($email === 'admin@gmail.com' && $password === 'admin123') {
        $_SESSION['admin_logged'] = true;
        $_SESSION['admin_email'] = $email;
        
        // Paksa refresh halaman ke dashboard admin setelah session sukses dibuat
        header("Location: admin.php");
        exit();
    } else {
        $error = "Email atau sandi salah!";
    }
}

if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: admin.php");
    exit();
}

// JIKA BELUM LOGIN, TAMPILKAN FORM MASUK
if (!isset($_SESSION['admin_logged'])):
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>🔑 Masuk Admin</title>
    <style>
        input { width: 100%; background: #07140b; border: 1px solid rgba(82, 255, 38, 0.15); padding: 12px; border-radius: 4px; color: white; margin-bottom: 15px; box-sizing: border-box; }
        label { display: block; margin-bottom: 6px; font-size: 0.8rem; color: #52ff26; }
        .neon-btn { background: #52ff26; color: #000; border: none; padding: 12px; border-radius: 4px; font-weight: bold; cursor: pointer; width: 100%; }
    </style>
</head>
<body style="background-color: #030a05; color: #ffffff; font-family: sans-serif; padding: 40px 20px;">
    <div style="max-width: 400px; margin: 80px auto; background: rgba(5, 20, 10, 0.6); border: 1px solid rgba(82, 255, 38, 0.15); padding: 30px; border-radius: 8px;">
        <h3 style="margin-top:0; color:#52ff26; text-align:center;">Otoritas Kendali Profil</h3>
        <p style="text-align:center; color:#a3b8a8; font-size:0.85rem; margin-bottom:25px;">Masuk dengan akun admin tunggal sistem</p>
        
        <?php if(!empty($error)): ?><div style="border:1px solid #ef4444; padding:10px; color:#ef4444; margin-bottom:15px; font-size:0.9rem;"><?= $error ?></div><?php endif; ?>

        <form action="admin.php" method="POST">
            <label>Email Admin</label>
            <input type="email" name="email" placeholder="admin@gmail.com" required>
            <label>Sandi Keamanan</label>
            <input type="password" name="password" placeholder="••••••••" required>
            <button type="submit" name="execute_login" class="neon-btn">Autentikasi Masuk ↗</button>
        </form>
    </div>
</body>
</html>
<?php
exit();
endif; 

// =========================================================================
// JIKA SUDAH LOGIN: TAMPILKAN PANEL DASHBOARD ADMINISTRATOR UTAMA
// =========================================================================
$current_tab = isset($_GET['tab']) ? $_GET['tab'] : 'profil';

// 2. PROSES UPDATE DATA (CRUD) - DENGAN PROTEKSI ERROR KOLOM DATABASE
if (isset($_POST['save_profil'])) {
    $stmt = $pdo->prepare("UPDATE profil SET nama=?, nim=?, program_studi=?, fakultas=?, universitas=?, email=?, domisili=?, bio=? WHERE id=1");
    $stmt->execute([$_POST['nama'], $_POST['nim'], $_POST['program_studi'], $_POST['fakultas'], $_POST['universitas'], $_POST['email'], $_POST['domisili'], $_POST['bio']]);
    $success = "Profil berhasil diperbarui!";
}

if (isset($_POST['save_data'])) {
    $table = $_POST['table_target'];
    $id = $_POST['id'];

    if ($table == 'pendidikan') {
        if (!empty($id)) {
            $stmt = $pdo->prepare("UPDATE pendidikan SET jenjang=?, institusi=?, tahun_masuk=?, tahun_keluar=? WHERE id=?");
            $stmt->execute([$_POST['jenjang'], $_POST['institusi'], $_POST['tahun_masuk'], $_POST['tahun_keluar'], $id]);
        } else {
            $stmt = $pdo->prepare("INSERT INTO pendidikan (jenjang, institusi, tahun_masuk, tahun_keluar) VALUES (?, ?, ?, ?)");
            $stmt->execute([$_POST['jenjang'], $_POST['institusi'], $_POST['tahun_masuk'], $_POST['tahun_keluar']]);
        }
    } elseif ($table == 'skill') {
        $q = $pdo->query("DESCRIBE skill");
        $columns = $q->fetchAll(PDO::FETCH_COLUMN);
        $has_persentase = in_array('persentase', $columns);

        if (!empty($id)) {
            if ($has_persentase) {
                $stmt = $pdo->prepare("UPDATE skill SET nama=?, kategori=?, persentase=? WHERE id=?");
                $stmt->execute([$_POST['nama'], $_POST['kategori'], $_POST['persentase'], $id]);
            } else {
                $stmt = $pdo->prepare("UPDATE skill SET nama=?, kategori=? WHERE id=?");
                $stmt->execute([$_POST['nama'], $_POST['kategori'], $id]);
            }
        } else {
            if ($has_persentase) {
                $stmt = $pdo->prepare("INSERT INTO skill (nama, kategori, persentase) VALUES (?, ?, ?)");
                $stmt->execute([$_POST['nama'], $_POST['kategori'], $_POST['persentase']]);
            } else {
                $stmt = $pdo->prepare("INSERT INTO skill (nama, kategori) VALUES (?, ?)");
                $stmt->execute([$_POST['nama'], $_POST['kategori']]);
            }
        }
    } elseif ($table == 'organisasi') {
        if (!empty($id)) {
            $stmt = $pdo->prepare("UPDATE organisasi SET nama=?, jabatan=?, tahun=? WHERE id=?");
            $stmt->execute([$_POST['nama'], $_POST['jabatan'], $_POST['tahun'], $id]);
        } else {
            $stmt = $pdo->prepare("INSERT INTO organisasi (nama, jabatan, tahun) VALUES (?, ?, ?)");
            $stmt->execute([$_POST['nama'], $_POST['jabatan'], $_POST['tahun']]);
        }
    } elseif ($table == 'proyek') {
        if (!empty($id)) {
            $stmt = $pdo->prepare("UPDATE proyek SET judul=?, tahun=? WHERE id=?");
            $stmt->execute([$_POST['judul'], $_POST['tahun'], $id]);
        } else {
            $stmt = $pdo->prepare("INSERT INTO proyek (judul, tahun) VALUES (?, ?)");
            $stmt->execute([$_POST['judul'], $_POST['tahun']]);
        }
    }
    header("Location: admin.php?tab=" . $current_tab);
    exit();
}

if (isset($_GET['delete']) && isset($_GET['table'])) {
    $table = $_GET['table'];
    $allowed_tables = ['pendidikan', 'skill', 'organisasi', 'proyek'];
    if (in_array($table, $allowed_tables)) {
        $stmt = $pdo->prepare("DELETE FROM $table WHERE id = ?");
        $stmt->execute([$_GET['delete']]);
    }
    header("Location: admin.php?tab=" . $current_tab);
    exit();
}

// AMBIL DATA DARI DATABASE
$profil = $pdo->query("SELECT * FROM profil LIMIT 1")->fetch();
$pendidikan = $pdo->query("SELECT * FROM pendidikan")->fetchAll();
$skill = $pdo->query("SELECT * FROM skill")->fetchAll();
$organisasi = $pdo->query("SELECT * FROM organisasi")->fetchAll();
$proyek = $pdo->query("SELECT * FROM proyek")->fetchAll();

$edit_data = null;
if (isset($_GET['edit']) && isset($_GET['table'])) {
    $stmt = $pdo->prepare("SELECT * FROM " . $_GET['table'] . " WHERE id = ?");
    $stmt->execute([$_GET['edit']]);
    $edit_data = $stmt->fetch();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - Panel Navigasi</title>
    <style>
        :root {
            --bg-dark: #030a05;
            --panel-bg: rgba(5, 20, 10, 0.6);
            --neon-green: #52ff26;
            --border-color: rgba(82, 255, 38, 0.15);
            --text-gray: #a3b8a8;
            --input-bg: #07140b;
        }
        body { background-color: var(--bg-dark); color: #ffffff; font-family: sans-serif; margin: 0; padding: 0; }
        .header-admin { display: flex; justify-content: space-between; align-items: center; padding: 15px 40px; border-bottom: 1px solid var(--border-color); }
        .tab-container { display: flex; gap: 12px; padding: 25px 40px 10px 40px; }
        .tab-btn { background: transparent; border: 1px solid var(--border-color); color: var(--text-gray); padding: 8px 20px; border-radius: 20px; text-decoration: none; font-size: 0.9rem; }
        .tab-btn.active { background: var(--neon-green); color: #000000; font-weight: bold; border-color: var(--neon-green); box-shadow: 0 0 10px rgba(82, 255, 38, 0.3); }
        .workspace { padding: 20px 40px; }
        .panel-form { background: var(--panel-bg); border: 1px solid var(--border-color); border-radius: 12px; padding: 30px; }
        .grid-profil { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px; }
        .form-group { display: flex; flex-direction: column; gap: 8px; }
        .form-group.full-width { grid-column: span 2; }
        input, textarea { background: var(--input-bg); border: 1px solid var(--border-color); border-radius: 8px; padding: 12px; color: #ffffff; font-size: 0.95rem; width:100%; box-sizing:border-box; }
        .btn-submit-block { width: 100%; background: var(--neon-green); color: #000000; border: none; padding: 14px; border-radius: 8px; font-weight: bold; cursor: pointer; }
        .btn-tambah { background: var(--neon-green); color: #000000; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: bold; display: inline-flex; margin-bottom: 20px; font-size: 0.9rem; }
        .data-list { display: flex; flex-direction: column; gap: 12px; }
        .data-item { display: flex; justify-content: space-between; align-items: center; background: rgba(5, 15, 8, 0.4); border: 1px solid rgba(82, 255, 38, 0.08); padding: 16px 24px; border-radius: 8px; }
        .btn-edit { background: transparent; border: 1px solid rgba(255,255,255,0.2); color: #ffffff; padding: 6px 14px; border-radius: 6px; text-decoration: none; font-size: 0.85rem; margin-right: 5px; }
        .btn-hapus { background: transparent; border: 1px solid rgba(239, 68, 68, 0.3); color: #ff5252; padding: 6px 14px; border-radius: 6px; text-decoration: none; font-size: 0.85rem; }
    </style>
</head>
<body>

    <div class="header-admin">
        <div><a href="index.php" style="color: var(--text-gray); text-decoration: none; font-size: 0.9rem;">← Kembali ke Web</a></div>
        <div style="font-weight:bold;">Admin Kontrol Panel</div>
        <a href="admin.php?logout=1" style="border: 1px solid #ff5252; color: #ff5252; padding: 6px 16px; border-radius: 20px; text-decoration: none; font-size: 0.85rem;">➡️ Keluar</a>
    </div>

    <div class="tab-container">
        <a href="admin.php?tab=profil" class="tab-btn <?= $current_tab == 'profil' ? 'active' : '' ?>">Profil</a>
        <a href="admin.php?tab=pendidikan" class="tab-btn <?= $current_tab == 'pendidikan' ? 'active' : '' ?>">Pendidikan</a>
        <a href="admin.php?tab=skill" class="tab-btn <?= $current_tab == 'skill' ? 'active' : '' ?>">Skill</a>
        <a href="admin.php?tab=organisasi" class="tab-btn <?= $current_tab == 'organisasi' ? 'active' : '' ?>">Organisasi</a>
        <a href="admin.php?tab=proyek" class="tab-btn <?= $current_tab == 'proyek' ? 'active' : '' ?>">Proyek</a>
    </div>

    <div class="workspace">
        
        <?php if (isset($_GET['action']) || $edit_data): 
            $action_target = isset($_GET['table']) ? $_GET['table'] : $current_tab;
        ?>
        <div class="panel-form" style="margin-bottom: 30px; border-color: var(--neon-green);">
            <h3 style="margin-top:0; color:var(--neon-green)">✏️ Kelola Data (<?= ucfirst($action_target) ?>)</h3>
            <form action="admin.php?tab=<?= $current_tab ?>" method="POST" style="display:flex; flex-direction:column; gap:12px;">
                <input type="hidden" name="table_target" value="<?= $action_target ?>">
                <input type="hidden" name="id" value="<?= $edit_data ? $edit_data['id'] : '' ?>">

                <?php if ($action_target == 'pendidikan'): ?>
                    <input type="text" name="jenjang" placeholder="Jenjang (Contoh: S1)" value="<?= $edit_data ? $edit_data['jenjang'] : '' ?>" required>
                    <input type="text" name="institusi" placeholder="Nama Institusi Kampus" value="<?= $edit_data ? $edit_data['institusi'] : '' ?>" required>
                    <input type="text" name="tahun_masuk" placeholder="Tahun Masuk" value="<?= $edit_data ? $edit_data['tahun_masuk'] : '' ?>" required>
                    <input type="text" name="tahun_keluar" placeholder="Tahun Keluar" value="<?= $edit_data ? $edit_data['tahun_keluar'] : '' ?>" required>
                <?php elseif ($action_target == 'skill'): ?>
                    <input type="text" name="nama" placeholder="Keterampilan (Contoh: PHP)" value="<?= $edit_data ? $edit_data['nama'] : '' ?>" required>
                    <input type="text" name="kategori" placeholder="Kategori (Frontend / Backend / Tools)" value="<?= $edit_data ? $edit_data['kategori'] : '' ?>" required>
                    <input type="number" name="persentase" placeholder="Persentase (Akan otomatis diabaikan jika tidak ada di DB)" value="<?= $edit_data ? ($edit_data['persentase'] ?? '') : '' ?>">
                <?php elseif ($action_target == 'organisasi'): ?>
                    <input type="text" name="nama" placeholder="Nama Organisasi" value="<?= $edit_data ? $edit_data['nama'] : '' ?>" required>
                    <input type="text" name="jabatan" placeholder="Jabatan" value="<?= $edit_data ? $edit_data['jabatan'] : '' ?>" required>
                    <input type="text" name="tahun" placeholder="Tahun Aktivitas" value="<?= $edit_data ? $edit_data['tahun'] : '' ?>" required>
                <?php elseif ($action_target == 'proyek'): ?>
                    <input type="text" name="judul" placeholder="Nama / Judul Proyek Aplikasi" value="<?= $edit_data ? $edit_data['judul'] : '' ?>" required>
                    <input type="text" name="tahun" placeholder="Tahun Pembuatan" value="<?= $edit_data ? $edit_data['tahun'] : '' ?>" required>
                <?php endif; ?>

                <button type="submit" name="save_data" class="btn-submit-block">💾 Konfirmasi Simpan</button>
            </form>
        </div>
        <?php endif; ?>

        <?php if ($current_tab == 'profil'): ?>
        <form action="admin.php?tab=profil" method="POST" class="panel-form">
            <div class="grid-profil">
                <div class="form-group"><label>Nama Lengkap</label><input type="text" name="nama" value="<?= htmlspecialchars($profil['nama'] ?? '') ?>"></div>
                <div class="form-group"><label>NIM</label><input type="text" name="nim" value="<?= htmlspecialchars($profil['nim'] ?? '') ?>"></div>
                <div class="form-group"><label>Program Studi</label><input type="text" name="program_studi" value="<?= htmlspecialchars($profil['program_studi'] ?? '') ?>"></div>
                <div class="form-group"><label>Fakultas</label><input type="text" name="fakultas" value="<?= htmlspecialchars($profil['fakultas'] ?? '') ?>"></div>
                <div class="form-group"><label>Universitas</label><input type="text" name="universitas" value="<?= htmlspecialchars($profil['universitas'] ?? '') ?>"></div>
                <div class="form-group"><label>Email</label><input type="email" name="email" value="<?= htmlspecialchars($profil['email'] ?? '') ?>"></div>
                <div class="form-group full-width"><label>Domisili</label><input type="text" name="domisili" value="<?= htmlspecialchars($profil['domisili'] ?? '') ?>"></div>
                <div class="form-group full-width"><label>Bio</label><textarea name="bio" rows="4"><?= htmlspecialchars($profil['bio'] ?? '') ?></textarea></div>
            </div>
            <button type="submit" name="save_profil" class="btn-submit-block">💾 Simpan Perubahan Profil</button>
        </form>

        <?php elseif ($current_tab == 'pendidikan'): ?>
        <a href="admin.php?tab=pendidikan&action=add&table=pendidikan" class="btn-tambah">➕ Tambah Baru</a>
        <div class="data-list">
            <?php foreach($pendidikan as $p): ?>
            <div class="data-item">
                <div><strong><?= htmlspecialchars($p['jenjang']) ?></strong> - <?= htmlspecialchars($p['institusi']) ?> (<?= htmlspecialchars($p['tahun_masuk']) ?>-<?= htmlspecialchars($p['tahun_keluar']) ?>)</div>
                <div>
                    <a href="admin.php?tab=pendidikan&edit=<?= $p['id'] ?>&table=pendidikan" class="btn-edit">Edit</a>
                    <a href="admin.php?tab=pendidikan&delete=<?= $p['id'] ?>&table=pendidikan" class="btn-hapus" onclick="return confirm('Hapus?')">Hapus</a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <?php elseif ($current_tab == 'skill'): ?>
        <a href="admin.php?tab=skill&action=add&table=skill" class="btn-tambah">➕ Tambah Baru</a>
        <div class="data-list">
            <?php foreach($skill as $s): ?>
            <div class="data-item">
                <div><strong><?= htmlspecialchars($s['nama']) ?></strong> [<?= htmlspecialchars($s['kategori']) ?>] <?= isset($s['persentase']) ? '- ' . htmlspecialchars($s['persentase']) . '%' : '' ?></div>
                <div>
                    <a href="admin.php?tab=skill&edit=<?= $s['id'] ?>&table=skill" class="btn-edit">Edit</a>
                    <a href="admin.php?tab=skill&delete=<?= $s['id'] ?>&table=skill" class="btn-hapus" onclick="return confirm('Hapus?')">Hapus</a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <?php elseif ($current_tab == 'organisasi'): ?>
        <a href="admin.php?tab=organisasi&action=add&table=organisasi" class="btn-tambah">➕ Tambah Baru</a>
        <div class="data-list">
            <?php foreach($organisasi as $o): ?>
            <div class="data-item">
                <div><strong><?= htmlspecialchars($o['nama']) ?></strong> - <?= htmlspecialchars($o['jabatan']) ?> (<?= htmlspecialchars($o['tahun']) ?>)</div>
                <div>
                    <a href="admin.php?tab=organisasi&edit=<?= $o['id'] ?>&table=organisasi" class="btn-edit">Edit</a>
                    <a href="admin.php?tab=organisasi&delete=<?= $o['id'] ?>&table=organisasi" class="btn-hapus" onclick="return confirm('Hapus?')">Hapus</a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <?php elseif ($current_tab == 'proyek'): ?>
        <a href="admin.php?tab=proyek&action=add&table=proyek" class="btn-tambah">➕ Tambah Baru</a>
        <div class="data-list">
            <?php foreach($proyek as $pr): ?>
            <div class="data-item">
                <div><strong><?= htmlspecialchars($pr['judul']) ?></strong> (<?= htmlspecialchars($pr['tahun']) ?>)</div>
                <div>
                    <a href="admin.php?tab=proyek&edit=<?= $pr['id'] ?>&table=proyek" class="btn-edit">Edit</a>
                    <a href="admin.php?tab=proyek&delete=<?= $pr['id'] ?>&table=proyek" class="btn-hapus" onclick="return confirm('Hapus?')">Hapus</a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

    </div>
</body>
</html>