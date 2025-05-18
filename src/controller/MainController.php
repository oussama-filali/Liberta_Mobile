<?php
// src/controllers/MainController.php

namespace Liberta_Mobile\Controller;

use Liberta_Mobile\Config\Database;
use Liberta_Mobile\Model\Produit;

class MainController {
    private $db;
    public $produit;

    public function __construct() {
        $this->db = new Database();
        $this->produit = new Produit($this->db);
    }

    public function route() {
        $page = $_GET['page'] ?? 'home';
        define('LIBERTA_MOBILE_INCLUDED', true);

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
        ob_start(); ?>
        <!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Liberta Mobile</title>
            <link rel="stylesheet" href="assets/css/style.css">
        </head>
        <body>
            <header>
                <div class="container flex-between">
                    <h1>Liberta Mobile</h1>
                    <nav>
                        <a href="?page=home">Accueil</a>
                        <a href="?page=boutique">Boutique</a>
                        <a href="?page=panier">Panier</a>
                        <a href="?page=profil"><?php echo isset($_SESSION['user']) ? 'Profil' : 'Connexion'; ?></a>
                        <a href="?page=admin">Admin</a>
                    </nav>
                </div>
            </header>

            <main class="container">
                <?= $content ?>
            </main>

            <footer>
                <p>© <?= date('Y') ?> Liberta Mobile. Tous droits réservés.</p>
            </footer>

            <script src="assets/js/script.js"></script>
        </body>
        </html>
        <?php return ob_get_clean();
    }
}
