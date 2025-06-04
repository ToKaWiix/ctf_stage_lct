<?php
require_once dirname(__DIR__) . '/vendor/autoload.php';

use Anna\CtfChallenge\Controllers\AdminController;

$controller = new AdminController();
$controller->route();