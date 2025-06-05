<?php
// Récupère la page en GET, fallback à 'homeAdmin'
$page = $_GET['page'] ?? 'homeAdmin';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="/ctf_anna/ctf-challenge/public/css/variables.css">
    <link rel="stylesheet" href="/ctf_anna/ctf-challenge/public/css/<?= $page ?>.css">
</head>
<body>

<nav>
    <div id="nav-logo">
        <img src="/ctf_anna/ctf-challenge/public/images/LCT-03.png" alt="Logo LCT">
    </div>
    <ul id="nav-tabs">
        <li class="nav-item">
            <a href="/ctf_anna/ctf-challenge/public/dashboard.php?page=homeAdmin">Accueil</a>
        </li>
        <li class="nav-item">
            <a href="/ctf_anna/ctf-challenge/public/dashboard.php?page=teams">Équipes</a>
        </li>
        <li class="nav-item">
            <a href="/ctf_anna/ctf-challenge/public/dashboard.php?page=players">Joueurs</a>
        </li>
        <li class="nav-item">
            <a href="/ctf_anna/ctf-challenge/public/dashboard.php?page=challenges">Challenges</a>
        </li>
        <li class="nav-item">
            <a href="/ctf_anna/ctf-challenge/public/dashboard.php?page=config">Configuration</a>
        </li>
    </ul>
</nav>
