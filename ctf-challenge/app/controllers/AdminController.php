<?php
namespace Anna\CtfChallenge\Controllers;

use Anna\CtfChallenge\Models\TeamModel;
use Anna\CtfChallenge\Models\PlayerModel;
// Ajoute ici les use pour les autres modèles si besoin (PlayerModel, ChallengeModel...)

class AdminController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function route() {
        // Vérifier si l'utilisateur est connecté
        requireLogin();

        $page = $_GET['page'] ?? 'homeAdmin';

        switch ($page) {
            case 'homeAdmin':
                default:
                    $view = dirname(__DIR__) . '/views/includes/admin/dashboard/homeAdmin.php';
                    break;
            case 'teams':
                // Vérifier si c'est une action de suppression ou d'ajout
                if (isset($_GET['action'])) {
                    $controller = new TeamController($this->pdo);
                    if ($_GET['action'] === 'delete' && isset($_GET['id'])) {
                        $controller->deleteTeam();
                        return;
                    } elseif ($_GET['action'] === 'add' && $_SERVER['REQUEST_METHOD'] === 'POST') {
                        $controller->addTeam();
                        return;
                    }
                }
                
                $model = new TeamModel($this->pdo);
                $teams = $model->getAll();
                $view = dirname(__DIR__) . '/views/includes/admin/dashboard/teams.php';
                break;
            case 'players':
                // Vérifier si c'est une action de suppression, d'ajout ou de modification
                if (isset($_GET['action'])) {
                    $controller = new PlayerController($this->pdo);
                    if ($_GET['action'] === 'delete' && isset($_GET['id'])) {
                        $controller->deletePlayer();
                        return;
                    } elseif ($_GET['action'] === 'add' && $_SERVER['REQUEST_METHOD'] === 'POST') {
                        $controller->addPlayer();
                        return;
                    } elseif ($_GET['action'] === 'edit' && $_SERVER['REQUEST_METHOD'] === 'POST') {
                        $controller->editPlayer();
                        return;
                    }
                }
                
                $controller = new PlayerController($this->pdo);
                $controller->index();
                $view = dirname(__DIR__) . '/views/includes/admin/dashboard/players.php';
                break;
            case 'challenges':
                // require_once dirname(__DIR__, 2) . '/app/core/database.php';
                // $pdo = getPDO();
                // $challengeModel = new ChallengeModel($pdo);
                // $challenges = $challengeModel->getAll();
                $view = dirname(__DIR__) . '/views/includes/admin/dashboard/challenges.php';
                break;
            case 'config':
                $view = dirname(__DIR__) . '/views/includes/admin/dashboard/config.php';
                break;
        }

        include dirname(__DIR__) . '/views/layouts/admin.php';
    }
}
