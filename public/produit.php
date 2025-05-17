<?php
$marques = $db->getPdo()->query("SELECT * FROM marque")->fetchAll(PDO::FETCH_ASSOC);
$filters = $_GET;
$produits = $produit->getProduits($filters);
$content = '<section class="container mx-auto py-8 flex">
    <aside class="w-1/4 pr-4">
        <h2 class="text-2xl font-bold mb-4">Filtres</h2>
        <form id="filters">
            <div class="mb-4">
                <label class="block mb-1">Type</label>
                <select name="type">
                    <option value="">Tous</option>
                    <option value="telephone" ' . (isset($filters['type']) && $filters['type'] === 'telephone' ? 'selected' : '') . '>Téléphones</option>
                    <option value="forfait" ' . (isset($filters['type']) && $filters['type'] === 'forfait' ? 'selected' : '') . '>Forfaits</option>
                </select>
            </div>
            <div class="mb-4">
                <label class="block mb-1">Marque</label>
                <select name="marque_id">
                    <option value="">Toutes</option>';
foreach ($marques as $marque) {
    $content .= '<option value="' . $marque['id'] . '" ' . (isset($filters['marque_id']) && $filters['marque_id'] == $marque['id'] ? 'selected' : '') . '>' . htmlspecialchars($marque['nom']) . '</option>';
}
$content .= '</select>
            </div>
            <div class="mb-4">
                <label class="block mb-1">Prix min</label>
                <input type="number" name="prix_min" value="' . (isset($filters['prix_min']) ? $filters['prix_min'] : '') . '">
            </div>
            <div class="mb-4">
                <label class="block mb-1">Prix max</label>
                <input type="number" name="prix_max" value="' . (isset($filters['prix_max']) ? $filters['prix_max'] : '') . '">
            </div>
            <button type="submit" class="bg-red-vif text-white py-2 px-4 rounded">Appliquer</button>
        </form>
    </aside>
    <main class="w-3/4">
        <h2 class="text-3xl font-bold mb-6">Nos produits</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">';
foreach ($produits as $p) {
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
    </main>
</section>';
?>