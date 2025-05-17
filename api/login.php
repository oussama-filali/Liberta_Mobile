<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../src/Core/Autoloader.php';
use Liberta_Mobile\Core\Autoloader;
(new Autoloader())->register();

use Liberta_Mobile\Model\Utilisateur;

session_start();
use Liberta_Mobile\Config\Database;
$db = new Database();
$utilisateur = new Utilisateur($db);

$data = json_decode(file_get_contents('php://input'), true);
$email = $data['email'] ?? '';
$mot_de_passe = $data['mot_de_passe'] ?? '';

$user = $utilisateur->getUtilisateurByEmail($email);
if ($user && password_verify($mot_de_passe, $user['mot_de_passe'])) {
    $_SESSION['user'] = $user;
    echo json_encode(['success' => true, 'user' => $user]);
} else {
    echo json_encode(['success' => false, 'message' => 'Email ou mot de passe incorrect']);
}
?>