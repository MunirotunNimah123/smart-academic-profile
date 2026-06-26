<?php

/**
 * ======================================================
 * HELPER
 * Smart Academic Profile
 * ======================================================
 */

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
| Upload File
|--------------------------------------------------------------------------
*/

function uploadImage($file, $folder)
{

    if ($file['error'] != 0) {

        return null;

    }

    $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

    $allow = [

        'jpg',

        'jpeg',

        'png',

        'webp'

    ];

    if (!in_array($extension, $allow)) {

        return false;

    }

    $filename = uniqid().".".$extension;

    move_uploaded_file(

        $file['tmp_name'],

        $folder.$filename

    );

    return $filename;

}

/*
|--------------------------------------------------------------------------
| Delete Image
|--------------------------------------------------------------------------
*/

function deleteImage($folder,$filename)
{

    if(empty($filename))
        return;

    $file = $folder.$filename;

    if(file_exists($file))
    {

        unlink($file);

    }

}

/*
|--------------------------------------------------------------------------
| Format Tanggal
|--------------------------------------------------------------------------
*/

function formatTanggal($tanggal)
{

    return date(

        "d F Y",

        strtotime($tanggal)

    );

}

/*
|--------------------------------------------------------------------------
| Limit Text
|--------------------------------------------------------------------------
*/

function limitText($text,$limit=100)
{

    if(strlen($text)<=$limit)

        return $text;

    return substr($text,0,$limit)." ...";

}

/*
|--------------------------------------------------------------------------
| Badge Featured
|--------------------------------------------------------------------------
*/

function featuredBadge($featured)
{

    if($featured==1){

        return '<span class="badge bg-success">Featured</span>';

    }

    return '';

}

/*
|--------------------------------------------------------------------------
| Progress Color
|--------------------------------------------------------------------------
*/

function progressColor($level)
{

    if($level>=80)

        return "bg-success";

    if($level>=60)

        return "bg-primary";

    if($level>=40)

        return "bg-warning";

    return "bg-danger";

}

/*
|--------------------------------------------------------------------------
| Active Sidebar
|--------------------------------------------------------------------------
*/

function activePage($page)
{

    $current = basename($_SERVER['PHP_SELF']);

    if($current==$page)

        return "active";

    return "";

}

/*
|--------------------------------------------------------------------------
| Hitung Total Data
|--------------------------------------------------------------------------
*/

function totalData($pdo,$table)
{

    $query = $pdo->query("SELECT COUNT(*) FROM $table");

    return $query->fetchColumn();

}

/*
|--------------------------------------------------------------------------
| Featured Project
|--------------------------------------------------------------------------
*/

function featuredProject($pdo)
{

    $query = $pdo->query("SELECT * FROM project WHERE featured=1 LIMIT 1");

    return $query->fetch(PDO::FETCH_ASSOC);

}

/*
|--------------------------------------------------------------------------
| Random Color
|--------------------------------------------------------------------------
*/

function randomColor()
{

    $color=[

        "#16a34a",

        "#0ea5e9",

        "#8b5cf6",

        "#f97316",

        "#dc2626"

    ];

    return $color[array_rand($color)];

}