<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../core/Autoloader.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../vendor/utoload.php';

use Liberta_Mobile\Model\Produit;

\Stripe\Stripe::setApiKey('***REMOVED***votre_cle_secrete');

$items = json_decode(file_get_contents('php://input'), true);
$line_items = [];

foreach ($items as $item) {
    $line_items[] = [
        'price_data' => [
            'currency' => 'eur',
            'product_data' => ['name' => $item['nom']],
            'unit_amount' => $item['prix'] * 100,
        ],
        'quantity' => $item['quantite'],
    ];
}

try {
    $session = \Stripe\Checkout\Session::create([
        'payment_method_types' => ['card'],
        'line_items' => $line_items,
        'mode' => 'payment',
        'success_url' => 'http://localhost/LIBERTA_MOBILE/public/?page=panier&success=1',
        'cancel_url' => 'http://localhost/LIBERTA_MOBILE/public/?page=panier&cancel=1',
    ]);

    $db = new Database();
    $pdo = $db->getPdo();
    $stmt = $pdo->prepare("INSERT INTO commande (utilisateur_id, total, statut) VALUES (?, ?, ?)");
    $total = array_sum(array_map(fn($item) => $item['prix'] * $item['quantite'], $items));
    $stmt->execute([$_SESSION['user']['id'], $total, 'en_attente']);

    $commande_id = $pdo->lastInsertId();
    foreach ($items as $item) {
        $stmt = $pdo->prepare("INSERT INTO commande_produit (commande_id, produit_id, quantite, prix_au_moment) VALUES (?, ?, ?, ?)");
        $stmt->execute([$commande_id, $item['id'], $item['quantite'], $item['prix']]);
    }

    echo json_encode(['id' => $session->id]);
} catch (\Stripe\Exception\ApiErrorException $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>