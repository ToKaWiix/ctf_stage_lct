<?php

// Démarrer la session si ce n'est pas déjà fait
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function isLoggedIn() {
    return isset($_SESSION['admin_id']) && !empty($_SESSION['admin_id']);
}

function requireLogin() {
    if (!isLoggedIn()) {
        // Nettoyer la session
        session_unset();
        session_destroy();
        
        // Rediriger vers la page de connexion
        header('Location: /ctf_anna/ctf-challenge/public/loginAdmin.php');
        exit;
    }
}

function getCurrentAdminId() {
    return $_SESSION['admin_id'] ?? null;
}

function getCurrentAdminUsername() {
    return $_SESSION['admin_username'] ?? null;
}

function setAdminSession($admin) {
    if (!isset($admin['id_ctf_admin']) || !isset($admin['ctf_username'])) {
        throw new \Exception('Données admin invalides');
    }

    // Nettoyer toute session existante
    session_unset();
    session_destroy();
    session_start();

    // Stocker les informations de l'admin dans la session
    $_SESSION['admin_id'] = $admin['id_ctf_admin'];
    $_SESSION['admin_username'] = $admin['ctf_username'];
} 