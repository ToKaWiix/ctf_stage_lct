<?php
namespace Anna\CtfChallenge\Controllers;

use Anna\CtfChallenge\Models\AdminModel;

class AuthController {
    private $pdo;
    private $adminModel;

    public function __construct($pdo) {
        $this->pdo = $pdo;
        $this->adminModel = new AdminModel($pdo);
    }

    public function login($username, $password) {
        error_log("AuthController login - Tentative de connexion pour: " . $username);

        if (empty($username) || empty($password)) {
            error_log("AuthController login - Champs vides, retour false.");
            return false;
        }

        // Vérifier d'abord si l'admin existe
        $admin = $this->adminModel->getAdminByUsername($username);
        if (!$admin) {
            error_log("AuthController login - Admin non trouvé pour: " . $username . ", retour false.");
            return false;
        }

        // Si l'admin existe, vérifier le mot de passe en lui passant l'objet admin
        error_log("AuthController login - Admin trouvé, vérification du mot de passe...");
        if ($this->adminModel->verifyPassword($password, $admin)) {
            error_log("AuthController login - Mot de passe vérifié avec succès.");
            // Démarrer la session si ce n'est pas déjà fait
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            // Nettoyer toute session existante
            session_unset();
            session_destroy();
            session_start();

            // Stocker les informations de l'admin dans la session
            $_SESSION['admin_id'] = $admin['id_ctf_admin'];
            $_SESSION['admin_username'] = $admin['ctf_username'];
            
            error_log("AuthController login - Session admin créée pour: " . $username . ", retour true.");
            return true;
        }

        error_log("AuthController login - Mot de passe incorrect, retour false.");
        return false;
    }

    public function logout() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // Nettoyer la session
        session_unset();
        session_destroy();
        
        // Rediriger vers la page de connexion
        header('Location: /ctf_anna/ctf-challenge/public/loginAdmin.php');
        exit;
    }
} 