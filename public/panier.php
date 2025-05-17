<?php
use LibertaMobile\Core\Panier;

if (isset($_POST['ajouter'])) {
    $produit_id = $_POST['produit_id'];
    $quantite = (int)$_POST['quantite'];
    if ($this->produit->updateStock($produit_id, $quantite)) {
        $panier = new Panier();
        $panier->ajouterProduit($produit_id, $quantite);
        header('Location: ?page=panier');
        exit;
    } else {
        $erreur = "Stock insuffisant";
    }
}

$panier = new Panier();
$items = $panier->items;
$total = 0;
foreach ($items as $item) {
    $total += $item['prix'] * $item['quantite'];
}

$content = '<section class="container mx-auto py-8">
    <h2 class="text-3xl font-bold mb-6">Votre panier</h2>';
if (isset($erreur)) {
    $content .= '<p class="text-red-600 mb-4">' . $erreur . '</p>';
}
if (empty($items)) {
    $content .= '<p class="text-gray-600">Votre panier est vide.</p>';
} else {
    $content .= '<div class="card">
        <table class="table">
            <thead>
                <tr>
                    <th>Produit</th>
                    <th>Prix unitaire</th>
                    <th>Quantité</th>
                    <th>Total</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>';
    foreach ($items as $item) {
        $sous_total = $item['prix'] * $item['quantite'];
        $content .= '<tr>
            <td>' . htmlspecialchars($item['nom']) . '</td>
            <td>' . number_format($item['prix'], 2) . ' €</td>
            <td>' . $item['quantite'] . '</td>
            <td>' . number_format($sous_total, 2) . ' €</td>
            <td>
                <form action="?page=panier" method="POST">
                    <input type="hidden" name="produit_id" value="' . $item['id'] . '">
                    <button type="submit" name="supprimer" class="text-red-600 hover:underline">Supprimer</button>
                </form>
            </td>
        </tr>';
    }
    $content .= '</tbody>
        </table>
        <div class="mt-4 text-right">
            <p class="text-xl font-bold">Total: ' . number_format($total, 2) . ' €</p>
            <button onclick="procederPaiement()" class="bg-accent text-white py-2 px-6 rounded mt-2">Payer avec Stripe</button>
        </div>
    </div>';
}
$content .= '</section>';
?>