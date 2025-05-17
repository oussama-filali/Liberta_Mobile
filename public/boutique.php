<?php
// filepath: c:\wamp64\www\Liberta_Mobile\public\boutique.php

class BoutiquePage {
    private $db;
    private $produit;

    public function __construct($db, $produit) {
        $this->db = $db;
        $this->produit = $produit;
    }

    public function render() {
        $marques = $this->db->getPdo()->query("SELECT * FROM marque")->fetchAll(PDO::FETCH_ASSOC);
        $filters = $_GET;
        $produits = $this->produit->getProduits($filters);

        $content = '<section class="container mx-auto py-8 flex">
    <aside class="w-1/4 pr-4">
        <h2 class="text-2xl font-bold mb-4">Filtres</h2>
        <form id="filters" method="GET">
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
                <input type="number" name="prix_min" value="' . (isset($filters['prix_min']) ? htmlspecialchars($filters['prix_min']) : '') . '">
            </div>
            <div class="mb-4">
                <label class="block mb-1">Prix max</label>
                <input type="number" name="prix_max" value="' . (isset($filters['prix_max']) ? htmlspecialchars($filters['prix_max']) : '') . '">
            </div>
            <button type="submit" class="bg-accent text-white py-2 px-4 rounded">Appliquer</button>
        </form>
    </aside>
    <main class="w-3/4">
        <h2 class="text-3xl font-bold mb-6">Nos produits</h2>
        <div class="grid">';
        if (empty($produits)) {
            $content .= '<p class="text-gray-600">Aucun produit trouvé.</p>';
        } else {
            foreach ($produits as $p) {
                $content .= '<div class="card p-4 mb-4">
                    <h3 class="text-xl font-bold mb-2">' . htmlspecialchars($p['nom']) . '</h3>';
                if ($p['type'] === 'telephone') {
                    $content .= '<p class="text-gray-600">' . htmlspecialchars($p['marque']) . ' ' . htmlspecialchars($p['modele']) . '</p>';
                } else {
                    $content .= '<p class="text-gray-600">' . htmlspecialchars($p['forfait_nom']) . '</p>';
                }
                $content .= '<p class="text-gray-600">' . number_format($p['prix'], 2) . ' €</p>
                    <a href="?page=produit&id=' . $p['id'] . '" class="bg-accent text-white py-2 px-4 rounded mt-2 inline-block">Voir détails</a>
                </div>';
            }
        }
        $content .= '</div>
    </main>
</section>';
        return $content;
    }
}

// Exemple d'utilisation (à adapter selon ton contrôleur) :
// $page = new BoutiquePage($db, $produit);
// echo $page->render();
?>