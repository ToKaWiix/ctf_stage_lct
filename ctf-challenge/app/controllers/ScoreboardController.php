<?php
namespace App\Controllers;

require_once dirname(__DIR__) . '/models/ChallengeModel.php';
require_once dirname(__DIR__) . '/models/PlayerModel.php';

use App\Models\ChallengeModel;
use App\Models\PlayerModel;
use App\Models\TeamModel;

if (!class_exists('App\Controllers\ScoreboardController')) {
    class ScoreboardController {
        private $pdo;
        private $challengeModel;
        private $teamModel;

        public function __construct($pdo) {
            $this->pdo = $pdo;
            $this->challengeModel = new ChallengeModel($pdo);
            $this->teamModel = new TeamModel($pdo);
            error_log("ScoreboardController initialisé avec PDO");
        }

        public function index() {
            error_log("Début de la méthode index du ScoreboardController");
            
            try {
                // Récupérer les données avant de charger la vue
                $model = new TeamModel($this->pdo);
                $teams = $model->getAllSortedByScore();
                error_log("Données récupérées : " . print_r($teams, true));
                
                // Définir la variable globale
                $GLOBALS['teams'] = $teams;
                error_log("Variable globale teams définie : " . print_r($GLOBALS['teams'], true));
                
                // Charger la vue
                error_log("Chargement de la vue");
                require dirname(__DIR__) . '/views/scoreboard.php';
            } catch (\Exception $e) {
                error_log("Erreur dans ScoreboardController : " . $e->getMessage());
                throw $e;
            }
        }

        public function getChallengesForScoreboard() {
            // Démarrer la session si elle n'est pas déjà démarrée
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            // Initialiser la session si elle n'existe pas
            if (!isset($_SESSION['challenge_index'])) {
                $_SESSION['challenge_index'] = 0;
                $_SESSION['last_rotation'] = time();
            }

            // Vérifier si 5 secondes se sont écoulées depuis la dernière rotation
            $currentTime = time();
            if ($currentTime - $_SESSION['last_rotation'] >= 5) {
                // Incrémenter l'index de 5 pour passer au groupe suivant
                $_SESSION['challenge_index'] += 5;
                $_SESSION['last_rotation'] = $currentTime;
                
                // Log pour le débogage
                error_log("Rotation des challenges - Nouvel index: " . $_SESSION['challenge_index']);
                error_log("Temps actuel: " . $currentTime . ", Dernière rotation: " . $_SESSION['last_rotation']);
            }

            // Récupérer les challenges
            $challenges = $this->challengeModel->getChallengesForScoreboard($_SESSION['challenge_index'], 5);
            
            // Log pour le débogage
            error_log("Index actuel: " . $_SESSION['challenge_index']);
            error_log("Challenges récupérés: " . print_r($challenges, true));
            
            return $challenges;
        }

        public function hasTeamSolvedChallenge($teamId, $challengeId) {
            $stmt = $this->pdo->prepare("
                SELECT COUNT(*) 
                FROM ctf_score 
                WHERE id_ctf_equipe = :team_id AND id_ctf_challenge = :challenge_id
            ");
            $stmt->execute([
                'team_id' => $teamId,
                'challenge_id' => $challengeId
            ]);
            return $stmt->fetchColumn() > 0;
        }

        public function isChallengePointsVisible($challengeId) {
            $stmt = $this->pdo->prepare("
                SELECT ctf_show_pts 
                FROM ctf_challenge 
                WHERE id_ctf_challenge = :challenge_id
            ");
            $stmt->execute(['challenge_id' => $challengeId]);
            $result = $stmt->fetch();
            return $result && $result['ctf_show_pts'] == 1;
        }

        public function countSolvedChallenges($teamId) {
            $stmt = $this->pdo->prepare("
                SELECT COUNT(DISTINCT id_ctf_challenge) 
                FROM ctf_score 
                WHERE id_ctf_equipe = :team_id
            ");
            $stmt->execute(['team_id' => $teamId]);
            return $stmt->fetchColumn();
        }

        public function getPlayersForScoreboard() {
            $playerModel = new PlayerModel($this->pdo);
            $players = $playerModel->getAll();
            
            // Ne sélectionner que les joueurs qui ont une équipe
            $playersWithTeam = array_filter($players, function($player) {
                return !empty($player['id_ctf_equipe']) && !empty($player['ctf_nom_equipe']);
            });
            
            // Si aucun joueur n'a d'équipe, retourner un tableau vide
            if (empty($playersWithTeam)) {
                return [];
            }
            
            // Mélanger le tableau des joueurs
            shuffle($playersWithTeam);
            
            // Prendre les deux premiers joueurs du tableau mélangé
            $scoreboardPlayers = array_slice($playersWithTeam, 0, 2);
            
            return $scoreboardPlayers;
        }

        public function getPrisonPlayers() {
            $stmt = $this->pdo->prepare("
                SELECT j.*, e.ctf_nom_equipe, 
                       TIME_TO_SEC(COALESCE(p.ctf_prison_time, '00:12:00')) as prison_time_seconds,
                       CASE 
                           WHEN j.ctf_prison_start_time IS NOT NULL 
                           THEN TIMESTAMPDIFF(SECOND, j.ctf_prison_start_time, NOW())
                           ELSE 0 
                       END as time_spent,
                       j.ctf_prison_start_time as prison_start_time
                FROM ctf_joueur j
                LEFT JOIN ctf_equipe e ON j.id_ctf_equipe = e.id_ctf_equipe
                LEFT JOIN ctf_prison p ON p.id_ctf_prison = 1
                WHERE j.ctf_prison = 1
                ORDER BY j.ctf_prison_start_time ASC
                LIMIT 2
            ");
            $stmt->execute();
            $players = $stmt->fetchAll();
            
            // Log pour le débogage
            foreach ($players as $player) {
                error_log("Joueur en prison - ID: " . $player['id_ctf_joueur']);
                error_log("Temps passé (secondes): " . $player['time_spent']);
                error_log("Date d'entrée en prison: " . $player['prison_start_time']);
            }
            
            return $players;
        }

        public function releasePrisoner($playerId) {
            $stmt = $this->pdo->prepare("
                UPDATE ctf_joueur 
                SET ctf_prison = 0,
                    ctf_prison_start_time = NULL
                WHERE id_ctf_joueur = :player_id
            ");
            return $stmt->execute(['player_id' => $playerId]);
        }

        public function getTotalSolvedChallenges() {
            $stmt = $this->pdo->prepare("
                SELECT COUNT(*) 
                FROM ctf_score
            ");
            $stmt->execute();
            return $stmt->fetchColumn();
        }
    }
} 