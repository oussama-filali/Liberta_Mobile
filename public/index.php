<?php
session_start();
require_once __DIR__ . '/../src/core/database.php';
require_once __DIR__ . '/../src/models/produit.php';

$db = new Database();
$produit = new Produit($db);
$produits_phares = $produit->getProduitsPhare();

if (isset($_GET['page'])) {
    switch ($_GET['page']) {
        case 'boutique':
            require_once __DIR__ . '/boutique.php';
            break;
        case 'produit':
            require_once __DIR__ . '/produit.php';
            break;
        case 'panier':
            require_once __DIR__ . '/panier.php';
            break;
        case 'profil':
            require_once __DIR__ . '/profil.php';
            break;
        case 'admin':
            require_once __DIR__ . '/admin.php';
            break;
        default:
            require_once __DIR__ . '/home.php';
    }
} else {
    require_once __DIR__ . '/home.php';
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liberta Mobile - Boutique en Ligne</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <header class="bg-blue-night text-white p-4 sticky top-0">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-2xl font-bold">Liberta Mobile</h1>
            <nav class="flex items-center space-x-4">
                <input type="text" id="search" class="p-2 rounded" placeholder="Rechercher un produit...">
                <a href="?page=boutique" class="hover:underline">Boutique</a>
                <a href="?page=panier" class="hover:underline">Panier</a>
                <a href="?page=profil" class="hover:underline"><?php echo isset($_SESSION['user']) ? 'Profil' : 'Connexion'; ?></a>
                <a href="?page=admin" class="hover:underline">Admin</a>
            </nav>
        </div>
    </header>

    <main>
        <?php echo $content ?? ''; ?>
    </main>

    <footer class="bg-blue-night text-white p-4">
        <div class="container mx-auto text-center">
            <p>© <?php echo date('Y'); ?> Liberta Mobile. Tous droits réservés.</p>
            <a href="https://github.com/prenom-nom/boutique-en-ligne" class="underline">GitHub du projet</a>
        </div>
    </footer>

    <script src="https://js.stripe.com/v3/"></script>
    <script src="assets/script.js"></script>
</body>
</html>