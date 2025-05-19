<?php
require_once __DIR__ . '/../src/config/database.php';
require_once __DIR__ . '/../src/core/Autoloader.php';
require_once __DIR__ . '/../vendor/autoload.php';

use Liberta_Mobile\Core\Autoloader;
use Liberta_Mobile\Config\Database;

(new Autoloader())->register();

\Stripe\Stripe::setApiKey('***REMOVED***votre_cle_secrete');

session_start();
$db = new Database();
$pdo = $db->getPdo();

$items = json_decode(file_get_contents('php://input'), true);

$line_items = array_map(fn($item) => [
    'price_data' => [
        'currency' => 'eur',
        'product_data' => ['name' => $item['nom']],
        'unit_amount' => $item['prix'] * 100,
    ],
    'quantity' => $item['quantite'],
], $items);

try {
    $session = \Stripe\Checkout\Session::create([
        'payment_method_types' => ['card'],
        'line_items' => $line_items,
        'mode' => 'payment',
        'success_url' => 'http://localhost/LIBERTA_MOBILE/public/?page=panier&success=1',
        'cancel_url' => 'http://localhost/LIBERTA_MOBILE/public/?page=panier&cancel=1',
    ]);

    $stmt = $pdo->prepare("INSERT INTO commande (utilisateur_id, total, statut) VALUES (?, ?, 'en_attente')");
    $total = array_sum(array_map(fn($item) => $item['prix'] * $item['quantite'], $items));
    $stmt->execute([$_SESSION['user']['id'], $total]);
    $commande_id = $pdo->lastInsertId();

    foreach ($items as $item) {
        $stmt = $pdo->prepare("INSERT INTO commande_produit (commande_id, produit_id, quantite, prix_au_moment) VALUES (?, ?, ?, ?)");
        $stmt->execute([$commande_id, $item['id'], $item['quantite'], $item['prix']]);
    }

    echo json_encode(['id' => $session->id]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
