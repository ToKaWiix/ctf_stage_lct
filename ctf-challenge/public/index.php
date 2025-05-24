<?php
require_once dirname(__DIR__) . '/vendor/autoload.php';

use Anna\CtfChallenge\Core\App;

$app = new App();
$app->run();
