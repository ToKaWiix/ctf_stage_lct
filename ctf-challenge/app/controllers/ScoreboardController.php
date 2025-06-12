<?php
namespace Anna\CtfChallenge\Controllers;

use Anna\CtfChallenge\Models\PlayerModel;
use Anna\CtfChallenge\Models\TeamModel;

class ScoreboardController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
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