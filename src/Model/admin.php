<?php
// src/Model/Admin.php

namespace Liberta_Mobile\Model;

use Liberta_Mobile\Config\Database;

class Admin {
    private $db;

    public function __construct(Database $db) {
        $this->db = $db;
    }

    public function getAdminByEmail($email) {
        $stmt = $this->db->getPdo()->prepare("SELECT * FROM admin WHERE email = ? AND actif = 1");
        $stmt->execute([$email]);
        return $stmt->fetch();
    }
}
