<?php
session_start();
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

require_once '../../config/Database.php';

$data = json_decode(file_get_contents("php://input"));
if (!isset($data->email) || !isset($data->password)) {
    http_response_code(400);
    echo json_encode(["message" => "Email et mot de passe requis"]);
    exit;
}

$db = (new Database())->connect();
$hash = password_hash($data->password, PASSWORD_BCRYPT);
$stmt = $db->prepare("INSERT INTO utilisateur (nom, prenom, email, mot_de_passe, role) VALUES (?, ?, ?, ?, 'client')");
$stmt->execute(['Utilisateur', 'Nouveau', $data->email, $hash]);
echo json_encode(["message" => "Utilisateur inscrit"]);
?>