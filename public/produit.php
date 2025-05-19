<?php
if (!defined('LIBERTA_MOBILE_INCLUDED')) die('Accès refusé.');

$controller = $this;

if (!isset($_GET['id'])) {
  header('Location: ?page=boutique');
  exit;
}

$produit_id = (int)$_GET['id'];
$produit = $controller->produit->getProduit($produit_id);

if (!$produit) {
  header('Location: ?page=boutique');
  exit;
}
?>

<link rel="stylesheet" href="/LIBERTA_MOBILE/public/assets/css/produit.css">

<section class="container produit-detail">
  <div class="produit-card">
    <div class="image">
      <img src="/LIBERTA_MOBILE/public/images/<?= htmlspecialchars($produit['image_url'] ?? 'default.jpg') ?>" alt="<?= htmlspecialchars($produit['nom']) ?>">
    </div>
    <div class="infos">
      <h1><?= htmlspecialchars($produit['nom']) ?></h1>
      <p class="description"><?= htmlspecialchars($produit['description']) ?></p>

      <?php if ($produit['type'] === 'telephone'): ?>
        <p><strong>Marque :</strong> <?= htmlspecialchars($produit['marque']) ?></p>
        <p><strong>Modèle :</strong> <?= htmlspecialchars($produit['modele']) ?></p>
        <?php if ($produit['forfait_nom']): ?>
          <p><strong>Pack avec forfait :</strong> <?= htmlspecialchars($produit['forfait_nom']) ?> (<?= htmlspecialchars($produit['reseau']) ?> - <?= $produit['data'] ?> Go)</p>
        <?php endif; ?>
      <?php else: ?>
        <p><strong>Forfait :</strong> <?= htmlspecialchars($produit['forfait_nom']) ?></p>
        <p><strong>Réseau :</strong> <?= htmlspecialchars($produit['reseau']) ?></p>
        <p><strong>Données :</strong> <?= htmlspecialchars($produit['data']) ?> Go</p>
        <p><strong>Appels :</strong> <?= $produit['appels_illimites'] ? 'Illimités' : 'Limités' ?></p>
        <p><strong>SMS :</strong> <?= $produit['sms_illimites'] ? 'Illimités' : 'Limités' ?></p>
      <?php endif; ?>

      <p class="prix"><?= number_format($produit['prix'], 2) ?> €</p>

      <form method="POST">
        <input type="hidden" name="produit_id" value="<?= $produit['id'] ?>">
        <label for="quantite">Quantité :</label>
        <input type="number" name="quantite" value="1" min="1">
        <button type="submit" name="ajouter">Ajouter au panier</button>
      </form>

      <?php if (isset($erreur)) : ?>
        <p class="erreur"><?= $erreur ?></p>
      <?php endif; ?>
    </div>
  </div>
</section>
