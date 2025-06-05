<?php
namespace Anna\CtfChallenge\Models;

class PlayerModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAll() {
        $stmt = $this->pdo->query("
            SELECT j.*, e.ctf_nom_equipe 
            FROM ctf_joueur j 
            LEFT JOIN ctf_equipe e ON j.id_ctf_equipe = e.id_ctf_equipe
            ORDER BY e.ctf_nom_equipe, j.ctf_nom
        ");
        return $stmt->fetchAll();
    }

    public function add($data) {
        // Gestion de l'upload de photo
        if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = dirname(dirname(__DIR__)) . '/public/images/';
            $fileExtension = strtolower(pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION));
            $newFileName = uniqid() . '.' . $fileExtension;
            $uploadFile = $uploadDir . $newFileName;

            if (move_uploaded_file($_FILES['photo']['tmp_name'], $uploadFile)) {
                $photoName = $newFileName;
            } else {
                throw new \Exception("Erreur lors de l'upload de la photo");
            }
        } else {
            throw new \Exception("Erreur lors de l'upload de la photo");
        }

        $stmt = $this->pdo->prepare("
            INSERT INTO ctf_joueur (ctf_nom, ctf_prenom, ctf_pseudo, ctf_photo, ctf_prison, id_ctf_equipe) 
            VALUES (:nom, :prenom, :pseudo, :photo, :prison, :equipe)
        ");

        return $stmt->execute([
            'nom' => $data['lastname'],
            'prenom' => $data['firstname'],
            'pseudo' => $data['nickname'],
            'photo' => $photoName,
            'prison' => 0,
            'equipe' => $data['team']
        ]);
    }

    public function update($data) {
        $stmt = $this->pdo->prepare("
            UPDATE ctf_joueur 
            SET ctf_nom = :nom,
                ctf_prenom = :prenom,
                ctf_pseudo = :pseudo,
                id_ctf_equipe = :equipe
            WHERE id_ctf_joueur = :id
        ");

        return $stmt->execute([
            'id' => $data['player_id'],
            'nom' => $data['lastname'],
            'prenom' => $data['firstname'],
            'pseudo' => $data['nickname'],
            'equipe' => $data['team']
        ]);
    }

    public function delete($id) {
        // Récupérer le nom de la photo avant de supprimer le joueur
        $stmt = $this->pdo->prepare("SELECT ctf_photo FROM ctf_joueur WHERE id_ctf_joueur = :id");
        $stmt->execute(['id' => $id]);
        $photo = $stmt->fetchColumn();

        // Supprimer le joueur
        $stmt = $this->pdo->prepare("DELETE FROM ctf_joueur WHERE id_ctf_joueur = :id");
        $result = $stmt->execute(['id' => $id]);

        // Si la suppression a réussi et qu'il y a une photo, la supprimer
        if ($result && $photo) {
            $photoPath = dirname(dirname(__DIR__)) . '/public/images/' . $photo;
            if (file_exists($photoPath)) {
                unlink($photoPath);
            }
        }

        return $result;
    }
} 