<?php
// Vérifie l’inclusion via MainController
if (!defined('LIBERTA_MOBILE_INCLUDED')) {
    define('LIBERTA_MOBILE_INCLUDED', true);
}

// Utiliser la variable $this du contexte de la méthode route() de MainController
$filters = $_GET ?? [];
$produits = $this->produit->getProduits($filters);
?>

<section class="container">
  <h2>Notre Boutique</h2>

  <div class="filters">
    <button class="filter-btn" data-type="">Tous</button>
    <button class="filter-btn" data-type="telephone">Téléphones seuls</button>
    <button class="filter-btn" data-type="forfait">Forfaits seuls</button>
    <button class="filter-btn" data-type="pack">Packs Téléphone + Forfait</button>
  </div>

  <div id="product-grid" class="grid-cards">
    <?php
    if (empty($produits)) {
        echo '<p class="text-gray-600">Aucun produit trouvé.</p>';
    } else {
        foreach ($produits as $p) {
            $nom = htmlspecialchars($p['nom'] ?? '');
            $prix = number_format($p['prix'], 2);
            $image = htmlspecialchars($p['image_url'] ?? '');
            $imageTag = $image ? "<img src='/public/images/$image' alt='$nom' class='w-full h-48 object-cover rounded-t-lg'>" : '';

            // Détection du type pour affichage JS/filtrage
            $type = '';
            if ($p['type'] === 'telephone' && !empty($p['forfait_id'])) {
                $type = 'pack';
            } elseif ($p['type'] === 'telephone') {
                $type = 'telephone';
            } elseif ($p['type'] === 'forfait') {
                $type = 'forfait';
            }

            echo "<div class='card' data-type='$type'>";
            echo $imageTag;
            echo "<h3 class='text-xl font-semibold mt-2'>$nom</h3>";

            if ($type === 'telephone') {
                echo "<p class='text-gray-600'>" . htmlspecialchars($p['marque'] ?? '') . ' ' . htmlspecialchars($p['modele'] ?? '') . "</p>";
            } elseif ($type === 'forfait') {
                echo "<p class='text-gray-600'>" . htmlspecialchars($p['forfait_nom'] ?? '') . "</p>";
            } elseif ($type === 'pack') {
                echo "<p class='text-gray-600'>Pack : " . htmlspecialchars($p['marque'] ?? '') . ' ' . htmlspecialchars($p['modele'] ?? '') . " + " . htmlspecialchars($p['forfait_nom'] ?? '') . "</p>";
            }

            echo "<p class='text-gray-600'>$prix €</p>";
            echo "<a href='?page=produit&id={$p['id']}' class='bg-accent text-white py-2 px-4 rounded mt-2 inline-block'>Voir détails</a>";
            echo '</div>';
        }
    }
    ?>
  </div>
</section>

<link rel="stylesheet" href="/LIBERTA_MOBILE/public/assets/css/boutique.css">
<script src="/LIBERTA_MOBILE/public/assets/js/boutique.js" defer></script>
