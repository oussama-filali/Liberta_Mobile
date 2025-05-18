<?php
// public/produit.php

if (!defined('LIBERTA_MOBILE_INCLUDED')) {
    die('Accès interdit');
}

if (!isset($_GET['id'])) {
    header('Location: ?page=boutique');
    exit;
}

$id = (int)$_GET['id'];
$produit = $GLOBALS['controller']->Produit->getProduit($id);

if (!$produit) {
    $content = '<p class="text-red-600 text-center mt-10">Produit introuvable.</p>';
    return;
}

$content = '<section class="container py-10">
    <div class="card flex flex-col md:flex-row gap-6">
        <img src="public/images/' . htmlspecialchars($produit['image_url']) . '" alt="' . htmlspecialchars($produit['nom']) . '" class="w-full md:w-1/3 h-64 object-cover rounded">
        <div class="flex-1">
            <h2 class="text-3xl font-bold mb-4">' . htmlspecialchars($produit['nom']) . '</h2>
            <p class="text-gray-600 mb-2"><strong>Type :</strong> ' . htmlspecialchars($produit['type']) . '</p>';
if ($produit['type'] === 'telephone') {
    $content .= '<p class="text-gray-600 mb-2"><strong>Marque :</strong> ' . htmlspecialchars($produit['marque']) . '</p>
                 <p class="text-gray-600 mb-2"><strong>Modèle :</strong> ' . htmlspecialchars($produit['modele']) . '</p>';
}
$content .= '<p class="text-gray-800 mb-2">' . htmlspecialchars($produit['description']) . '</p>
            <p class="text-xl font-bold mb-4">' . number_format($produit['prix'], 2) . ' €</p>
            <form method="POST" action="?page=panier">
                <input type="hidden" name="produit_id" value="' . $produit['id'] . '">
                <label class="block mb-2">Quantité :</label>
                <input type="number" name="quantite" value="1" min="1" class="w-24 mb-4">
                <button type="submit" name="ajouter" class="btn">Ajouter au panier</button>
            </form>
        </div>
    </div>
</section>';
?>