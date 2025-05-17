<?php
if (!isset($_GET['id'])) {
    header('Location: ?page=boutique');
    exit;
}
$produit_id = (int)$_GET['id'];
$produit_data = $this->produit->getProduit($produit_id);
if (!$produit_data) {
    header('Location: ?page=boutique');
    exit;
}

if (isset($_POST['ajouter'])) {
    $quantite = (int)$_POST['quantite'];
    if ($this->produit->updateStock($produit_id, $quantite)) {
        $panier = new \LibertaMobile\Core\Panier();
        $panier->ajouterProduit($produit_id, $quantite);
        header('Location: ?page=panier');
        exit;
    } else {
        $erreur = "Stock insuffisant";
    }
}

$content = '<section class="container mx-auto py-8">
    <div class="card flex flex-col md:flex-row gap-6">
        ' . ($produit_data['image_url'] ? '<img src="' . htmlspecialchars($produit_data['image_url']) . '" alt="' . htmlspecialchars($produit_data['nom']) . '" class="w-full md:w-1/3 h-64 object-cover rounded-lg">' : '') . '
        <div class="flex-1">
            <h2 class="text-3xl font-bold mb-4">' . htmlspecialchars($produit_data['nom']) . '</h2>';
if ($produit_data['type'] === 'telephone') {
    $content .= '<p class="text-gray-600 mb-2">' . htmlspecialchars($produit_data['marque']) . ' ' . htmlspecialchars($produit_data['modele']) . '</p>';
} else {
    $content .= '<p class="text-gray-600 mb-2">' . htmlspecialchars($produit_data['forfait_nom']) . '</p>
        <p class="text-gray-600 mb-2">Réseau: ' . htmlspecialchars($produit_data['reseau']) . '</p>
        <p class="text-gray-600 mb-2">Données: ' . htmlspecialchars($produit_data['data']) . ' Go</p>
        <p class="text-gray-600 mb-2">Appels: ' . ($produit_data['appels_illimites'] ? 'Illimités' : 'Limités') . '</p>
        <p class="text-gray-600 mb-2">SMS: ' . ($produit_data['sms_illimites'] ? 'Illimités' : 'Limités') . '</p>';
}
$content .= '<p class="text-gray-600 mb-2">' . htmlspecialchars($produit_data['description']) . '</p>
            <p class="text-xl font-bold mb-4">' . number_format($produit_data['prix'], 2) . ' €</p>
            <form method="POST" class="flex items-center gap-4">
                <label class="block mb-1">Quantité</label>
                <input type="number" name="quantite" value="1" min="1" class="w-20">
                <button type="submit" name="ajouter" class="bg-accent text-white py-2 px-4 rounded">Ajouter au panier</button>
            </form>';
if (isset($erreur)) {
    $content .= '<p class="text-red-600 mt-4">' . $erreur . '</p>';
}
$content .= '</div>
    </div>
</section>';
?>