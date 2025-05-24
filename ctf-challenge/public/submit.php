<?php
require_once dirname(__DIR__) . '/vendor/autoload.php';

use Anna\CtfChallenge\Controllers\HomeController;

$controller = new HomeController();
$controller->submitting();