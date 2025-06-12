<?php
namespace Anna\CtfChallenge\Controllers;

require_once dirname(__DIR__) . '/models/ChallengeModel.php';
require_once dirname(__DIR__) . '/models/PlayerModel.php';

use Anna\CtfChallenge\Models\ChallengeModel;
use Anna\CtfChallenge\Models\PlayerModel;
use Anna\CtfChallenge\Models\TeamModel;

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
} 