<?php
error_log("Début du script challenges.php");

require_once dirname(__DIR__) . '/app/core/database.php';
require_once dirname(__DIR__) . '/app/models/ChallengeModel.php';
require_once dirname(__DIR__) . '/app/controllers/ChallengeController.php';

error_log("Fichiers requis chargés");

$pdo = getPDO();
error_log("Connexion PDO établie");

$controller = new \App\Controllers\ChallengeController($pdo);
error_log("Controller instancié");

if (isset($_GET['action'])) {
    error_log("Action détectée : " . $_GET['action']);
    if ($_GET['action'] === 'delete' && isset($_GET['id'])) {
        $controller->deleteChallenge();
    } elseif ($_GET['action'] === 'add' && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $controller->addChallenge();
    } elseif ($_GET['action'] === 'edit' && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $controller->editChallenge();
    }
} else {
    error_log("Aucune action spécifiée, appel de index()");
    $controller->index();
} 