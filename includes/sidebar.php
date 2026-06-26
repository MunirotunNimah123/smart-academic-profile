<?php
$currentPage = basename($_SERVER['PHP_SELF']);
?>

<aside class="sidebar">

    <div class="logo-area">

        <img src="<?= BASE_URL ?>assets/images/logo.png"
             class="logo-img"
             alt="Logo">

        <h4>Smart Academic Profile</h4>

        <small>Semantic Web</small>

    </div>

    <ul class="sidebar-menu">

        <li class="<?= ($currentPage=="index.php") ? "active" : "" ?>">
            <a href="<?= BASE_URL ?>index.php">
                <i class="bi bi-speedometer2"></i>
                Dashboard
            </a>
        </li>

        <li class="<?= ($currentPage=="profil.php") ? "active" : "" ?>">
            <a href="<?= BASE_URL ?>pages/profil.php">
                <i class="bi bi-person-circle"></i>
                Profil
            </a>
        </li>

        <li class="<?= ($currentPage=="pendidikan.php") ? "active" : "" ?>">
            <a href="<?= BASE_URL ?>pages/pendidikan.php">
                <i class="bi bi-mortarboard"></i>
                Pendidikan
            </a>
        </li>

        <li class="<?= ($currentPage=="skill.php") ? "active" : "" ?>">
            <a href="<?= BASE_URL ?>pages/skill.php">
                <i class="bi bi-lightning-charge"></i>
                Skill
            </a>
        </li>

        <li class="<?= ($currentPage=="organisasi.php") ? "active" : "" ?>">
            <a href="<?= BASE_URL ?>pages/organisasi.php">
                <i class="bi bi-people-fill"></i>
                Organisasi
            </a>
        </li>

        <li class="<?= ($currentPage=="project.php") ? "active" : "" ?>">
            <a href="<?= BASE_URL ?>pages/project.php">
                <i class="bi bi-kanban-fill"></i>
                Project
            </a>
        </li>

        <li class="<?= ($currentPage=="relationship.php") ? "active" : "" ?>">
            <a href="<?= BASE_URL ?>semantic/relationship.php">
                <i class="bi bi-diagram-3-fill"></i>
                Semantic Relationship
            </a>
        </li>

        <li class="<?= ($currentPage=="schema.php") ? "active" : "" ?>">
            <a href="<?= BASE_URL ?>semantic/schema.php">
                <i class="bi bi-braces"></i>
                Schema.org
            </a>
        </li>

        <li class="<?= ($currentPage=="owl.php") ? "active" : "" ?>">
            <a href="<?= BASE_URL ?>semantic/owl.php">
                <i class="bi bi-diagram-2-fill"></i>
                OWL Ontology
            </a>
        </li>

        <li class="<?= ($currentPage=="sparql.php") ? "active" : "" ?>">
            <a href="<?= BASE_URL ?>semantic/sparql.php">
                <i class="bi bi-search"></i>
                SPARQL
            </a>
        </li>

        <li class="<?= ($currentPage=="dbpedia.php") ? "active" : "" ?>">
            <a href="<?= BASE_URL ?>semantic/dbpedia.php">
                <i class="bi bi-database-fill"></i>
                DBpedia
            </a>
        </li>

        <li class="<?= ($currentPage=="linkeddata.php") ? "active" : "" ?>">
            <a href="<?= BASE_URL ?>semantic/linkeddata.php">
                <i class="bi bi-share-fill"></i>
                Linked Data
            </a>
        </li>

        <li class="<?= ($currentPage=="about.php") ? "active" : "" ?>">
            <a href="<?= BASE_URL ?>pages/about.php">
                <i class="bi bi-info-circle-fill"></i>
                Tentang Website
            </a>
        </li>

        <li class="<?= ($currentPage=="contact.php") ? "active" : "" ?>">
            <a href="<?= BASE_URL ?>pages/contact.php">
                <i class="bi bi-envelope-fill"></i>
                Kontak
            </a>
        </li>

        <hr>

        <li>
            <a href="<?= BASE_URL ?>admin/login.php">
                <i class="bi bi-box-arrow-in-right"></i>
                Login Admin
            </a>
        </li>

    </ul>

</aside>