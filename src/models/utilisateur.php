<?php
namespace Liberta_Mobile\Model;

use Liberta_Mobile\Config\Database;

class Utilisateur {
    private $db;

    public function __construct(Database $db) {
        $this->db = $db;
    }

    public function getUtilisateurByEmail($email) {
        $stmt = $this->db->getPdo()->prepare("SELECT * FROM utilisateur WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch() ?: null;
    }

    public function createUtilisateur($nom, $prenom, $email, $mot_de_passe) {
        $mot_de_passe_hash = password_hash($mot_de_passe, PASSWORD_BCRYPT);
        $stmt = $this->db->getPdo()->prepare("INSERT INTO utilisateur (nom, prenom, email, mot_de_passe) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$nom, $prenom, $email, $mot_de_passe_hash]);
    }

    public function updateUtilisateur($id, $nom, $prenom, $email) {
        $stmt = $this->db->getPdo()->prepare("UPDATE utilisateur SET nom = ?, prenom = ?, email = ? WHERE id = ?");
        return $stmt->execute([$nom, $prenom, $email, $id]);
    }
}
?>