<?php
namespace Anna\CtfChallenge\Controllers;

use Anna\CtfChallenge\Models\TeamModel;
use Anna\CtfChallenge\Models\PartenaireModel;

class HomeController
{
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function index()
    {
        try {
            // Récupérer les données des équipes
            $teamModel = new TeamModel($this->pdo);
            $teams = $teamModel->getAllSortedByScore();
            $GLOBALS['teams'] = $teams;

            // Récupérer les données des partenaires
            $partenaireModel = new PartenaireModel($this->pdo);
            $partenaires = $partenaireModel->getAll();
            $GLOBALS['partenaires'] = $partenaires;
            
            // Charger la vue
            require_once __DIR__ . '/../views/scoreboard.php';
        } catch (\Exception $e) {
            error_log("Erreur dans HomeController : " . $e->getMessage());
            throw $e;
        }
    }

    public function submitting()
    {
        require_once __DIR__ . '/../views/submitting.php';
    }

    public function admin()
    {
        require_once __DIR__ . '/../views/loginAdmin.php';
    }
}
