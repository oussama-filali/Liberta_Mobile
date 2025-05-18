<?php
// src/models/Produit.php

namespace Liberta_Mobile\Model;

use Liberta_Mobile\Config\Database;

class Produit {
    private $db;

    public function __construct(Database $db) {
        $this->db = $db;
    }

    public function getProduitsPhare() {
        $stmt = $this->db->getPdo()->query("
            SELECT p.*, m.nom AS marque, mo.nom AS modele 
            FROM produit p
            LEFT JOIN marque m ON p.marque_id = m.id
            LEFT JOIN modele mo ON p.modele_id = mo.id
            ORDER BY p.id DESC LIMIT 4
        ");
        return $stmt->fetchAll();
    }

    public function getProduit($id) {
        $stmt = $this->db->getPdo()->prepare("
            SELECT p.*, m.nom AS marque, mo.nom AS modele 
            FROM produit p
            LEFT JOIN marque m ON p.marque_id = m.id
            LEFT JOIN modele mo ON p.modele_id = mo.id
            WHERE p.id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function getProduits($filters = []) {
        $sql = "SELECT p.*, m.nom AS marque, mo.nom AS modele FROM produit p
                LEFT JOIN marque m ON p.marque_id = m.id
                LEFT JOIN modele mo ON p.modele_id = mo.id
                WHERE 1=1";
        $params = [];

        if (!empty($filters['type'])) {
            $sql .= " AND p.type = ?";
            $params[] = $filters['type'];
        }

        if (!empty($filters['marque_id'])) {
            $sql .= " AND p.marque_id = ?";
            $params[] = $filters['marque_id'];
        }

        if (!empty($filters['prix_min'])) {
            $sql .= " AND p.prix >= ?";
            $params[] = $filters['prix_min'];
        }

        if (!empty($filters['prix_max'])) {
            $sql .= " AND p.prix <= ?";
            $params[] = $filters['prix_max'];
        }

        $stmt = $this->db->getPdo()->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function updateStock($id, $quantite) {
        $stmt = $this->db->getPdo()->prepare("UPDATE produit SET stock = stock - ? WHERE id = ? AND stock >= ?");
        return $stmt->execute([$quantite, $id, $quantite]);
    }
}
