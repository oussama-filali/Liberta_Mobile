<?php
header('Content-Type: application/json');

require_once __DIR__ . '/../src/config/database.php';
require_once __DIR__ . '/../src/core/Autoloader.php';

(new \Liberta_Mobile\Core\Autoloader())->register();

use Liberta_Mobile\Config\Database;
use Liberta_Mobile\Model\Produit;

$db = new Database();
$produit = new Produit($db);

// Récupère tous les produits
$data = $produit->getProduits();

echo json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
