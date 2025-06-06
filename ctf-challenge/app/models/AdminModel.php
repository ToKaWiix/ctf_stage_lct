<?php
namespace Anna\CtfChallenge\Models;

class AdminModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAdminByUsername($username) {
        $stmt = $this->pdo->prepare("SELECT * FROM ctf_admin WHERE ctf_username = :username");
        $stmt->execute(['username' => $username]);
        $result = $stmt->fetch();
        
        error_log("Recherche admin pour username: " . $username);
        error_log("Résultat: " . ($result ? "trouvé" : "non trouvé"));
        
        return $result;
    }

    public function verifyPassword($password, $admin) {
        error_log("Vérification du mot de passe...");
        
        if (!$admin || !isset($admin['ctf_password'])) {
            error_log("verifyPassword - Objet admin invalide ou hash de mot de passe manquant.");
            return false;
        }

        error_log("verifyPassword - Hash stocké: " . $admin['ctf_password']);
        error_log("verifyPassword - Mot de passe fourni: " . $password);
        
        $isValid = password_verify($password, $admin['ctf_password']);
        error_log("verifyPassword - Résultat de password_verify: " . ($isValid ? "vrai" : "faux"));
        
        return $isValid;
    }
} 