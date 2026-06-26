<?php
/**
 * ===========================================================
 * Smart Academic Profile
 * Configuration File
 * PHP Native 8
 * ===========================================================
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/*
|--------------------------------------------------------------------------
| Website Information
|--------------------------------------------------------------------------
*/

define('APP_NAME', 'Smart Academic Profile');
define('APP_VERSION', '1.0');
define('APP_AUTHOR', 'Munirotun Ni\'mah');
define('APP_DESCRIPTION', 'Semantic Web Student Profile');

/*
|--------------------------------------------------------------------------
| Base URL
|--------------------------------------------------------------------------
| Ganti sesuai lokasi project
|
| Laragon :
| http://smart-academic-profile.test/
|
| XAMPP :
| http://localhost/smart-academic-profile/
|
*/

define('BASE_URL', 'http://smart-academic-profile.test/');

/*
|--------------------------------------------------------------------------
| Upload Folder
|--------------------------------------------------------------------------
*/

define('UPLOAD_PROFILE', 'assets/uploads/profile/');
define('UPLOAD_PROJECT', 'assets/uploads/project/');

/*
|--------------------------------------------------------------------------
| Timezone
|--------------------------------------------------------------------------
*/

date_default_timezone_set('Asia/Makassar');

/*
|--------------------------------------------------------------------------
| Default Image
|--------------------------------------------------------------------------
*/

define('DEFAULT_PROFILE', 'default.jpg');
define('DEFAULT_COVER', 'cover.jpg');

/*
|--------------------------------------------------------------------------
| Social Media Default
|--------------------------------------------------------------------------
*/

define('DEFAULT_GITHUB', 'https://github.com/');
define('DEFAULT_LINKEDIN', 'https://linkedin.com/');

/*
|--------------------------------------------------------------------------
| Pagination
|--------------------------------------------------------------------------
*/

define('LIMIT_DATA', 10);

/*
|--------------------------------------------------------------------------
| Security
|--------------------------------------------------------------------------
*/

ini_set('display_errors', 1);
error_reporting(E_ALL);

/*
|--------------------------------------------------------------------------
| Success Message
|--------------------------------------------------------------------------
*/

function success($message)
{
    $_SESSION['success'] = $message;
}

/*
|--------------------------------------------------------------------------
| Error Message
|--------------------------------------------------------------------------
*/

function error($message)
{
    $_SESSION['error'] = $message;
}

/*
|--------------------------------------------------------------------------
| Flash Success
|--------------------------------------------------------------------------
*/

function showSuccess()
{
    if (isset($_SESSION['success'])) {

        echo '
        <div class="alert alert-success alert-dismissible fade show">
            '.$_SESSION['success'].'
            <button class="btn-close" data-bs-dismiss="alert"></button>
        </div>';

        unset($_SESSION['success']);
    }
}

/*
|--------------------------------------------------------------------------
| Flash Error
|--------------------------------------------------------------------------
*/

function showError()
{
    if (isset($_SESSION['error'])) {

        echo '
        <div class="alert alert-danger alert-dismissible fade show">
            '.$_SESSION['error'].'
            <button class="btn-close" data-bs-dismiss="alert"></button>
        </div>';

        unset($_SESSION['error']);
    }
}

/*
|--------------------------------------------------------------------------
| Escape HTML
|--------------------------------------------------------------------------
*/

function e($string)
{
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

/*
|--------------------------------------------------------------------------
| Redirect
|--------------------------------------------------------------------------
*/

function redirect($url)
{
    header("Location: ".$url);
    exit;
}

/*
|--------------------------------------------------------------------------
| Format Date
|--------------------------------------------------------------------------
*/

function tanggal($date)
{
    return date('d M Y', strtotime($date));
}

/*
|--------------------------------------------------------------------------
| Active Menu
|--------------------------------------------------------------------------
*/

function activeMenu($page)
{
    return basename($_SERVER['PHP_SELF']) == $page ? 'active' : '';
}