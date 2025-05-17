<?php
use LibertaMobile\Model\Admin;

session_start();

if (!isset($_SESSION['admin'])) {
    if (isset($_POST['connexion'])) {
        $email = $_POST['email'];
        $mot_de_passe = $_POST['mot_de_passe'];
        $database = new \LibertaMobile\Config\Database();
        $adminModel = new Admin($database);
        $admin = $adminModel->getAdminByEmail($email);
        if ($admin && password_verify($mot_de_passe, $admin['mot_de_passe'])) {
            $_SESSION['admin'] = $admin;
            header('Location: ?page=admin');
            exit;
        } else {
            $erreur = "Email ou mot de passe incorrect";
        }
    }
    $content = '<section class="container mx-auto py-8">
        <div class="card max-w-md mx-auto">
            <h2 class="text-3xl font-bold mb-6 text-center">Connexion Admin</h2>
            <form method="POST">
                <div class="mb-4">
                    <label class="block mb-1">Email</label>
                    <input type="email" name="email" required class="w-full">
                </div>
                <div class="mb-4">
                    <label class="block mb-1">Mot de passe</label>
                    <input type="password" name="mot_de_passe" required class="w-full">
                </div>
                <button type="submit" name="connexion" class="bg-accent text-white py-2 px-4 rounded w-full">Se connecter</button>
            </form>';
    if (isset($erreur)) {
        $content .= '<p class="text-red-600 mt-4">' . $erreur . '</p>';
    }
    $content .= '</div></section>';
} else {
    $database = new \LibertaMobile\Config\Database();

    // Ajout produit
    if (isset($_POST['ajouter_produit'])) {
        $nom = $_POST['nom'];
        $description = $_POST['description'];
        $prix = $_POST['prix'];
        $image_url = $_POST['image_url'];
        $stock = $_POST['stock'];
        $type = $_POST['type'];
        $marque_id = !empty($_POST['marque_id']) ? $_POST['marque_id'] : null;
        $modele_id = !empty($_POST['modele_id']) ? $_POST['modele_id'] : null;
        $forfait_id = !empty($_POST['forfait_id']) ? $_POST['forfait_id'] : null;
        $stmt = $database->getPdo()->prepare("INSERT INTO produit (nom, description, prix, image_url, stock, type, marque_id, modele_id, forfait_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        if ($stmt->execute([$nom, $description, $prix, $image_url, $stock, $type, $marque_id, $modele_id, $forfait_id])) {
            $message = "Produit ajouté";
        } else {
            $erreur = "Erreur lors de l’ajout";
        }
    }

    // Suppression produit
    if (isset($_POST['supprimer_produit'])) {
        $produit_id = $_POST['produit_id'];
        $stmt = $database->getPdo()->prepare("DELETE FROM produit WHERE id = ?");
        if ($stmt->execute([$produit_id])) {
            $message = "Produit supprimé";
        } else {
            $erreur = "Erreur lors de la suppression";
        }
    }

    // Déconnexion
    if (isset($_POST['deconnexion'])) {
        session_destroy();
        header('Location: ?page=admin');
        exit;
    }

    // Récupération des listes pour les select
    $marques = $database->getPdo()->query("SELECT * FROM marque")->fetchAll(PDO::FETCH_ASSOC);
    $modeles = $database->getPdo()->query("SELECT * FROM modele")->fetchAll(PDO::FETCH_ASSOC);
    $forfaits = $database->getPdo()->query("SELECT * FROM forfait")->fetchAll(PDO::FETCH_ASSOC);

    $content = '<section class="container mx-auto py-8">
        <div class="card">
            <h2 class="text-3xl font-bold mb-6">Tableau de bord Admin</h2>';
    if (isset($erreur)) $content .= '<p class="text-red-600 mb-4">' . $erreur . '</p>';
    if (isset($message)) $content .= '<p class="text-green-600 mb-4">' . $message . '</p>';
    $content .= '<h3 class="text-2xl font-bold mb-4">Ajouter un produit</h3>
            <form method="POST" class="mb-8">
                <div class="mb-4">
                    <label class="block mb-1">Nom</label>
                    <input type="text" name="nom" required class="w-full">
                </div>
                <div class="mb-4">
                    <label class="block mb-1">Description</label>
                    <textarea name="description" class="w-full"></textarea>
                </div>
                <div class="mb-4">
                    <label class="block mb-1">Prix</label>
                    <input type="number" step="0.01" name="prix" required class="w-full">
                </div>
                <div class="mb-4">
                    <label class="block mb-1">Image URL</label>
                    <input type="text" name="image_url" class="w-full">
                </div>
                <div class="mb-4">
                    <label class="block mb-1">Stock</label>
                    <input type="number" name="stock" required class="w-full">
                </div>
                <div class="mb-4">
                    <label class="block mb-1">Type</label>
                    <select name="type" required>
                        <option value="telephone">Téléphone</option>
                        <option value="forfait">Forfait</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block mb-1">Marque</label>
                    <select name="marque_id" class="w-full">
                        <option value="">Aucune</option>';
    foreach ($marques as $marque) {
        $content .= '<option value="' . $marque['id'] . '">' . htmlspecialchars($marque['nom']) . '</option>';
    }
    $content .= '</select>
                </div>
                <div class="mb-4">
                    <label class="block mb-1">Modèle</label>
                    <select name="modele_id" class="w-full">
                        <option value="">Aucun</option>';
    foreach ($modeles as $modele) {
        $content .= '<option value="' . $modele['id'] . '">' . htmlspecialchars($modele['nom']) . '</option>';
    }
    $content .= '</select>
                </div>
                <div class="mb-4">
                    <label class="block mb-1">Forfait</label>
                    <select name="forfait_id" class="w-full">
                        <option value="">Aucun</option>';
    foreach ($forfaits as $forfait) {
        $content .= '<option value="' . $forfait['id'] . '">' . htmlspecialchars($forfait['nom']) . '</option>';
    }
    $content .= '</select>
                </div>
                <button type="submit" name="ajouter_produit" class="bg-accent text-white py-2 px-4 rounded">Ajouter</button>
            </form>
            <h3 class="text-2xl font-bold mb-4">Liste des produits</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Type</th>
                        <th>Prix</th>
                        <th>Stock</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>';
    $produits = $database->getPdo()->query("SELECT p.*, m.nom AS marque, mo.nom AS modele, f.nom AS forfait_nom FROM produit p LEFT JOIN marque m ON p.marque_id = m.id LEFT JOIN modele mo ON p.modele_id = mo.id LEFT JOIN forfait f ON p.forfait_id = f.id")->fetchAll(PDO::FETCH_ASSOC);
    foreach ($produits as $p) {
        $content .= '<tr>
            <td>' . htmlspecialchars($p['nom']) . '</td>
            <td>' . htmlspecialchars($p['type']) . '</td>
            <td>' . number_format($p['prix'], 2) . ' €</td>
            <td>' . htmlspecialchars($p['stock']) . '</td>
            <td>
                <form method="POST" style="display:inline;">
                    <input type="hidden" name="produit_id" value="' . $p['id'] . '">
                    <button type="submit" name="supprimer_produit" class="text-red-600 hover:underline">Supprimer</button>
                </form>
            </td>
        </tr>';
    }
    $content .= '</tbody>
            </table>
            <form method="POST">
                <button type="submit" name="deconnexion" class="bg-gray-600 text-white py-2 px-4 rounded mt-4">Déconnexion</button>
            </form>
        </div>
    </section>';
}
?>