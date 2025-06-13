<?php
namespace App\Controllers;

class PointsController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function distributePoints() {
        try {
            // Récupérer tous les challenges résolus mais dont les points n'ont pas encore été attribués
            $stmt = $this->pdo->prepare("
                SELECT s.id_ctf_challenge, s.id_ctf_equipe, c.ctf_pts
                FROM ctf_score s
                JOIN ctf_challenge c ON s.id_ctf_challenge = c.id_ctf_challenge
                WHERE c.ctf_show_pts = 0
            ");
            $stmt->execute();
            $pendingScores = $stmt->fetchAll();

            // Pour chaque score en attente
            foreach ($pendingScores as $score) {
                // Mettre à jour le score total de l'équipe
                $updateStmt = $this->pdo->prepare("
                    UPDATE ctf_equipe 
                    SET ctf_score_total = ctf_score_total + :points 
                    WHERE id_ctf_equipe = :team_id
                ");
                $updateStmt->execute([
                    'points' => $score['ctf_pts'],
                    'team_id' => $score['id_ctf_equipe']
                ]);

                // Marquer le challenge comme ayant ses points visibles
                $updateChallengeStmt = $this->pdo->prepare("
                    UPDATE ctf_challenge 
                    SET ctf_show_pts = 1 
                    WHERE id_ctf_challenge = :challenge_id
                ");
                $updateChallengeStmt->execute([
                    'challenge_id' => $score['id_ctf_challenge']
                ]);
            }

            $_SESSION['success'] = "Les points ont été attribués avec succès.";
        } catch (\Exception $e) {
            $_SESSION['error'] = "Une erreur est survenue lors de l'attribution des points.";
            error_log("Erreur dans PointsController::distributePoints : " . $e->getMessage());
        }

        header('Location: /ctf_anna/ctf-challenge/public/dashboard.php?page=config');
        exit;
    }
} 