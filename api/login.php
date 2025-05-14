<?php
// api/login.php
session_start();
require_once __DIR__ . '/../src/core/database.php';
require_once __DIR__ . '/../src/models/admin.php';

$data = json_decode(file_get_contents('php://input'), true);
$email = $data['email'] ?? '';
$password = $data['password'] ?? '';

$user = Admin::findByEmail($email);

if ($user && password_verify($password, $user['mot_de_passe'])) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Identifiants incorrects.']);
}
