<?php

require_once dirname(__DIR__) . '/app/controllers/TeamController.php';

$controller = new TeamController();
$controller->index();