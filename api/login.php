<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../src/config/database.php';
require_once __DIR__ . '/../src/core/Autoloader.php';

use Liberta_Mobile\Core\Autoloader;
use Liberta_Mobile\Model\Utilisateur;
use Liberta_Mobile\Config\Database;

(new Autoloader())->register();

session_start();

$db = new Database();
$utilisateur = new Utilisateur($db);

$data = json_decode(file_get_contents('php://input'), true);
$email = $data['email'] ?? '';
$password = $data['password'] ?? '';

$user = $utilisateur->getUtilisateurByEmail($email);
if ($user && password_verify($password, $user['mot_de_passe'])) {
    $_SESSION['user'] = $user;
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Identifiants incorrects']);
}
