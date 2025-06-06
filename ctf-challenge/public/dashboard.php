<?php
require_once dirname(__DIR__) . '/app/core/database.php';
require_once dirname(__DIR__) . '/app/core/auth.php';
require_once dirname(__DIR__) . '/app/controllers/AdminController.php';

// Démarrer la session si ce n'est pas déjà fait
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Vérifier si l'utilisateur est connecté
requireLogin();

// Initialiser le contrôleur
$pdo = getPDO();
$controller = new \Anna\CtfChallenge\Controllers\AdminController($pdo);

// Router vers la bonne page
$controller->route();