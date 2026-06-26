<?php
// helpers/semantic.php
require_once __DIR__ . '/../config/db.php';

function getJSONLD($pdo) {
    $profil = $pdo->query("SELECT * FROM profil LIMIT 1")->fetch();
    $skills = $pdo->query("SELECT nama FROM skill")->fetchAll(PDO::FETCH_COLUMN);
    
    $json = [
        "@context" => "https://schema.org",
        "@type" => "Person",
        "name" => $profil['nama'],
        "identifier" => $profil['nim'],
        "jobTitle" => "Mahasiswa " . $profil['program_studi'],
        "alumniOf" => [
            "@type" => "CollegeOrUniversity",
            "name" => $profil['universitas'],
            "department" => [
                "@type" => "EducationalOrganization",
                "name" => $profil['program_studi']
            ]
        ],
        "knowsAbout" => $skills
    ];
    return json_encode($json, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
}

function getTriples($pdo) {
    $profil = $pdo->query("SELECT * FROM profil LIMIT 1")->fetch();
    $skills = $pdo->query("SELECT nama FROM skill")->fetchAll(PDO::FETCH_COLUMN);
    
    $triples = [
        ["s" => $profil['nama'], "p" => "kuliahDi", "o" => $profil['universitas']],
        ["s" => $profil['nama'], "p" => "mengambilProgram", "o" => $profil['program_studi']]
    ];
    foreach($skills as $sk) {
        $triples[] = ["s" => $profil['nama'], "p" => "menguasai", "o" => $sk];
    }
    return $triples;
}
?>