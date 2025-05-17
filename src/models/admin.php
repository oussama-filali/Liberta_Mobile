<?php
class Admin {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAdmins() {
        $stmt = $this->db->getPdo()->query("SELECT * FROM admin");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAdminByEmail($email) {
        $stmt = $this->db->getPdo()->prepare("SELECT * FROM admin WHERE email = ? AND actif = 1");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>