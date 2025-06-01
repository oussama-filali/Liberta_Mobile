<?php
require __DIR__ . '/../../vendor/'; // Chemin correct

\Stripe\Stripe::setApiKey(getenv('STRIPE_SECRET_KEY'));

// Ajoute les headers CORS pour autoriser l'appel depuis React
header('Access-Control-Allow-Origin: http://localhost:3000');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json; charset=UTF-8');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

$data = json_decode(file_get_contents("php://input"), true);

$lineItems = array_map(function ($item) {
    return [
        'price_data' => [
            'currency' => 'eur',
            'product_data' => [
                'name' => $item['nom'],
            ],
            'unit_amount' => intval($item['prix'] * 100), // en centimes
        ],
        'quantity' => $item['quantite'],
    ];
}, $data['produits']);

$session = \Stripe\Checkout\Session::create([
    'payment_method_types' => ['card'],
    'line_items' => $lineItems,
    'mode' => 'payment',
    'success_url' => 'http://localhost:3000/success',
    'cancel_url' => 'http://localhost:3000/cancel',
]);

echo json_encode(['url' => $session->url]);
