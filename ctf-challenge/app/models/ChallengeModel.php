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
            ORDER BY ctf_pts DESC, ctf_nom_challenge ASC
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
        $stmt = $this->pdo->prepare("
            INSERT INTO ctf_challenge (ctf_nom_challenge, ctf_pts, ctf_flag, ctf_show_pts) 
            VALUES (:name, :points, :flag, :show_points)
        ");

        return $stmt->execute([
            'name' => $data['challenge_name'],
            'points' => $data['points'],
            'flag' => password_hash($data['flag'], PASSWORD_DEFAULT),
            'show_points' => isset($data['show_points']) && $data['show_points'] === 'oui' ? 1 : 0
        ]);
    }

    public function delete($id) {
        $stmt = $this->pdo->prepare("
            DELETE FROM ctf_challenge 
            WHERE id_ctf_challenge = :id
        ");
        return $stmt->execute(['id' => $id]);
    }
} 