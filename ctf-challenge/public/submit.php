<?php
require_once dirname(__DIR__) . '/vendor/autoload.php';
require_once dirname(__DIR__) . '/app/core/config.php';
require_once dirname(__DIR__) . '/app/core/database.php';

use App\Controllers\SubmitController;

session_start();
$pdo = getPDO();
$controller = new SubmitController($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller->submit();
} else {
    $controller->index();
}