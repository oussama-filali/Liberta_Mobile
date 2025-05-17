<?php
$content = '<section class="bg-gray-100 py-12">
    <div class="container mx-auto text-center">
        <h2 class="text-4xl font-bold mb-4">Découvrez nos derniers smartphones et forfaits</h2>
        <a href="?page=boutique" class="bg-red-vif text-white py-2 px-6 rounded hover:bg-red-700">Voir la boutique</a>
    </div>
</section>

<section class="container mx-auto py-8">
    <h2 class="text-3xl font-bold mb-6 text-center">Nos produits phares</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">';
foreach ($produits_phares as $p) {
    $content .= '<div class="border p-4 rounded shadow hover:shadow-lg">
        ' . ($p['image_url'] ? '<img src="' . htmlspecialchars($p['image_url']) . '" alt="' . htmlspecialchars($p['nom']) . '" class="w-full h-48 object-cover">' : '') . '
        <h3 class="text-xl font-semibold">' . htmlspecialchars($p['nom']) . '</h3>';
    if ($p['type'] === 'telephone') {
        $content .= '<p class="text-gray-600">' . htmlspecialchars($p['marque']) . ' ' . htmlspecialchars($p['modele']) . '</p>';
    } else {
        $content .= '<p class="text-gray-600">' . htmlspecialchars($p['forfait_nom']) . '</p>';
    }
    $content .= '<p class="text-gray-600">' . number_format($p['prix'], 2) . ' €</p>
        <a href="?page=produit&id=' . $p['id'] . '" class="bg-red-vif text-white py-2 px-4 rounded mt-2 inline-block">Voir détails</a>
    </div>';
}
$content .= '</div>
</section>';
?>