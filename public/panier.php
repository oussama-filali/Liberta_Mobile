<?php
use Liberta_Mobile\Core\Panier;
$panier = new Panier();
$items = $panier->items;

$total = 0;
$content = '<section class="container py-8">
    <h2 class="text-3xl font-bold mb-6">Votre Panier</h2>';

if (empty($items)) {
    $content .= '<p>Votre panier est vide.</p>';
} else {
    $content .= '<div class="card">
        <table class="table">
            <thead><tr><th>Produit</th><th>Quantité</th><th>Prix</th><th>Sous-total</th></tr></thead><tbody>';
    foreach ($items as $item) {
        $subtotal = $item['prix'] * $item['quantite'];
        $total += $subtotal;
        $content .= '<tr>
            <td>' . htmlspecialchars($item['nom']) . '</td>
            <td>' . $item['quantite'] . '</td>
            <td>' . number_format($item['prix'], 2) . ' €</td>
            <td>' . number_format($subtotal, 2) . ' €</td>
        </tr>';
    }
    $content .= '</tbody></table>
        <div class="text-right mt-4">
            <p class="text-xl font-bold">Total : ' . number_format($total, 2) . ' €</p>
            <button onclick="procederPaiement()" class="bg-accent text-white py-2 px-6 rounded">Payer avec Stripe</button>
        </div>
    </div>';
}

$content .= '</section>';
