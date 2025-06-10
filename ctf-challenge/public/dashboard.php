<?php
require_once dirname(__DIR__) . '/app/core/database.php';
require_once dirname(__DIR__) . '/app/core/auth.php';
require_once dirname(__DIR__) . '/app/controllers/AdminController.php';
require_once dirname(__DIR__) . '/app/controllers/ConfigController.php';

// Démarrer la session si ce n'est pas déjà fait
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Vérifier si l'utilisateur est connecté
requireLogin();

$pdo = getPDO();

$page = $_GET['page'] ?? 'homeAdmin';

if ($page === 'config') {
    $controller = new \Anna\CtfChallenge\Controllers\ConfigController($pdo);
} else {
    $controller = new \Anna\CtfChallenge\Controllers\AdminController($pdo);
}

$controller->route();