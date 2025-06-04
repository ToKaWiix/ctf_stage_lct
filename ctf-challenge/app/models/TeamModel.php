<?php
namespace Anna\CtfChallenge\Models;

class TeamModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAll() {
        $stmt = $this->pdo->query("SELECT * FROM ctf_equipe");
        return $stmt->fetchAll();
    }
}