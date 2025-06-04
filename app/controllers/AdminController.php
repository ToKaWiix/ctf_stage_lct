<?php
namespace Anna\CtfChallenge\Controllers;

use Anna\CtfChallenge\Models\TeamModel;
// Ajoute ici les use pour les autres modèles si besoin (PlayerModel, ChallengeModel...)

class AdminController {
    public function route() {
        $page = $_GET['page'] ?? 'homeAdmin';

        switch ($page) {
            case 'teams':
                require_once dirname(__DIR__, 2) . '/app/core/database.php';
                $pdo = getPDO();
                $model = new TeamModel($pdo);
                $teams = $model->getAll();
                $view = dirname(__DIR__) . '/views/includes/admin/dashboard/teams.php';
                break;
            case 'players':
                // require_once dirname(__DIR__, 2) . '/app/core/database.php';
                // $pdo = getPDO();
                // $playerModel = new PlayerModel($pdo);
                // $players = $playerModel->getAll();
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
            case 'homeAdmin':
            default:
                $view = dirname(__DIR__) . '/views/includes/admin/dashboard/homeAdmin.php';
                break;
        }

        include dirname(__DIR__) . '/views/layouts/admin.php';
    }
} 