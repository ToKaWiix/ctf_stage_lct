<?php
error_log("Début du script players.php");

require_once dirname(__DIR__) . '/app/core/database.php';
require_once dirname(__DIR__) . '/app/models/TeamModel.php';
require_once dirname(__DIR__) . '/app/models/PlayerModel.php';
require_once dirname(__DIR__) . '/app/controllers/PlayerController.php';

error_log("Fichiers requis chargés");

$pdo = getPDO();
error_log("Connexion PDO établie");

$controller = new \Anna\CtfChallenge\Controllers\PlayerController($pdo);
error_log("Controller instancié");

if (isset($_GET['action'])) {
    error_log("Action détectée : " . $_GET['action']);
    if ($_GET['action'] === 'delete' && isset($_GET['id'])) {
        $controller->deletePlayer();
    } elseif ($_GET['action'] === 'add' && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $controller->addPlayer();
    } elseif ($_GET['action'] === 'edit' && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $controller->editPlayer();
    }
} else {
    error_log("Aucune action spécifiée, appel de index()");
    $controller->index();
} 