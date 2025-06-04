<?php
namespace Anna\CtfChallenge\Controllers;

use Anna\CtfChallenge\Models\TeamModel;

class TeamController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function index() {
        $model = new TeamModel($this->pdo);
        $teams = $model->getAll();
        require dirname(__DIR__) . '/views/includes/admin/dashboard/teams.php';
    }
}