<?php
namespace Anna\CtfChallenge\Models;

class PartenaireModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAll() {
        $stmt = $this->pdo->query("
            SELECT id_ctf_partenaire, ctf_libelle_partenaire
            FROM ctf_partenaire 
        ");
        return $stmt->fetchAll();
    }
} 