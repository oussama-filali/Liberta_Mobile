<?php
// backend/api/produits/index.php
require_once '../middleware/cors.php';
require_once '../config/database.php';
require_once '../models/Produit.php';

$db = (new Database())->connect();
$produitModel = new Produit($db);

$stmt = $produitModel->getAll();
$produits = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($produits);
