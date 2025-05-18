<?php
// public/home.php

if (!defined('LIBERTA_MOBILE_INCLUDED')) {
    die('Accès non autorisé.');
}

$produits_phares = $this->produit->getProduitsPhare();

$content = '<section class="hero">
    <div class="container text-center py-10">
        <h2 class="text-4xl font-bold mb-4">Bienvenue sur Liberta Mobile</h2>
        <p class="mb-6">Découvrez nos derniers modèles de smartphones et forfaits</p>
        <a href="?page=boutique" class="btn">Voir la boutique</a>
    </div>
</section>

<section class="container py-10">
    <h3 class="text-3xl font-semibold mb-6 text-center">Produits phares</h3>
    <div class="grid">';

foreach ($produits_phares as $p) {
    $content .= '<div class="card">
        <img src="public/images/' . htmlspecialchars($p['image_url']) . '" alt="' . htmlspecialchars($p['nom']) . '" class="h-48 w-full object-cover rounded mb-2">
        <h4 class="text-xl font-bold">' . htmlspecialchars($p['nom']) . '</h4>
        <p class="text-gray-600">' . number_format($p['prix'], 2) . ' €</p>
        <a href="?page=produit&id=' . $p['id'] . '" class="btn mt-2">Détails</a>
    </div>';
}

$content .= '</div></section>';
