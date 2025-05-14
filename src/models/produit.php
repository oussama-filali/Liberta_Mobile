<?php
// api/produits.php
require_once __DIR__ . '/../core/database.php';

class Produit {
    public static function getAll() {
        $pdo = Database::getConnection();
        $stmt = $pdo->query("SELECT * FROM produit");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

header('Content-Type: application/json');
echo json_encode(Produit::getAll());
