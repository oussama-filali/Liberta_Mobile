<?php
if (!isset($_SESSION['user']) && isset($_GET['action']) && $_GET['action'] === 'login') {
    if (isset($_POST['connexion'])) {
        $email = $_POST['email'];
        $mot_de_passe = $_POST['mot_de_passe'];
        $stmt = $db->getPdo()->prepare("SELECT * FROM utilisateur WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user && password_verify($mot_de_passe, $user['mot_de_passe'])) {
            $_SESSION['user'] = $user;
            header('Location: ?page=profil');
            exit;
        } else {
            $erreur = "Email ou mot de passe incorrect";
        }
    }
    $content = '<h2 class="text-3xl font-bold mb-6">Connexion</h2>
        <form method="POST" class="max-w-md mx-auto">
            <div class="mb-4">
                <label class="block mb-1">Email</label>
                <input type="email" name="email" required class="w-full">
            </div>
            <div class="mb-4">
                <label class="block mb-1">Mot de passe</label>
                <input type="password" name="mot_de_passe" required class="w-full">
            </div>
            <button type="submit" name="connexion" class="bg-red-vif text-white py-2 px-4 rounded">Se connecter</button>
            <a href="?page=profil&action=register" class="block mt-2 text-blue-600">Pas de compte ? S’inscrire</a>
        </form>';
} elseif (!isset($_SESSION['user']) && isset($_GET['action']) && $_GET['action'] === 'register') {
    if (isset($_POST['inscription'])) {
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $email = $_POST['email'];
        $mot_de_passe = password_hash($_POST['mot_de_passe'], PASSWORD_BCRYPT);
        $stmt = $db->getPdo()->prepare("INSERT INTO utilisateur (nom, prenom, email, mot_de_passe) VALUES (?, ?, ?, ?)");
        if ($stmt->execute([$nom, $prenom, $email, $mot_de_passe])) {
            $_SESSION['user'] = ['email' => $email, 'nom' => $nom, 'prenom' => $prenom];
            header('Location: ?page=profil');
            exit;
        } else {
            $erreur = "Erreur lors de l’inscription";
        }
    }
    $content = '<h2 class="text-3xl font-bold mb-6">Inscription</h2>
        <form method="POST" class="max-w-md mx-auto">
            <div class="mb-4">
                <label class="block mb-1">Nom</label>
                <input type="text" name="nom" required class="w-full">
            </div>
            <div class="mb-4">
                <label class="block mb-1">Prénom</label>
                <input type="text" name="prenom" required class="w-full">
            </div>
            <div class="mb-4">
                <label class="block mb-1">Email</label>
                <input type="email" name="email" required class="w-full">
            </div>
            <div class="mb-4">
                <label class="block mb-1">Mot de passe</label>
                <input type="password" name="mot_de_passe" required class="w-full">
            </div>
            <button type="submit" name="inscription" class="bg-red-vif text-white py-2 px-4 rounded">S’inscrire</button>
        </form>';
} elseif (isset($_SESSION['user'])) {
    if (isset($_POST['modifier'])) {
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $email = $_POST['email'];
        $stmt = $db->getPdo()->prepare("UPDATE utilisateur SET nom = ?, prenom = ?, email = ? WHERE id = ?");
        if ($stmt->execute([$nom, $prenom, $email, $_SESSION['user']['id']])) {
            $_SESSION['user']['nom'] = $nom;
            $_SESSION['user']['prenom'] = $prenom;
            $_SESSION['user']['email'] = $email;
            $message = "Profil mis à jour";
        } else {
            $erreur = "Erreur lors de la mise à jour";
        }
    }
    if (isset($_POST['deconnexion'])) {
        session_destroy();
        header('Location: ?page=profil&action=login');
        exit;
    }
    $content = '<h2 class="text-3xl font-bold mb-6">Mon profil</h2>
        <form method="POST" class="max-w-md mx-auto">
            <div class="mb-4">
                <label class="block mb-1">Nom</label>
                <input type="text" name="nom" value="' . htmlspecialchars($_SESSION['user']['nom']) . '" required class="w-full">
            </div>
            <div class="mb-4">
                <label class="block mb-1">Prénom</label>
                <input type="text" name="prenom" value="' . htmlspecialchars($_SESSION['user']['prenom']) . '" required class="w-full">
            </div>
            <div class="mb-4">
                <label class="block mb-1">Email</label>
                <input type="email" name="email" value="' . htmlspecialchars($_SESSION['user']['email']) . '" required class="w-full">
            </div>
            <button type="submit" name="modifier" class="bg-red-vif text-white py-2 px-4 rounded">Modifier</button>
        </form>
        <form method="POST" class="max-w-md mx-auto mt-4">
            <button type="submit" name="deconnexion" class="bg-gray-600 text-white py-2 px-4 rounded">Se déconnecter</button>
        </form>
        <h3 class="text-2xl font-bold mt-8 mb-4">Historique des commandes</h3>';
    $stmt = $db->getPdo()->prepare("SELECT * FROM commande WHERE utilisateur_id = ? ORDER BY date_commande DESC");
    $stmt->execute([$_SESSION['user']['id']]);
    $commandes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (empty($commandes)) {
        $content .= '<p>Aucune commande.</p>';
    } else {
        $content .= '<table class="table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Total</th>
                    <th>Statut</th>
                </tr>
            </thead>
            <tbody>';
        foreach ($commandes as $commande) {
            $content .= '<tr>
                <td>' . htmlspecialchars($commande['date_commande']) . '</td>
                <td>' . number_format($commande['total'], 2) . ' €</td>
                <td>' . htmlspecialchars($commande['statut']) . '</td>
            </tr>';
        }
        $content .= '</tbody>
        </table>';
    }
}
if (isset($erreur)) $content = '<p class="text-red-600 mb-4">' . $erreur . '</p>' . $content;
if (isset($message)) $content = '<p class="text-green-600 mb-4">' . $message . '</p>' . $content;
?>