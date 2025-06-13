<?php
require_once dirname(__DIR__) . '/vendor/autoload.php';

use App\Controllers\HomeController;

$controller = new HomeController();
$controller->admin();