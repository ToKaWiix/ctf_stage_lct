<?php
namespace Anna\CtfChallenge\Models;

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
        $allChallenges = $this->getAll();
        $totalChallenges = count($allChallenges);
        
        // Sélectionner les challenges à afficher
        $displayedChallenges = array_slice($allChallenges, $currentIndex, $challengesPerPage);
        
        // Si on n'a pas assez de challenges, on prend depuis le début
        if (count($displayedChallenges) < $challengesPerPage) {
            $remaining = $challengesPerPage - count($displayedChallenges);
            $displayedChallenges = array_merge($displayedChallenges, array_slice($allChallenges, 0, $remaining));
        }
        
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