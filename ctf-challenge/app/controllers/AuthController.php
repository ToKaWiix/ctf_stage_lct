<?php
namespace App\Controllers;

use App\Models\AdminModel;

class AuthController {
    private $pdo;
    private $adminModel;

    public function __construct($pdo) {
        $this->pdo = $pdo;
        $this->adminModel = new AdminModel($pdo);
    }

    public function login($username, $password) {
        error_log("AuthController::login - START");
        error_log("Attempting login for username: '" . $username . "'");
        // Note: We do NOT log the actual password for security reasons.

        // 1. Récupérer l'administrateur par nom d'utilisateur
        error_log("AuthController::login - Calling getAdminByUsername for: '" . $username . "'");
        $admin = $this->adminModel->getAdminByUsername($username);

        // 2. Si l'administrateur n'existe pas, la connexion échoue
        if (!$admin) {
            error_log("AuthController::login - Admin NOT found for username: '" . $username . "'");
            return false;
        }
        error_log("AuthController::login - Admin found. Details: " . print_r($admin, true));

        // 3. Vérifier le mot de passe fourni avec le hash stocké
        error_log("AuthController::login - Calling verifyPassword...");
        $passwordValid = $this->adminModel->verifyPassword($password, $admin);

        // 4. Gérer le résultat de la vérification du mot de passe
        if ($passwordValid) {
            error_log("AuthController::login - password_verify returned TRUE.");
            // Mot de passe correct : démarrer ou reprendre la session et stocker les infos admin
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
                error_log("AuthController::login - Session started.");
            }
            // Nettoyer toute session précédente et en démarrer une nouvelle pour la sécurité
            session_unset();
            session_destroy();
            session_start(); // Redémarrer la session après destruction
            error_log("AuthController::login - Session reset and started again.");

            $_SESSION['admin_id'] = $admin['id_ctf_admin'];
            $_SESSION['admin_username'] = $admin['ctf_username'];
            error_log("AuthController::login - Admin info stored in session. admin_id: " . $_SESSION['admin_id'] . ", admin_username: " . $_SESSION['admin_username'] . ". Session ID: " . session_id());
            
            error_log("AuthController::login - END (Returning TRUE)");
            return true; // Connexion réussie
        } else {
            // Mot de passe incorrect : la connexion échoue
            error_log("AuthController::login - password_verify returned FALSE. Password incorrect.");
            error_log("AuthController::login - END (Returning FALSE)");
            return false; // Mot de passe incorrect
        }
    }

    public function logout() {
        // Démarrer la session si ce n'est pas déjà fait
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // Nettoyer et détruire la session
        session_unset();
        session_destroy();
        
        // Rediriger vers la page de connexion
        header('Location: ' . BASE_URL . '/loginAdmin.php');
        exit;
    }
} 