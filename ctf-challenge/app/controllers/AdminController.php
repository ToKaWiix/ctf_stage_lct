<?php
namespace Anna\CtfChallenge\Controllers;

require_once dirname(__DIR__) . '/models/TeamModel.php';
require_once dirname(__DIR__) . '/models/PlayerModel.php';
require_once dirname(__DIR__) . '/controllers/TeamController.php';
require_once dirname(__DIR__) . '/controllers/PlayerController.php';
require_once dirname(__DIR__) . '/controllers/ChallengeController.php';

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
                    $teamModel = new TeamModel($this->pdo);
                    $teams = $teamModel->getAllSortedByScore();
                    $teamCount = $teamModel->getTeamCount();
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
                // Vérifier si c'est une action de suppression, d'ajout ou de modification
                if (isset($_GET['action'])) {
                    $controller = new ChallengeController($this->pdo);
                    if ($_GET['action'] === 'delete' && isset($_GET['id'])) {
                        $controller->deleteChallenge();
                        return;
                    } elseif ($_GET['action'] === 'add' && $_SERVER['REQUEST_METHOD'] === 'POST') {
                        $controller->addChallenge();
                        return;
                    } elseif ($_GET['action'] === 'edit' && $_SERVER['REQUEST_METHOD'] === 'POST') {
                        $controller->editChallenge();
                        return;
                    }
                }
                
                $controller = new ChallengeController($this->pdo);
                $controller->index();
                $view = dirname(__DIR__) . '/views/includes/admin/dashboard/challenges.php';
                break;
            case 'config':
                if (isset($_GET['action']) && $_GET['action'] === 'delete' && $_SERVER['REQUEST_METHOD'] === 'POST') {
                    $this->deleteAdmin();
                    return;
                }
                if (isset($_GET['action']) && $_GET['action'] === 'add' && $_SERVER['REQUEST_METHOD'] === 'POST') {
                    // Appeler la méthode d'ajout d'admin
                    $this->addAdmin();
                    return;
                }
                require_once dirname(__DIR__) . '/models/AdminModel.php';
                $adminModel = new \Anna\CtfChallenge\Models\AdminModel($this->pdo);
                $admins = $adminModel->getAllAdmins();
                $view = dirname(__DIR__) . '/views/includes/admin/dashboard/config.php';
                break;
        }

        include dirname(__DIR__) . '/views/layouts/admin.php';
    }

    public function home() {
        $teamModel = new \Anna\CtfChallenge\Models\TeamModel($this->pdo);
        $teams = $teamModel->getAllSortedByScore();
        $teamCount = $teamModel->getTeamCount();
        require dirname(__DIR__) . '/views/includes/admin/dashboard/homeAdmin.php';
    }

    public function addAdmin() {
        require_once dirname(__DIR__) . '/models/AdminModel.php';
        $adminModel = new \Anna\CtfChallenge\Models\AdminModel($this->pdo);

        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        if (empty($username) || empty($password)) {
            header('Location: /ctf_anna/ctf-challenge/public/dashboard.php?page=config&error=Champs manquants');
            exit;
        }

        // Hash du mot de passe
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Ajout dans la BDD
        $adminModel->addAdmin($username, $hashedPassword);

        header('Location: /ctf_anna/ctf-challenge/public/dashboard.php?page=config&success=1');
        exit;
    }

    public function deleteAdmin() {
        require_once dirname(__DIR__) . '/models/AdminModel.php';
        $adminModel = new \Anna\CtfChallenge\Models\AdminModel($this->pdo);

        $adminId = $_POST['admin_id'] ?? null;
        if (!$adminId) {
            header('Location: /ctf_anna/ctf-challenge/public/dashboard.php?page=config&error=ID manquant');
            exit;
        }

        $adminModel->deleteAdmin($adminId);
        header('Location: /ctf_anna/ctf-challenge/public/dashboard.php?page=config&success=2');
        exit;
    }
}
