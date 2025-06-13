<?php
namespace App\Models;

class SubmitModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getChallengesForSubmit() {
        $stmt = $this->pdo->query("
            SELECT id_ctf_challenge, ctf_nom_challenge, ctf_pts 
            FROM ctf_challenge 
            ORDER BY ctf_pts ASC, ctf_nom_challenge ASC
        ");
        return $stmt->fetchAll();
    }

    public function verifyFlag($challengeId, $flag) {
        $stmt = $this->pdo->prepare("
            SELECT ctf_flag 
            FROM ctf_challenge 
            WHERE id_ctf_challenge = :id
        ");
        $stmt->execute(['id' => $challengeId]);
        $challenge = $stmt->fetch();

        if (!$challenge) {
            return false;
        }

        return password_verify($flag, $challenge['ctf_flag']);
    }

    public function getPlayerByPseudo($pseudo) {
        $stmt = $this->pdo->prepare("
            SELECT * FROM ctf_joueur 
            WHERE ctf_pseudo = :pseudo
        ");
        $stmt->execute(['pseudo' => $pseudo]);
        return $stmt->fetch();
    }

    public function recordSubmission($playerId, $challengeId, $isCorrect) {
        $stmt = $this->pdo->prepare("
            INSERT INTO ctf_soumission (ctf_etat_soumission, ctf_timestamp_soumission, id_ctf_joueur, id_ctf_challenge) 
            VALUES (:etat, NOW(), :player_id, :challenge_id)
        ");
        return $stmt->execute([
            'etat' => $isCorrect ? 1 : 0,
            'player_id' => $playerId,
            'challenge_id' => $challengeId
        ]);
    }

    public function recordScore($teamId, $challengeId) {
        // D'abord, vérifier si l'équipe a déjà résolu ce challenge
        $stmt = $this->pdo->prepare("
            SELECT COUNT(*) 
            FROM ctf_score 
            WHERE id_ctf_equipe = :team_id AND id_ctf_challenge = :challenge_id
        ");
        $stmt->execute([
            'team_id' => $teamId,
            'challenge_id' => $challengeId
        ]);
        
        if ($stmt->fetchColumn() > 0) {
            return false; // L'équipe a déjà résolu ce challenge
        }

        // Enregistrer le nouveau score
        $stmt = $this->pdo->prepare("
            INSERT INTO ctf_score (ctf_timestamp_scores, id_ctf_challenge, id_ctf_equipe) 
            VALUES (NOW(), :challenge_id, :team_id)
        ");
        return $stmt->execute([
            'challenge_id' => $challengeId,
            'team_id' => $teamId
        ]);
    }

    public function updateTeamScore($teamId, $challengeId) {
        // Récupérer les points du challenge
        $stmt = $this->pdo->prepare("
            SELECT ctf_pts 
            FROM ctf_challenge 
            WHERE id_ctf_challenge = :challenge_id
        ");
        $stmt->execute(['challenge_id' => $challengeId]);
        $challenge = $stmt->fetch();

        if (!$challenge) {
            return false;
        }

        // Mettre à jour le score de l'équipe
        $stmt = $this->pdo->prepare("
            UPDATE ctf_equipe 
            SET ctf_score_total = ctf_score_total + :points 
            WHERE id_ctf_equipe = :team_id
        ");
        return $stmt->execute([
            'points' => $challenge['ctf_pts'],
            'team_id' => $teamId
        ]);
    }
} 