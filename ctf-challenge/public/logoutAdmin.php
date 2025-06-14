<?php
require_once dirname(__DIR__) . '/app/core/config.php';
require_once dirname(__DIR__) . '/app/core/auth.php';

// Démarrer la session si ce n'est pas déjà fait
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Détruire la session
session_destroy();

// Rediriger vers la page de connexion
header('Location: ' . BASE_URL . '/loginAdmin.php');
exit; 