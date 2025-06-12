<?php
namespace Anna\CtfChallenge\Controllers;

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
} 