<?php
namespace Anna\CtfChallenge\Controllers;

class HomeController
{
    public function index()
    {
        require_once __DIR__ . '/../views/scoreboard.php';
    }

    public function submitting()
    {
        require_once __DIR__ . '/../views/submitting.php';
    }
}
