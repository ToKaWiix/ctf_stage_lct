<?php
namespace Anna\CtfChallenge\Controllers;

use Anna\CtfChallenge\Models\TeamModel;
use Anna\CtfChallenge\Models\PlayerModel;

class PlayerController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function index() {
        try {
            error_log("Début de PlayerController::index");
            
            $teamModel = new TeamModel($this->pdo);
            $playerModel = new PlayerModel($this->pdo);
            
            $teams = $teamModel->getAll();
            error_log("Équipes récupérées : " . print_r($teams, true));
            
            $players = $playerModel->getAll();
            error_log("Joueurs récupérés : " . print_r($players, true));
            
            if ($players === false) {
                $players = [];
            }

            // Stocker les données dans la session
            $_SESSION['players_data'] = [
                'teams' => $teams,
                'players' => $players
            ];
            
            error_log("Données stockées en session : " . print_r($_SESSION['players_data'], true));
            
        } catch (\Exception $e) {
            error_log("Erreur dans PlayerController::index : " . $e->getMessage());
            error_log("Trace : " . $e->getTraceAsString());
            header('Location: /ctf_anna/ctf-challenge/public/dashboard.php?page=players&error=' . urlencode("Une erreur est survenue lors du chargement des joueurs"));
            exit;
        }
    }

    public function addPlayer() {
        if (!isset($_POST['firstname']) || !isset($_POST['lastname']) || !isset($_POST['nickname']) || !isset($_POST['team'])) {
            header('Location: /ctf_anna/ctf-challenge/public/dashboard.php?page=players&error=Données manquantes');
            exit;
        }

        try {
            $playerModel = new PlayerModel($this->pdo);
            $playerModel->add($_POST);
            header('Location: /ctf_anna/ctf-challenge/public/dashboard.php?page=players&success=1');
        } catch (\Exception $e) {
            header('Location: /ctf_anna/ctf-challenge/public/dashboard.php?page=players&error=' . urlencode($e->getMessage()));
        }
        exit;
    }

    public function editPlayer() {
        if (!isset($_POST['player_id']) || !isset($_POST['firstname']) || !isset($_POST['lastname']) || !isset($_POST['nickname']) || !isset($_POST['team'])) {
            header('Location: /ctf_anna/ctf-challenge/public/dashboard.php?page=players&error=Données manquantes');
            exit;
        }

        try {
            $playerModel = new PlayerModel($this->pdo);
            $playerModel->update($_POST);
            header('Location: /ctf_anna/ctf-challenge/public/dashboard.php?page=players&success=3');
        } catch (\Exception $e) {
            header('Location: /ctf_anna/ctf-challenge/public/dashboard.php?page=players&error=' . urlencode($e->getMessage()));
        }
        exit;
    }

    public function deletePlayer() {
        if (!isset($_GET['id'])) {
            header('Location: /ctf_anna/ctf-challenge/public/dashboard.php?page=players&error=ID du joueur manquant');
            exit;
        }

        try {
            $playerModel = new PlayerModel($this->pdo);
            $playerModel->delete($_GET['id']);
            header('Location: /ctf_anna/ctf-challenge/public/dashboard.php?page=players&success=2');
        } catch (\Exception $e) {
            header('Location: /ctf_anna/ctf-challenge/public/dashboard.php?page=players&error=' . urlencode($e->getMessage()));
        }
        exit;
    }
} 