<?php
session_start();
require_once '../config/database.php';

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

if (!isset($_SESSION['user_id'])) exit;
$data = json_decode(file_get_contents("php://input"), true);
$db = (new Database())->connect();

$total_ht = 0;
foreach ($data['produits'] as $prod) {
    $total_ht += $prod['prix'] * $prod['quantite'];
}
$tva = $total_ht * 0.2;
$total_ttc = $total_ht + $tva;

$num = 'CMD-' . strtoupper(substr(md5(uniqid()), 0, 8));

$stmt = $db->prepare("INSERT INTO commandes (utilisateur_id, numero_commande, total_ht, tva, total_ttc, date) VALUES (?, ?, ?, ?, ?, NOW())");
$stmt->execute([$_SESSION['user_id'], $num, $total_ht, $tva, $total_ttc]);
$commande_id = $db->lastInsertId();

foreach ($data['produits'] as $prod) {
    $stmt = $db->prepare("INSERT INTO commande_produits (commande_id, produit_id, quantite, prix_unitaire) VALUES (?, ?, ?, ?)");
    $stmt->execute([$commande_id, $prod['id'], $prod['quantite'], $prod['prix']]);
}

echo json_encode(["message" => "Commande créée", "numero" => $num]);
?>
