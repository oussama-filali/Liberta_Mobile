<?php
// public/panier.php

use Liberta_Mobile\Core\Panier;
use Liberta_Mobile\Model\Produit;
use Liberta_Mobile\Config\Database;

$panier = new Panier();
$items = $panier->items;
$total = 0;

$db = new Database();
$produitManager = new Produit($db);

$content = '<section class="container py-10">
    <h2 class="text-3xl font-bold mb-6">Votre panier</h2>';

if (empty($items)) {
    $content .= '<p class="text-gray-600">Votre panier est vide.</p>';
} else {
    $content .= '<div class="card">
        <table class="table">
            <thead>
                <tr><th>Produit</th><th>Prix</th><th>Quantité</th><th>Sous-total</th></tr>
            </thead><tbody>';
    foreach ($items as $item) {
        $produit = $produitManager->getProduit($item['id']);
        $sous_total = $produit['prix'] * $item['quantite'];
        $total += $sous_total;

        $content .= '<tr>
            <td>' . htmlspecialchars($produit['nom']) . '</td>
            <td>' . number_format($produit['prix'], 2) . ' €</td>
            <td>' . $item['quantite'] . '</td>
            <td>' . number_format($sous_total, 2) . ' €</td>
        </tr>';
    }
    $content .= '</tbody></table>
        <div class="text-right mt-4">
            <p class="text-xl font-bold">Total : ' . number_format($total, 2) . ' €</p>
            <button onclick="procederPaiement()" class="btn mt-2">Payer avec Stripe</button>
        </div>
    </div>';
}

$content .= '</section>';
?>
<script src="https://js.stripe.com/v3/"></script>