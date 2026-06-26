<?php
/**
 * ======================================================
 * SESSION MANAGER
 * Smart Academic Profile
 * ======================================================
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/*
|--------------------------------------------------------------------------
| Login Admin
|--------------------------------------------------------------------------
*/

function isLogin()
{
    return isset($_SESSION['admin_login']);
}

/*
|--------------------------------------------------------------------------
| Wajib Login
|--------------------------------------------------------------------------
*/

function mustLogin()
{
    if (!isLogin()) {
        header("Location: login.php");
        exit;
    }
}

/*
|--------------------------------------------------------------------------
| Sudah Login
|--------------------------------------------------------------------------
*/

function alreadyLogin()
{
    if (isLogin()) {
        header("Location: dashboard.php");
        exit;
    }
}

/*
|--------------------------------------------------------------------------
| Login Admin
|--------------------------------------------------------------------------
*/

function loginAdmin($admin)
{
    session_regenerate_id(true);

    $_SESSION['admin_login'] = true;

    $_SESSION['admin_id'] = $admin['id'];

    $_SESSION['admin_name'] = $admin['nama'];

    $_SESSION['admin_username'] = $admin['username'];

    $_SESSION['login_time'] = time();
}

/*
|--------------------------------------------------------------------------
| Logout
|--------------------------------------------------------------------------
*/

function logoutAdmin()
{
    $_SESSION = [];

    if (ini_get("session.use_cookies")) {

        $params = session_get_cookie_params();

        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params["path"],
            $params["domain"],
            $params["secure"],
            $params["httponly"]
        );
    }

    session_destroy();

    header("Location: login.php");

    exit;
}

/*
|--------------------------------------------------------------------------
| Session Timeout
|--------------------------------------------------------------------------
| 2 Jam
|--------------------------------------------------------------------------
*/

$timeout = 7200;

if (isset($_SESSION['login_time'])) {

    if ((time() - $_SESSION['login_time']) > $timeout) {

        logoutAdmin();

    }

}