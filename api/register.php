<?php
// filepath: c:\wamp64\www\Liberta\api\register.php
require_once __DIR__ . '/../src/core/database.php';

$data = json_decode(file_get_contents('php://input'), true);

$nom = $data['nom'] ?? '';
$prenom = $data['prenom'] ?? '';
$date_naissance = $data['date_naissance'] ?? '';
$email = $data['email'] ?? '';
$password = $data['password'] ?? '';

if (!$nom || !$prenom || !$date_naissance || !$email || !$password) {
    echo json_encode(['success' => false, 'message' => 'Tous les champs sont obligatoires.']);
    exit;
}

$pdo = Database::getConnection();
$stmt = $pdo->prepare("SELECT id FROM utilisateur WHERE email = ?");
$stmt->execute([$email]);
if ($stmt->fetch()) {
    echo json_encode(['success' => false, 'message' => 'Email déjà utilisé.']);
    exit;
}

$hash = password_hash($password, PASSWORD_DEFAULT);
$stmt = $pdo->prepare("INSERT INTO utilisateur (nom, prenom, date_naissance, email, mot_de_passe, role, date_inscription) VALUES (?, ?, ?, ?, ?, 'client', NOW())");
$stmt->execute([$nom, $prenom, $date_naissance, $email, $hash]);

echo json_encode(['success' => true]);