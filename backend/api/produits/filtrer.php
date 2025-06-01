<?php
require_once '../middleware/cors.php';
require_once '../config/database.php';

$type = $_GET['type'] ?? null; // 'telephone' ou 'forfait'
$marque = $_GET['marque_id'] ?? null;
$modele = $_GET['modele_id'] ?? null;
$pack = $_GET['pack'] ?? null; // '1' pour packs

$query = "SELECT * FROM produit WHERE 1=1";
$params = [];

if ($type) {
    $query .= " AND type = ?";
    $params[] = $type;
}
if ($marque) {
    $query .= " AND marque_id = ?";
    $params[] = $marque;
}
if ($modele) {
    $query .= " AND modele_id = ?";
    $params[] = $modele;
}
if ($pack === '1') {
    $query .= " AND forfait_id IS NOT NULL";
} elseif ($pack === '0') {
    $query .= " AND forfait_id IS NULL";
}

$db = (new Database())->connect();
$stmt = $db->prepare($query);
$stmt->execute($params);
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($result);
