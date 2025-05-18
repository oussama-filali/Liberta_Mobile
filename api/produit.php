<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../src/config/database.php';
require_once __DIR__ . '/../src/core/Autoloader.php';
(new \Liberta_Mobile\Core\Autoloader())->register();

use Liberta_Mobile\Model\Produit;
use Liberta_Mobile\Config\Database;

$db = new Database();
$produit = new Produit($db);

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $result = $produit->getProduit($id);
    echo json_encode($result ?: []);
} elseif (isset($_GET['search'])) {
    $query = $_GET['search'];
    $stmt = $db->getPdo()->prepare("SELECT p.*, m.nom AS marque, mo.nom AS modele, f.nom AS forfait_nom FROM produit p LEFT JOIN marque m ON p.marque_id = m.id LEFT JOIN modele mo ON p.modele_id = mo.id LEFT JOIN forfait f ON p.forfait_id = f.id WHERE p.nom LIKE ? LIMIT 5");
    $stmt->execute(["%$query%"]);
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
} else {
    $filters = $_GET;
    $results = $produit->getProduits($filters);
    echo json_encode($results ?: []);
}
?>