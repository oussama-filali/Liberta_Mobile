<?php
// public/admin.php

use Liberta_Mobile\Model\Admin;
use Liberta_Mobile\Config\Database;

$db = new Database();
$adminModel = new Admin($db);

if (!isset($_SESSION['admin'])) {
    if (isset($_POST['connexion'])) {
        $email = $_POST['email'];
        $mot_de_passe = $_POST['mot_de_passe'];
        $admin = $adminModel->getAdminByEmail($email);
        if ($admin && password_verify($mot_de_passe, $admin['mot_de_passe'])) {
            $_SESSION['admin'] = $admin;
            header('Location: ?page=admin');
            exit;
        } else {
            $erreur = "Identifiants incorrects.";
        }
    }

    $content = '<section class="container py-10">
        <div class="card max-w-md mx-auto">
            <h2 class="text-2xl font-bold mb-4 text-center">Connexion Admin</h2>
            <form method="POST">
                <input type="email" name="email" placeholder="Email" class="w-full mb-3" required>
                <input type="password" name="mot_de_passe" placeholder="Mot de passe" class="w-full mb-3" required>
                <button name="connexion" class="btn w-full">Connexion</button>
            </form>';
    if (isset($erreur)) {
        $content .= '<p class="text-red-600 mt-3">' . $erreur . '</p>';
    }
    $content .= '</div></section>';
} else {
    // gestion back-office produit
    $pdo = $db->getPdo();
    $produits = $pdo->query("SELECT * FROM produit")->fetchAll();

    if (isset($_POST['deconnexion'])) {
        unset($_SESSION['admin']);
        header('Location: ?page=admin');
        exit;
    }

    $content = '<section class="container py-10">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-3xl font-bold">Tableau de bord Admin</h2>
            <form method="POST"><button name="deconnexion" class="btn">Déconnexion</button></form>
        </div>
        <div class="card">
            <h3 class="text-xl font-semibold mb-4">Liste des produits</h3>
            <table class="table">
                <thead><tr><th>Nom</th><th>Prix</th><th>Type</th><th>Stock</th></tr></thead>
                <tbody>';
    foreach ($produits as $p) {
        $content .= '<tr>
            <td>' . htmlspecialchars($p['nom']) . '</td>
            <td>' . number_format($p['prix'], 2) . ' €</td>
            <td>' . htmlspecialchars($p['type']) . '</td>
            <td>' . htmlspecialchars($p['stock']) . '</td>
        </tr>';
    }
    $content .= '</tbody></table>
        </div>
    </section>';
}
?>