<?php
namespace Anna\CtfChallenge\Models;

class ConfigModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

        /**
     * Récupère tous les administrateurs.
     * @return array Liste des administrateurs sous forme de tableaux associatifs.
     */
    public function getAllAdmins(): array {
        $sql = "SELECT id_ctf_admin, ctf_username, ctf_password FROM ctf_admin";
        try {
            $stmt = $this->pdo->query($sql);
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            error_log("AdminModel::getAllAdmins - Erreur PDO: " . $e->getMessage());
            return [];
        }
    }

    public function addAdmin($username, $hashedPassword) {
        $sql = "INSERT INTO ctf_admin (ctf_username, ctf_password) VALUES (:username, :password)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'username' => $username,
            'password' => $hashedPassword
        ]);
    }

    public function deleteAdmin($adminId) {
        $sql = "DELETE FROM ctf_admin WHERE id_ctf_admin = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $adminId]);
    }


    /**
     * Récupère les heures de début et de fin du CTF.
     * @return array|false Les informations de temps du CTF sous forme de tableau associatif, ou false si non trouvé.
     */
    public function getCtfTime(): array|false {
        $sql = "SELECT ctf_start_time, ctf_end_time FROM ctf_config WHERE id_ctf_config = 1";
        try {
            $stmt = $this->pdo->query($sql);
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            error_log("ConfigModel::getCtfTime - Erreur PDO: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Met à jour les heures de début et de fin du CTF.
     * @param string $start Heure de début du CTF.
     * @param string $end Heure de fin du CTF.
     * @return bool True en cas de succès, false sinon.
     */
    public function updateCtfTime(string $start, string $end): bool {
        $sql = "UPDATE ctf_config SET ctf_start_time = :start, ctf_end_time = :end WHERE id_ctf_config = 1";
        try {
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([
                'start' => $start,
                'end' => $end
            ]);
        } catch (\PDOException $e) {
            error_log("ConfigModel::updateCtfTime - Erreur PDO: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Récupère le temps passé en prison.
     * @return string|false Le temps en prison, ou false si non trouvé.
     */
    public function getPrisonTime(): string|false {
        $sql = "SELECT ctf_prison_time FROM ctf_prison WHERE id_ctf_prison = 1";
        try {
            $stmt = $this->pdo->query($sql);
            return $stmt->fetchColumn();
        } catch (\PDOException $e) {
            error_log("ConfigModel::getPrisonTime - Erreur PDO: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Met à jour le temps passé en prison.
     * @param string $prisonTime Le nouveau temps en prison.
     * @return bool True en cas de succès, false sinon.
     */
    public function updatePrisonTime(string $prisonTime): bool {
        $sql = "UPDATE ctf_prison SET ctf_prison_time = :prison_time WHERE id_ctf_prison = 1";
        try {
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute(['prison_time' => $prisonTime]);
        } catch (\PDOException $e) {
            error_log("ConfigModel::updatePrisonTime - Erreur PDO: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Récupère le libellé du partenaire.
     * @return string|false Le libellé du partenaire, ou false si non trouvé.
     */
    public function getPartnerText(): string|false {
        $sql = "SELECT ctf_libelle_partenaire FROM ctf_partenaire WHERE id_ctf_partenaire = 1";
        try {
            $stmt = $this->pdo->query($sql);
            return $stmt->fetchColumn();
        } catch (\PDOException $e) {
            error_log("ConfigModel::getPartnerText - Erreur PDO: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Met à jour le libellé du partenaire.
     * @param string $libelle Le nouveau libellé du partenaire.
     * @return bool True en cas de succès, false sinon.
     */
    public function updatePartnerText(string $libelle): bool {
        $sql = "UPDATE ctf_partenaire SET ctf_libelle_partenaire = :libelle WHERE id_ctf_partenaire = 1";
        try {
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute(['libelle' => $libelle]);
        } catch (\PDOException $e) {
            error_log("ConfigModel::updatePartnerText - Erreur PDO: " . $e->getMessage());
            return false;
        }
    }
}