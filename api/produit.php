<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../src/config/database.php';
require_once __DIR__ . '/../src/core/Autoloader.php';

use Liberta_Mobile\Core\Autoloader;
use Liberta_Mobile\Config\Database;
use Liberta_Mobile\Model\Produit;

(new Autoloader())->register();

$db = new Database();
$produit = new Produit($db);

// Recherche
if (isset($_GET['id'])) {
    echo json_encode($produit->getProduit((int)$_GET['id']) ?? []);
    exit;
}

if (isset($_GET['search'])) {
    $search = $_GET['search'];
    $stmt = $db->getPdo()->prepare("SELECT id, nom FROM produit WHERE nom LIKE ? LIMIT 5");
    $stmt->execute(["%$search%"]);
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
    exit;
}

// Liste filtrée
echo json_encode($produit->getProduits($_GET) ?? []);
