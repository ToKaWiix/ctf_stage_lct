<?php
namespace App\Models;

class ChallengeModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAll() {
        $stmt = $this->pdo->query("
            SELECT * FROM ctf_challenge 
            ORDER BY ctf_nom_challenge ASC
        ");
        return $stmt->fetchAll();
    }

    public function getChallengesForScoreboard($currentIndex = 0, $challengesPerPage = 5) {
        // Récupérer tous les challenges
        $allChallenges = $this->getAll();
        $totalChallenges = count($allChallenges);

        if ($totalChallenges === 0) {
            return [];
        }

        // Log pour le débogage
        error_log("Nombre total de challenges: " . $totalChallenges);
        error_log("Index reçu: " . $currentIndex);

        // Calculer le groupe actuel (chaque groupe contient 5 challenges)
        $groupIndex = floor($currentIndex / $challengesPerPage);
        $startIndex = $groupIndex * $challengesPerPage;

        // Sélectionner les challenges à afficher
        $displayedChallenges = [];
        
        // Prendre les 5 challenges suivants
        for ($i = 0; $i < $challengesPerPage; $i++) {
            $index = ($startIndex + $i) % $totalChallenges;
            if (isset($allChallenges[$index])) {
                $displayedChallenges[] = $allChallenges[$index];
            }
        }

        // Log pour le débogage
        error_log("Index de début: " . $startIndex);
        error_log("Nombre de challenges affichés: " . count($displayedChallenges));

        return $displayedChallenges;
    }

    public function add($data) {
        error_log("ChallengeModel::add - Données reçues : " . print_r($data, true));

        // Validation des données
        if (!isset($data['challenge_name']) || !isset($data['points']) || !isset($data['flag'])) {
            error_log("ChallengeModel::add - Données manquantes");
            throw new \Exception("Données manquantes");
        }

        // Validation des points
        $points = intval($data['points']);
        if ($points < 0) {
            error_log("ChallengeModel::add - Points négatifs non autorisés");
            throw new \Exception("Les points ne peuvent pas être négatifs");
        }

        // Validation du flag
        if (empty($data['flag'])) {
            error_log("ChallengeModel::add - Flag vide");
            throw new \Exception("Le flag ne peut pas être vide");
        }

        // Préparation de la requête
        $stmt = $this->pdo->prepare("
            INSERT INTO ctf_challenge (ctf_nom_challenge, ctf_pts, ctf_flag, ctf_show_pts) 
            VALUES (:name, :points, :flag, :show_points)
        ");

        // Exécution de la requête
        $result = $stmt->execute([
            'name' => $data['challenge_name'],
            'points' => $points,
            'flag' => password_hash($data['flag'], PASSWORD_DEFAULT),
            'show_points' => isset($data['show_points']) && $data['show_points'] === 'oui' ? 1 : 0
        ]);

        if (!$result) {
            error_log("ChallengeModel::add - Erreur lors de l'insertion : " . print_r($stmt->errorInfo(), true));
            throw new \Exception("Erreur lors de l'ajout du challenge");
        }

        error_log("ChallengeModel::add - Challenge ajouté avec succès");
        return true;
    }

    public function delete($id) {
        try {
            $this->pdo->beginTransaction();
            error_log("ChallengeModel::delete - Début de la transaction pour challenge ID: " . $id);

            // Supprimer les scores liés à ce challenge
            $stmtScores = $this->pdo->prepare("DELETE FROM ctf_score WHERE id_ctf_challenge = :id");
            $stmtScores->execute(['id' => $id]);
            error_log("ChallengeModel::delete - Scores liés au challenge " . $id . " supprimés. Nombre de lignes affectées: " . $stmtScores->rowCount());

            // Supprimer les soumissions liées à ce challenge
            $stmtSubmissions = $this->pdo->prepare("DELETE FROM ctf_soumission WHERE id_ctf_challenge = :id");
            $stmtSubmissions->execute(['id' => $id]);
            error_log("ChallengeModel::delete - Soumissions liées au challenge " . $id . " supprimées. Nombre de lignes affectées: " . $stmtSubmissions->rowCount());

            // Supprimer le challenge
            $stmtChallenge = $this->pdo->prepare("DELETE FROM ctf_challenge WHERE id_ctf_challenge = :id");
            $stmtChallenge->execute(['id' => $id]);
            error_log("ChallengeModel::delete - Challenge " . $id . " supprimé. Nombre de lignes affectées: " . $stmtChallenge->rowCount());

            $this->pdo->commit();
            error_log("ChallengeModel::delete - Transaction terminée avec succès pour challenge ID: " . $id);
            return true;
        } catch (\PDOException $e) {
            $this->pdo->rollBack();
            error_log("ChallengeModel::delete - Erreur PDO : " . $e->getMessage());
            error_log("ChallengeModel::delete - Trace PDO : " . $e->getTraceAsString());
            throw new \Exception("Erreur PDO lors de la suppression du challenge : " . $e->getMessage());
        } catch (\Exception $e) {
            $this->pdo->rollBack();
            error_log("ChallengeModel::delete - Erreur générale : " . $e->getMessage());
            error_log("ChallengeModel::delete - Trace générale : " . $e->getTraceAsString());
            throw new \Exception("Erreur lors de la suppression du challenge : " . $e->getMessage());
        }
    }
} 