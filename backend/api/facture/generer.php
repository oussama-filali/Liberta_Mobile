<?php
session_start();
require_once '../config/database.php';

if (!isset($_SESSION['user_id'])) exit;
$commande_id = $_GET['commande_id'] ?? null;

$db = (new Database())->connect();

$stmt = $db->prepare("SELECT * FROM commandes WHERE id = ? AND utilisateur_id = ?");
$stmt->execute([$commande_id, $_SESSION['user_id']]);
$commande = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt = $db->prepare("SELECT * FROM commande_produits cp JOIN produits p ON cp.produit_id = p.id WHERE cp.commande_id = ?");
$stmt->execute([$commande_id]);
$produits = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode([
    "commande" => $commande,
    "produits" => $produits
]);
?>
