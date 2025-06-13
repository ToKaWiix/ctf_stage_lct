<?php
require_once dirname(__DIR__) . '/vendor/autoload.php';
require_once dirname(__DIR__) . '/app/core/database.php';
require_once dirname(__DIR__) . '/app/core/auth.php';
require_once dirname(__DIR__) . '/app/controllers/AdminController.php';
require_once dirname(__DIR__) . '/app/controllers/ConfigController.php';
require_once dirname(__DIR__) . '/app/controllers/PointsController.php';

use App\Controllers\AdminController;
use App\Controllers\PointsController;

// Démarrer la session si ce n'est pas déjà fait
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Vérifier si l'utilisateur est connecté
requireLogin();

$pdo = getPDO();

// Gérer l'action de distribution des points
if (isset($_GET['action']) && $_GET['action'] === 'distribute_points') {
    $pointsController = new PointsController($pdo);
    $pointsController->distributePoints();
    exit;
}

$page = $_GET['page'] ?? 'homeAdmin';

if ($page === 'config') {
    $controller = new \App\Controllers\ConfigController($pdo);
} else {
    $controller = new AdminController($pdo);
}

$controller->route();