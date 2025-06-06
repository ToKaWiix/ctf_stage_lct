<?php

// Démarrer la session si ce n'est pas déjà fait
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function isLoggedIn() {
    error_log("isLoggedIn - Vérification de la session");
    error_log("isLoggedIn - Session: " . print_r($_SESSION, true));
    
    if (!isset($_SESSION['admin_id']) || empty($_SESSION['admin_id'])) {
        error_log("isLoggedIn - Pas d'admin_id dans la session");
        return false;
    }
    
    if (!isset($_SESSION['admin_username']) || empty($_SESSION['admin_username'])) {
        error_log("isLoggedIn - Pas d'admin_username dans la session");
        return false;
    }
    
    error_log("isLoggedIn - Session valide pour admin: " . $_SESSION['admin_username']);
    return true;
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