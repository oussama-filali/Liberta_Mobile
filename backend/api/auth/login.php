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
$stmt = $db->prepare("SELECT * FROM utilisateur WHERE email = ?");
$stmt->execute([$data->email]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user && password_verify($data->password, $user['mot_de_passe'])) {
    $_SESSION['user_id'] = $user['id'];
    echo json_encode(["message" => "Connexion réussie", "user_id" => $user['id']]);
} else {
    http_response_code(401);
    echo json_encode(["message" => "Échec de la connexion"]);
}
?>