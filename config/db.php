<?php
// config/db.php

// ── Database ──────────────────────────────
define('DB_HOST', 'localhost');
define('DB_NAME', 'smart_academic_profile');
define('DB_USER', 'root');
define('DB_PASS', '');

// ── Aplikasi ──────────────────────────────
define('APP_NAME', 'Smart Academic Profile');
define('BASE_URL', 'https://projectvaulthub.my.id/profil-semantik');

// ── Session ───────────────────────────────
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ── Koneksi Database ─────────────────────
try {
    $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";
    $pdo = new PDO($dsn, DB_USER, DB_PASS, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ]);
} catch (PDOException $e) {
    http_response_code(500);
    die("<h2>Koneksi Database Gagal</h2><p>" . htmlspecialchars($e->getMessage()) . "</p>");
}

// ==========================================
// HELPER FUNCTIONS
// ==========================================

function e(string $str): string {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

function dbRow(PDO $pdo, string $sql, array $params = []): ?array {
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $row = $stmt->fetch();
    return $row ?: null;
}

function dbRows(PDO $pdo, string $sql, array $params = []): array {
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll();
}

function redirect(string $url): void {
    header("Location: " . $url);
    exit;
}

// ==========================================
// FLASH MESSAGE
// ==========================================

function setFlash(string $type, string $message): void {
    $_SESSION['flash'] = ['type' => $type, 'message' => $message];
}

function showFlash(): void {
    if (!isset($_SESSION['flash'])) return;
    $flash = $_SESSION['flash'];
    unset($_SESSION['flash']);

    $color = ($flash['type'] === 'success') ? '#16a34a' : '#dc2626';
    $bg = ($flash['type'] === 'success') ? '#dcfce7' : '#fee2e2';

    echo "<div style='background:{$bg}; color:{$color}; border:1px solid {$color}; border-radius:8px; padding:12px 16px; margin-bottom:16px; font-size:13px; font-weight:500;'>
            " . e($flash['message']) . "
          </div>";
}
?>