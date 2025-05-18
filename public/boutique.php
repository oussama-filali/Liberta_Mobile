<?php
// public/boutique.php

if (!defined('LIBERTA_MOBILE_INCLUDED')) {
    die('Accès non autorisé.');
}

$filters = $_GET;
$produits = $this->produit->getProduits($filters);
$db = new \Liberta_Mobile\Config\Database();
$marques = $db->getPdo()->query("SELECT * FROM marque")->fetchAll();

$content = '<section class="container py-8 flex flex-wrap gap-8">
<aside class="w-full md:w-1/4">
    <form method="GET" class="bg-white p-4 rounded shadow">
        <h3 class="text-lg font-semibold mb-2">Filtres</h3>
        <label>Type</label>
        <select name="type" class="w-full mb-2">
            <option value="">Tous</option>
            <option value="telephone"' . (isset($filters['type']) && $filters['type'] === 'telephone' ? ' selected' : '') . '>Téléphone</option>
            <option value="forfait"' . (isset($filters['type']) && $filters['type'] === 'forfait' ? ' selected' : '') . '>Forfait</option>
        </select>
        <label>Marque</label>
        <select name="marque_id" class="w-full mb-2">
            <option value="">Toutes</option>';
foreach ($marques as $marque) {
    $selected = (isset($filters['marque_id']) && $filters['marque_id'] == $marque['id']) ? 'selected' : '';
    $content .= '<option value="' . $marque['id'] . '" ' . $selected . '>' . htmlspecialchars($marque['nom']) . '</option>';
}
$content .= '</select>
        <label>Prix minimum</label>
        <input type="number" name="prix_min" class="w-full mb-2" value="' . ($filters['prix_min'] ?? '') . '">
        <label>Prix maximum</label>
        <input type="number" name="prix_max" class="w-full mb-2" value="' . ($filters['prix_max'] ?? '') . '">
        <button type="submit" class="btn w-full mt-2">Appliquer</button>
    </form>
</aside>
<main class="flex-1">
    <h2 class="text-2xl font-bold mb-6">Nos Produits</h2>
    <div class="grid">';
if (empty($produits)) {
    $content .= '<p class="text-gray-600">Aucun produit trouvé.</p>';
} else {
    foreach ($produits as $p) {
        $content .= '<div class="card">
            <img src="public/images/' . htmlspecialchars($p['image_url']) . '" alt="' . htmlspecialchars($p['nom']) . '" class="h-48 w-full object-cover rounded mb-2">
            <h4 class="text-xl font-bold">' . htmlspecialchars($p['nom']) . '</h4>
            <p class="text-gray-600">' . number_format($p['prix'], 2) . ' €</p>
            <a href="?page=produit&id=' . $p['id'] . '" class="btn mt-2">Voir</a>
        </div>';
    }
}
$content .= '</div>
</main>
</section>';
