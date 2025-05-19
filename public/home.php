<section class="hero">
  <div class="hero-content">
    <h1>Bienvenue chez <span>Liberta Mobile</span></h1>
    <p>Découvrez nos téléphones, forfaits et packs avantageux</p>
    <div class="hero-buttons">
      <a href="?page=boutique&type=telephone" class="btn">Téléphones</a>
      <a href="?page=boutique&type=forfait" class="btn">Forfaits</a>
      <a href="?page=boutique&type=pack" class="btn">Packs Téléphone + Forfait</a>
    </div>
  </div>
</section>

<section class="produits-phares container">
  <h2>Nos produits phares</h2>
  <div class="grid">
    <?php foreach ($produits_phares as $p): ?>
      <div class="card">
        <img src="/LIBERTA_MOBILE/public/images/<?= htmlspecialchars($p['image_url']) ?>" alt="<?= htmlspecialchars($p['nom']) ?>">
        <h3><?= htmlspecialchars($p['nom']) ?></h3>
        <p class="prix"><?= number_format($p['prix'], 2) ?> €</p>
        <a href="?page=produit&id=<?= $p['id'] ?>" class="btn-small">Voir détails</a>
      </div>
    <?php endforeach; ?>
  </div>
</section>

<!-- Fenêtre modale de connexion -->
<div id="modal-connexion" class="modal hidden">
  <div class="modal-content">
    <span class="close" onclick="toggleModal()">&times;</span>
    <h2>Connexion</h2>
    <form method="POST" action="?page=profil&action=login">
      <input type="email" name="email" placeholder="Email" required>
      <input type="password" name="mot_de_passe" placeholder="Mot de passe" required>
      <button type="submit" name="connexion">Se connecter</button>
    </form>
    <p>Pas encore de compte ? <a href="?page=profil&action=register">Créer un compte</a></p>
  </div>
</div>
