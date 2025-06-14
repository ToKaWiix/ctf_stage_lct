<?php
// Récupère la page en GET, fallback à 'homeAdmin'
$page = $_GET['page'] ?? 'homeAdmin';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="<?= CSS_URL ?>/variables.css">
    <link rel="stylesheet" href="<?= CSS_URL ?>/<?= $page ?>.css">
</head>
<body>

<nav>
    <div id="nav-logo">
        <img src="<?= IMAGES_URL ?>/LCT-03.png" alt="Logo LCT">
    </div>
    <ul id="nav-tabs">
        <li class="nav-item">
            <a href="<?= BASE_URL ?>/dashboard.php?page=homeAdmin">Accueil</a>
        </li>
        <li class="nav-item">
            <a href="<?= BASE_URL ?>/dashboard.php?page=teams">Équipes</a>
        </li>
        <li class="nav-item">
            <a href="<?= BASE_URL ?>/dashboard.php?page=players">Joueurs</a>
        </li>
        <li class="nav-item">
            <a href="<?= BASE_URL ?>/dashboard.php?page=challenges">Challenges</a>
        </li>
        <li class="nav-item">
            <a href="<?= BASE_URL ?>/dashboard.php?page=config">Configuration</a>
        </li>
    </ul>
</nav>
