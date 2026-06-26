<?php
// navbar.php
$active_page = basename($_SERVER['PHP_SELF']);
?>
<nav class="navbar">
    <div style="font-weight: 800; font-size: 1.2rem; display: flex; align-items: center; gap: 8px;" class="font-display">
        <span style="background: var(--lime); color: black; border-radius: 50%; width: 28px; height: 28px; display: flex; align-items: center; justify-content: center;">M</span>
        smart-academic-profile
    </div>
    <div class="nav-links">
        <a href="index.php" class="<?= $active_page == 'index.php' ? 'active' : '' ?>">Tentang</a>
        <a href="riwayat.php" class="<?= $active_page == 'riwayat.php' ? 'active' : '' ?>">Pendidikan</a>
        <a href="proyek.php" class="<?= $active_page == 'proyek.php' ? 'active' : '' ?>">Proyek</a>
        <a href="relasi.php" class="<?= $active_page == 'relasi.php' ? 'active' : '' ?>">Relasi Semantik</a>
        <a href="schema.php" class="<?= $active_page == 'schema.php' ? 'active' : '' ?>">Schema.org</a>
    </div>
    <a href="admin.php" style="border: 1px solid var(--lime); color: var(--lime); padding: 6px 16px; border-radius: 20px; text-decoration: none; font-size: 0.9rem;">🔒 Admin</a>
</nav>