<?php
// admin.php
error_reporting(E_ALL);
ini_set('display_errors', 1);

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
    <title>🔒 Admin Auth - Cyber Blue</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;700&display=swap');
        
        :root {
            --bg-cyber: #020617;
            --panel-bg: rgba(15, 23, 42, 0.8);
            --neon-blue: #38bdf8;
            --blue-glow: rgba(56, 189, 248, 0.4);
            --border-blue: rgba(56, 189, 248, 0.2);
        }
        * { box-sizing: border-box; font-family: 'JetBrains Mono', monospace; }
        body { background: var(--bg-cyber); color: #f8fafc; padding: 40px 20px; margin:0; }
        .login-box { max-width: 420px; margin: 100px auto; background: var(--panel-bg); border: 1px solid var(--border-blue); padding: 35px; border-radius: 8px; box-shadow: 0 0 25px rgba(0,0,0,0.5), 0 0 15px rgba(56,189,248,0.05); }
        input { width: 100%; background: #090d16; border: 1px solid var(--border-blue); padding: 12px; border-radius: 6px; color: white; margin-bottom: 20px; font-size: 0.9rem; }
        input:focus { outline: none; border-color: var(--neon-blue); box-shadow: 0 0 10px var(--blue-glow); }
        label { display: block; margin-bottom: 8px; font-size: 0.8rem; color: var(--neon-blue); font-weight: bold; letter-spacing: 0.05em; }
        .neon-btn-auth { background: var(--neon-blue); color: #020617; border: none; padding: 14px; border-radius: 6px; font-weight: bold; cursor: pointer; width: 100%; font-size: 0.95rem; text-shadow: 0 0 2px rgba(255,255,255,0.5); }
        .neon-btn-auth:hover { box-shadow: 0 0 20px var(--neon-blue); transform: translateY(-1px); }
    </style>
</head>
<body>
    <div class="login-box">
        <h3 style="margin-top:0; color:var(--neon-blue); text-align:center; font-size:1.3rem;">Otoritas Kendali Profil</h3>
        <p style="text-align:center; color:#94a3b8; font-size:0.8rem; margin-bottom:30px;">Masuk dengan akun admin tunggal sistem</p>
        
        <?php if(!empty($error)): ?><div style="border:1px solid #f87171; padding:10px; color:#f87171; background:rgba(248,113,113,0.1); margin-bottom:20px; font-size:0.85rem; border-radius:4px;"><?= $error ?></div><?php endif; ?>

        <form action="admin.php" method="POST">
            <label>EMAIL ADMINISTRATOR</label>
            <input type="email" name="email" placeholder="admin@gmail.com" required>
            <label>KATA SANDI KEAMANAN</label>
            <input type="password" name="password" placeholder="••••••••" required>
            <button type="submit" name="execute_login" class="neon-btn-auth">Autentikasi Masuk ↗</button>
        </form>
    </div>
</body>
</html>
<?php
exit();
endif; 

// =========================================================================
// JIKA SUDAH LOGIN: DASHBOARD UTAMA ISOLATED CYBER BLUE STYLE
// =========================================================================
$current_tab = isset($_GET['tab']) ? $_GET['tab'] : 'profil';

// 2. PROSES UPDATE DATA (CRUD)
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
    } elseif ($table == 'relasi') {
        if (!empty($id)) {
            $stmt = $pdo->prepare("UPDATE relasi SET subject=?, predicate=?, object=? WHERE id=?");
            $stmt->execute([$_POST['subject'], $_POST['predicate'], $_POST['object'], $id]);
        } else {
            $stmt = $pdo->prepare("INSERT INTO relasi (subject, predicate, object) VALUES (?, ?, ?)");
            $stmt->execute([$_POST['subject'], $_POST['predicate'], $_POST['object']]);
        }
    }
    header("Location: admin.php?tab=" . $current_tab);
    exit();
}

if (isset($_GET['delete']) && isset($_GET['table'])) {
    $table = $_GET['table'];
    $allowed_tables = ['pendidikan', 'skill', 'organisasi', 'proyek', 'relasi'];
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

try {
    $relasi = $pdo->query("SELECT * FROM relasi")->fetchAll();
} catch (Exception $e) {
    $relasi = [];
}

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
    <title>Admin Dashboard - Cyber Blue Panel</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;700&display=swap');
        
        /* ISOLASI PROTEKSI CSS ADMIN */
        .adm-body { background-color: #020617 !important; color: #f8fafc !important; font-family: 'JetBrains Mono', monospace !important; margin: 0; padding: 0; }
        .adm-header { display: flex; justify-content: space-between; align-items: center; padding: 20px 40px; border-bottom: 1px solid rgba(56, 189, 248, 0.2); background: #0f172a; }
        .adm-tabs { display: flex; gap: 10px; padding: 30px 40px 10px 40px; flex-wrap: wrap; }
        .adm-tab-btn { background: transparent; border: 1px solid rgba(56, 189, 248, 0.2); color: #94a3b8; padding: 10px 22px; border-radius: 20px; text-decoration: none; font-size: 0.85rem; font-weight: bold; transition: all 0.2s ease; }
        .adm-tab-btn:hover { border-color: #38bdf8; color: #38bdf8; box-shadow: 0 0 10px rgba(56, 189, 248, 0.15); }
        .adm-tab-btn.adm-active { background: #38bdf8 !important; color: #020617 !important; border-color: #38bdf8 !important; box-shadow: 0 0 15px rgba(56, 189, 248, 0.4); }
        
        .adm-workspace { padding: 20px 40px; }
        .adm-panel-form { background: rgba(15, 23, 42, 0.6); border: 1px solid rgba(56, 189, 248, 0.2); border-radius: 12px; padding: 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.3); }
        .adm-grid-profil { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px; }
        .adm-form-group { display: flex; flex-direction: column; gap: 8px; }
        .adm-form-group.full-width { grid-column: span 2; }
        
        .adm-input, .adm-textarea { background: #090d16 !important; border: 1px solid rgba(56, 189, 248, 0.2) !important; border-radius: 8px !important; padding: 12px !important; color: #ffffff !important; font-size: 0.9rem !important; width: 100% !important; box-sizing: border-box !important; }
        .adm-input:focus, .adm-textarea:focus { outline: none !important; border-color: #38bdf8 !important; box-shadow: 0 0 10px rgba(56, 189, 248, 0.3) !important; }
        
        .adm-btn-block { width: 100%; background: #38bdf8; color: #020617; border: none; padding: 14px; border-radius: 8px; font-weight: bold; cursor: pointer; font-size: 0.95rem; transition: all 0.2s ease; }
        .adm-btn-block:hover { box-shadow: 0 0 15px #38bdf8; transform: translateY(-1px); }
        
        .adm-btn-tambah { background: transparent; border: 1px solid #38bdf8; color: #38bdf8; padding: 10px 22px; border-radius: 8px; text-decoration: none; font-weight: bold; display: inline-flex; margin-bottom: 25px; font-size: 0.85rem; transition: all 0.2s ease; }
        .adm-btn-tambah:hover { background: #38bdf8; color: #020617; box-shadow: 0 0 15px rgba(56, 189, 248, 0.4); }
        
        .adm-list { display: flex; flex-direction: column; gap: 12px; }
        .adm-item { display: flex; justify-content: space-between; align-items: center; background: rgba(15, 23, 42, 0.4); border: 1px solid rgba(56, 189, 248, 0.1); padding: 18px 24px; border-radius: 8px; transition: all 0.2s ease; }
        .adm-item:hover { border-color: rgba(56, 189, 248, 0.3); background: rgba(15, 23, 42, 0.6); }
        
        .adm-btn-edit { background: transparent; border: 1px solid rgba(255,255,255,0.15); color: #f8fafc; padding: 6px 14px; border-radius: 6px; text-decoration: none; font-size: 0.8rem; margin-right: 5px; }
        .adm-btn-edit:hover { border-color: #38bdf8; color: #38bdf8; }
        .adm-btn-hapus { background: transparent; border: 1px solid rgba(239, 68, 68, 0.3); color: #f87171; padding: 6px 14px; border-radius: 6px; text-decoration: none; font-size: 0.8rem; }
        .adm-btn-hapus:hover { background: rgba(239, 68, 68, 0.1); box-shadow: 0 0 8px rgba(239, 68, 68, 0.2); }
    </style>
</head>
<body class="adm-body">

    <div class="adm-header">
        <div><a href="index.php" style="color: #94a3b8; text-decoration: none; font-size: 0.85rem; font-weight: bold; border: 1px solid rgba(255,255,255,0.1); padding: 6px 14px; border-radius: 6px;">← Kembali ke Web</a></div>
        <div style="font-weight:bold; font-size:1.1rem; color:#38bdf8; text-shadow: 0 0 10px rgba(56,189,248,0.2);">CONTROL PANEL ADMINISTRATOR</div>
        <a href="admin.php?logout=1" style="border: 1px solid #f87171; color: #f87171; padding: 6px 16px; border-radius: 20px; text-decoration: none; font-size: 0.8rem; font-weight: bold;">➡️ Keluar</a>
    </div>

    <div class="adm-tabs">
        <a href="admin.php?tab=profil" class="adm-tab-btn <?= $current_tab == 'profil' ? 'adm-active' : '' ?>">Profil</a>
        <a href="admin.php?tab=pendidikan" class="adm-tab-btn <?= $current_tab == 'pendidikan' ? 'adm-active' : '' ?>">Pendidikan</a>
        <a href="admin.php?tab=skill" class="adm-tab-btn <?= $current_tab == 'skill' ? 'adm-active' : '' ?>">Skill</a>
        <a href="admin.php?tab=organisasi" class="adm-tab-btn <?= $current_tab == 'organisasi' ? 'adm-active' : '' ?>">Organisasi</a>
        <a href="admin.php?tab=proyek" class="adm-tab-btn <?= $current_tab == 'proyek' ? 'adm-active' : '' ?>">Proyek</a>
        <a href="admin.php?tab=relasi" class="adm-tab-btn <?= $current_tab == 'relasi' ? 'adm-active' : '' ?>">Relasi Semantik</a>
    </div>

    <div class="adm-workspace">
        
        <?php if (isset($_GET['action']) || $edit_data): 
            $action_target = isset($_GET['table']) ? $_GET['table'] : $current_tab;
        ?>
        <div class="adm-panel-form" style="margin-bottom: 30px; border-color: #38bdf8;">
            <h3 style="margin-top:0; color:#38bdf8; font-size:1.1rem; margin-bottom:20px;">✏️ KELOLA DATA (<?= strtoupper($action_target) ?>)</h3>
            <form action="admin.php?tab=<?= $current_tab ?>" method="POST" style="display:flex; flex-direction:column; gap:14px;">
                <input type="hidden" name="table_target" value="<?= $action_target ?>">
                <input type="hidden" name="id" value="<?= $edit_data ? $edit_data['id'] : '' ?>">

                <?php if ($action_target == 'pendidikan'): ?>
                    <input type="text" class="adm-input" name="jenjang" placeholder="Jenjang (Contoh: S1)" value="<?= $edit_data ? $edit_data['jenjang'] : '' ?>" required>
                    <input type="text" class="adm-input" name="institusi" placeholder="Nama Institusi Kampus" value="<?= $edit_data ? $edit_data['institusi'] : '' ?>" required>
                    <input type="text" class="adm-input" name="tahun_masuk" placeholder="Tahun Masuk" value="<?= $edit_data ? $edit_data['tahun_masuk'] : '' ?>" required>
                    <input type="text" class="adm-input" name="tahun_keluar" placeholder="Tahun Keluar" value="<?= $edit_data ? $edit_data['tahun_keluar'] : '' ?>" required>
                <?php elseif ($action_target == 'skill'): ?>
                    <input type="text" class="adm-input" name="nama" placeholder="Keterampilan (Contoh: PHP)" value="<?= $edit_data ? $edit_data['nama'] : '' ?>" required>
                    <input type="text" class="adm-input" name="kategori" placeholder="Kategori (Frontend / Backend / Tools)" value="<?= $edit_data ? $edit_data['kategori'] : '' ?>" required>
                    <input type="number" class="adm-input" name="persentase" placeholder="Persentase" value="<?= $edit_data ? ($edit_data['persentase'] ?? '') : '' ?>">
                <?php elseif ($action_target == 'organisasi'): ?>
                    <input type="text" class="adm-input" name="nama" placeholder="Nama Organisasi" value="<?= $edit_data ? $edit_data['nama'] : '' ?>" required>
                    <input type="text" class="adm-input" name="jabatan" placeholder="Jabatan" value="<?= $edit_data ? $edit_data['jabatan'] : '' ?>" required>
                    <input type="text" class="adm-input" name="tahun" placeholder="Tahun Aktivitas" value="<?= $edit_data ? $edit_data['tahun'] : '' ?>" required>
                <?php elseif ($action_target == 'proyek'): ?>
                    <input type="text" class="adm-input" name="judul" placeholder="Nama / Judul Proyek Aplikasi" value="<?= $edit_data ? $edit_data['judul'] : '' ?>" required>
                    <input type="text" class="adm-input" name="tahun" placeholder="Tahun Pembuatan" value="<?= $edit_data ? $edit_data['tahun'] : '' ?>" required>
                <?php elseif ($action_target == 'relasi'): ?>
                    <input type="text" class="adm-input" name="subject" placeholder="Subject (Contoh: Munirotun Ni'mah)" value="<?= $edit_data ? $edit_data['subject'] : '' ?>" required>
                    <input type="text" class="adm-input" name="predicate" placeholder="Predicate (Contoh: kuliahDi / menguasai)" value="<?= $edit_data ? $edit_data['predicate'] : '' ?>" required>
                    <input type="text" class="adm-input" name="object" placeholder="Object (Contoh: Universitas Halu Oleo / PHP)" value="<?= $edit_data ? $edit_data['object'] : '' ?>" required>
                <?php endif; ?>

                <button type="submit" name="save_data" class="adm-btn-block">💾 Konfirmasi Simpan</button>
            </form>
        </div>
        <?php endif; ?>

        <?php if ($current_tab == 'profil'): ?>
        <?php if(!empty($success)): ?><div style="border:1px solid #34d399; padding:12px; color:#34d399; background:rgba(52,211,153,0.1); margin-bottom:20px; font-size:0.9rem; border-radius:6px;">✔ <?= $success ?></div><?php endif; ?>
        <form action="admin.php?tab=profil" method="POST" class="adm-panel-form">
            <div class="adm-grid-profil">
                <div class="adm-form-group"><label style="color:#38bdf8; font-size:0.75rem;">NAMA LENGKAP</label><input type="text" class="adm-input" name="nama" value="<?= htmlspecialchars($profil['nama'] ?? '') ?>"></div>
                <div class="adm-form-group"><label style="color:#38bdf8; font-size:0.75rem;">NIM</label><input type="text" class="adm-input" name="nim" value="<?= htmlspecialchars($profil['nim'] ?? '') ?>"></div>
                <div class="adm-form-group"><label style="color:#38bdf8; font-size:0.75rem;">PROGRAM STUDI</label><input type="text" class="adm-input" name="program_studi" value="<?= htmlspecialchars($profil['program_studi'] ?? '') ?>"></div>
                <div class="adm-form-group"><label style="color:#38bdf8; font-size:0.75rem;">FAKULTAS</label><input type="text" class="adm-input" name="fakultas" value="<?= htmlspecialchars($profil['fakultas'] ?? '') ?>"></div>
                <div class="adm-form-group"><label style="color:#38bdf8; font-size:0.75rem;">UNIVERSITAS</label><input type="text" class="adm-input" name="universitas" value="<?= htmlspecialchars($profil['universitas'] ?? '') ?>"></div>
                <div class="adm-form-group"><label style="color:#38bdf8; font-size:0.75rem;">EMAIL</label><input type="email" class="adm-input" name="email" value="<?= htmlspecialchars($profil['email'] ?? '') ?>"></div>
                <div class="adm-form-group full-width"><label style="color:#38bdf8; font-size:0.75rem;">DOMISILI</label><input type="text" class="adm-input" name="domisili" value="<?= htmlspecialchars($profil['domisili'] ?? '') ?>"></div>
                <div class="adm-form-group full-width"><label style="color:#38bdf8; font-size:0.75rem;">BIO DESKRIPSI</label><textarea class="adm-textarea" name="bio" rows="4"><?= htmlspecialchars($profil['bio'] ?? '') ?></textarea></div>
            </div>
            <button type="submit" name="save_profil" class="adm-btn-block">💾 Simpan Perubahan Profil</button>
        </form>

        <?php elseif ($current_tab == 'pendidikan'): ?>
        <a href="admin.php?tab=pendidikan&action=add&table=pendidikan" class="adm-btn-tambah">➕ Tambah Baru</a>
        <div class="adm-list">
            <?php foreach($pendidikan as $p): ?>
            <div class="adm-item">
                <div><strong style="color:#38bdf8;"><?= htmlspecialchars($p['jenjang']) ?></strong> - <?= htmlspecialchars($p['institusi']) ?> (<?= htmlspecialchars($p['tahun_masuk']) ?>-<?= htmlspecialchars($p['tahun_keluar']) ?>)</div>
                <div>
                    <a href="admin.php?tab=pendidikan&edit=<?= $p['id'] ?>&table=pendidikan" class="adm-btn-edit">Edit</a>
                    <a href="admin.php?tab=pendidikan&delete=<?= $p['id'] ?>&table=pendidikan" class="adm-btn-hapus" onclick="return confirm('Hapus?')">Hapus</a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <?php elseif ($current_tab == 'skill'): ?>
        <a href="admin.php?tab=skill&action=add&table=skill" class="adm-btn-tambah">➕ Tambah Baru</a>
        <div class="adm-list">
            <?php foreach($skill as $s): ?>
            <div class="adm-item">
                <div><strong style="color:#38bdf8;"><?= htmlspecialchars($s['nama']) ?></strong> [<?= htmlspecialchars($s['kategori']) ?>] <?= isset($s['persentase']) ? '- ' . htmlspecialchars($s['persentase']) . '%' : '' ?></div>
                <div>
                    <a href="admin.php?tab=skill&edit=<?= $s['id'] ?>&table=skill" class="adm-btn-edit">Edit</a>
                    <a href="admin.php?tab=skill&delete=<?= $s['id'] ?>&table=skill" class="adm-btn-hapus" onclick="return confirm('Hapus?')">Hapus</a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <?php elseif ($current_tab == 'organisasi'): ?>
        <a href="admin.php?tab=organisasi&action=add&table=organisasi" class="adm-btn-tambah">➕ Tambah Baru</a>
        <div class="adm-list">
            <?php foreach($organisasi as $o): ?>
            <div class="adm-item">
                <div><strong style="color:#38bdf8;"><?= htmlspecialchars($o['nama']) ?></strong> - <?= htmlspecialchars($o['jabatan']) ?> (<?= htmlspecialchars($o['tahun']) ?>)</div>
                <div>
                    <a href="admin.php?tab=organisasi&edit=<?= $o['id'] ?>&table=organisasi" class="adm-btn-edit">Edit</a>
                    <a href="admin.php?tab=organisasi&delete=<?= $o['id'] ?>&table=organisasi" class="adm-btn-hapus" onclick="return confirm('Hapus?')">Hapus</a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <?php elseif ($current_tab == 'proyek'): ?>
        <a href="admin.php?tab=proyek&action=add&table=proyek" class="adm-btn-tambah">➕ Tambah Baru</a>
        <div class="adm-list">
            <?php foreach($proyek as $pr): ?>
            <div class="adm-item">
                <div><strong style="color:#38bdf8;"><?= htmlspecialchars($pr['judul']) ?></strong> (<?= htmlspecialchars($pr['tahun']) ?>)</div>
                <div>
                    <a href="admin.php?tab=proyek&edit=<?= $pr['id'] ?>&table=proyek" class="adm-btn-edit">Edit</a>
                    <a href="admin.php?tab=proyek&delete=<?= $pr['id'] ?>&table=proyek" class="adm-btn-hapus" onclick="return confirm('Hapus?')">Hapus</a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <?php elseif ($current_tab == 'relasi'): ?>
        <a href="admin.php?tab=relasi&action=add&table=relasi" class="adm-btn-tambah">➕ Tambah Baru</a>
        <div class="adm-list">
            <?php if (empty($relasi)): ?>
                <div class="adm-item">
                    <div><em>Belum ada data relasi semantik kustom di database. Menampilkan fallback otomatis:</em></div>
                </div>
                <div class="adm-item"><div><?= htmlspecialchars($profil['nama'] ?? 'Munirotun Ni\'mah') ?> ➔ <strong style="color:#38bdf8;">kuliahDi</strong> ➔ <?= htmlspecialchars($profil['universitas'] ?? 'Universitas Halu Oleo') ?></div></div>
                <div class="adm-item"><div><?= htmlspecialchars($profil['nama'] ?? 'Munirotun Ni\'mah') ?> ➔ <strong style="color:#38bdf8;">mengambilProgram</strong> ➔ <?= htmlspecialchars($profil['program_studi'] ?? 'Ilmu Komputer') ?></div></div>
            <?php else: ?>
                <?php foreach($relasi as $r): ?>
                <div class="adm-item">
                    <div>
                        <strong><?= htmlspecialchars($r['subject']) ?></strong> ➔ 
                        <span style="color: #38bdf8; font-family: monospace; font-weight: bold;"><?= htmlspecialchars($r['predicate']) ?></span> ➔ 
                        <strong><?= htmlspecialchars($r['object']) ?></strong>
                    </div>
                    <div>
                        <a href="admin.php?tab=relasi&edit=<?= $r['id'] ?>&table=relasi" class="adm-btn-edit">Edit</a>
                        <a href="admin.php?tab=relasi&delete=<?= $r['id'] ?>&table=relasi" class="adm-btn-hapus" onclick="return confirm('Hapus relasi ini?')">Hapus</a>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <?php endif; ?>

    </div>
</body>
</html>