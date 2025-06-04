<?php
namespace Anna\CtfChallenge\Controllers;

use Anna\CtfChallenge\Controllers\TeamController;
use Anna\CtfChallenge\Models\TeamModel;

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
            // ... autres cas ...
            default:
                $view = dirname(__DIR__) . '/views/includes/admin/dashboard/homeAdmin.php';
                break;
        }

        include dirname(__DIR__) . '/views/layouts/admin.php';
    }
}