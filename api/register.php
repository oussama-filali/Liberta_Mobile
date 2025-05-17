<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../src/config/database.php';
require_once __DIR__ . '/../src/models/utilisateur.php';

// Use the fully qualified class names with their namespaces
use Liberta_Mobile\Config\Database;
use Liberta_Mobile\Model\Utilisateur;

$db = new Database();
$utilisateur = new Utilisateur($db);

$data = json_decode(file_get_contents('php://input'), true);
$nom = $data['nom'] ?? '';
$prenom = $data['prenom'] ?? '';
$email = $data['email'] ?? '';
$mot_de_passe = $data['mot_de_passe'] ?? '';

if ($utilisateur->createUtilisateur($nom, $prenom, $email, $mot_de_passe)) {
    session_start();
    $user = $utilisateur->getUtilisateurByEmail($email);
    $_SESSION['user'] = $user;
    echo json_encode(['success' => true, 'user' => $user]);
} else {
    echo json_encode(['success' => false, 'message' => 'Erreur lors de l’inscription']);
}
?>