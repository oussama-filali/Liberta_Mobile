<?php

class Database {
    private static $pdo;

    public static function getConnection() {
        if (!self::$pdo) {
            try {
                self::$pdo = new PDO('mysql:host=localhost;dbname=liberta_mobile', 'root', '');
                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Erreur de connexion : " . $e->getMessage());
            }
        }
        return self::$pdo;
    }
}
