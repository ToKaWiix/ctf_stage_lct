<?php
namespace App\Models;

class AdminModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Récupère les informations d'un administrateur par son nom d'utilisateur.
     * @param string $username Le nom d'utilisateur.
     * @return array|false Les informations de l'administrateur sous forme de tableau associatif, ou false si non trouvé.
     */
    public function getAdminByUsername(string $username): array|false {
        // Utilise BINARY pour une comparaison de username sensible à la casse si nécessaire, sinon retire-le.
        // En général, il est préférable que les usernames ne soient PAS sensibles à la casse.
        // Retirons BINARY pour l'instant, si vous avez besoin de sensibilité à la casse, nous le remettrons.
        $sql = "SELECT id_ctf_admin, ctf_username, ctf_password FROM ctf_admin WHERE ctf_username = :username LIMIT 1";
        
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(['username' => $username]);
            $admin = $stmt->fetch(\PDO::FETCH_ASSOC);
            
            // Log pour débogage
            error_log("AdminModel::getAdminByUsername - Recherche pour: '" . $username . "', Résultat: " . ($admin ? "Trouvé" : "Non trouvé"));
            if ($admin) {
                error_log("AdminModel::getAdminByUsername - Données admin: " . print_r($admin, true));
            }

            return $admin; // Retourne le tableau associatif ou false
        } catch (\PDOException $e) {
            error_log("AdminModel::getAdminByUsername - Erreur PDO: " . $e->getMessage());
            return false; // En cas d'erreur de base de données
        }
    }

    /**
     * Vérifie si le mot de passe fourni correspond au hash stocké dans la base de données.
     * @param string $password Le mot de passe en clair fourni par l'utilisateur.
     * @param array $admin Le tableau associatif contenant les informations de l'administrateur (doit inclure 'ctf_password').
     * @return bool True si le mot de passe est correct, false sinon.
     */
    public function verifyPassword(string $password, array $admin): bool {
        // Vérification de base: s'assurer que l'objet admin est valide et contient le hash du mot de passe
        if (!isset($admin['ctf_password'])) {
            error_log("AdminModel::verifyPassword - Hash de mot de passe manquant dans les données admin.");
            return false;
        }

        $storedHash = $admin['ctf_password'];

        // Log pour débogage
        error_log("AdminModel::verifyPassword - Vérification du mot de passe...");
        error_log("AdminModel::verifyPassword - Hash stocké: '" . $storedHash . "'");
        // Ne pas logger le mot de passe en clair !

        // Utilise password_verify pour comparer le mot de passe fourni avec le hash
        $isValid = password_verify($password, $storedHash);

        // Log pour débogage
        error_log("AdminModel::verifyPassword - Résultat de password_verify: " . ($isValid ? "Vrai" : "Faux"));

        return $isValid;
    }
} 