<?php
require_once '../config/database.php';

$db = (new Database())->connect();
$stmt = $db->query("SELECT * FROM promotions WHERE NOW() BETWEEN date_debut AND date_fin");
$promos = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($promos);
?>
