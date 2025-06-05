<?php

require_once dirname(__DIR__) . '/app/core/database.php';
require_once dirname(__DIR__) . '/app/models/TeamModel.php';
require_once dirname(__DIR__) . '/app/controllers/TeamController.php';

$pdo = getPDO();
$controller = new \Anna\CtfChallenge\Controllers\TeamController($pdo);

if (isset($_GET['action'])) {
    if ($_GET['action'] === 'delete' && isset($_GET['id'])) {
        $controller->deleteTeam();
    } elseif ($_GET['action'] === 'add' && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $controller->addTeam();
    }
} else {
    $controller->index();
}