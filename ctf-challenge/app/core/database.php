<?php

function getPDO() {
    static $pdo = null;
    if ($pdo === null) {
        $host = 'localhost';
        $db   = 'ctf_challenge_stage_anna';
        $user = 'anna';
        $pass = 'anna';
        $charset = 'utf8mb4';

        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        $pdo = new PDO($dsn, $user, $pass, $options);
    }
    return $pdo;
}