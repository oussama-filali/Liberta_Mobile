<?php
require_once __DIR__ . '/../core/database.php';

class Admin {
    public static function findByEmail($email) {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT * FROM admin WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
class utilisateur {
    public static function findByEmail($email) {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT * FROM utilisateur WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}