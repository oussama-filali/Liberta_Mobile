<?php
namespace Liberta_Mobile\Controller;

use Liberta_Mobile\Config\Database;

// Ensure the Produit class is loaded
require_once __DIR__ . '/../models/produit.php';
use Liberta_Mobile\Model\Produit;

class MainController {
    private $db;
    private $produit;

    public function __construct() {
        $this->db = new Database();
        $this->produit = new Produit($this->db);
    }

    public function route() {
        $page = $_GET['page'] ?? 'home';
        $id = $_GET['id'] ?? null;
        $action = $_GET['action'] ?? null;

        ob_start();
        switch ($page) {
            case 'boutique':
                require __DIR__ . '/../../public/boutique.php';
                break;
            case 'produit':
                require __DIR__ . '/../../public/produit.php';
                break;
            case 'panier':
                require __DIR__ . '/../../public/panier.php';
                break;
            case 'profil':
                require __DIR__ . '/../../public/profil.php';
                break;
            case 'admin':
                require __DIR__ . '/../../public/admin.php';
                break;
            default:
                require __DIR__ . '/../../public/home.php';
        }
        $content = ob_get_clean();

        echo $this->render($content);
    }

    private function render($content) {
        $produits_phares = $this->produit->getProduitsPhare();
        ob_start();
        ?>
        <!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Liberta Mobile - Boutique en Ligne</title>
            <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
            <link rel="stylesheet" href="/LIBERTA_MOBILE/public/assets/css/style.css">
        </head>
        <body>
            <header class="bg-primary text-white p-4 sticky top-0">
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
                <?php echo $content; ?>
            </main>

            <footer class="bg-primary text-white p-4">
                <div class="container mx-auto text-center">
                    <p>© <?php echo date('Y'); ?> Liberta Mobile. Tous droits réservés.</p>
                    <a href="https://github.com/prenom-nom/boutique-en-ligne" class="underline">GitHub</a>
                </div>
            </footer>

            <script src="https://js.stripe.com/v3/"></script>
            <script src="/LIBERTA_MOBILE/public/assets/js/script.js"></script>
        </body>
        </html>
        <?php
        return ob_get_clean();
    }
}
?>