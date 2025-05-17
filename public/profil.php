<?php
if (!isset($_SESSION['user']) && isset($_GET['action']) && $_GET['action'] === 'login') {
    if (isset($_POST['connexion'])) {
        $email = $_POST['email'];
        $mot_de_passe = $_POST['mot_de_passe'];
        $utilisateur = new \LibertaMobile\Model\Utilisateur($this->db);
        $user = $utilisateur->getUtilisateurByEmail($email);
        if ($user && password_verify($mot_de_passe, $user['mot_de_passe'])) {
            $_SESSION['user'] = $user;
            header('Location: ?page=profil');
            exit;
        } else {
            $erreur = "Email ou mot de passe incorrect";
        }
    }
    $content = '<section class="container mx-auto py-8">
        <div class="card max-w-md mx-auto">
            <h2 class="text-3xl font-bold mb-6 text-center">Connexion</h2>
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
                <a href="?page=profil&action=register" class="block mt-2 text-blue-600 text-center">Pas de compte ? S’inscrire</a>
            </form>';
    if (isset($erreur)) {
        $content .= '<p class="text-red-600 mt-4">' . $erreur . '</p>';
    }
    $content .= '</div></section>';
} elseif (!isset($_SESSION['user']) && isset($_GET['action']) && $_GET['action'] === 'register') {
    if (isset($_POST['inscription'])) {
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $email = $_POST['email'];
        $mot_de_passe = $_POST['mot_de_passe'];
        $utilisateur = new \LibertaMobile\Model\Utilisateur($this->db);
        if ($utilisateur->createUtilisateur($nom, $prenom, $email, $mot_de_passe)) {
            $user = $utilisateur->getUtilisateurByEmail($email);
            $_SESSION['user'] = $user;
            header('Location: ?page=profil');
            exit;
        } else {
            $erreur = "Erreur lors de l’inscription";
        }
    }
    $content = '<section class="container mx-auto py-8">
        <div class="card max-w-md mx-auto">
            <h2 class="text-3xl font-bold mb-6 text-center">Inscription</h2>
            <form method="POST">
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
                <button type="submit" name="inscription" class="bg-accent text-white py-2 px-4 rounded w-full">S’inscrire</button>
            </form>';
    if (isset($erreur)) {
        $content .= '<p class="text-red-600 mt-4">' . $erreur . '</p>';
    }
    $content .= '</div></section>';
} elseif (isset($_SESSION['user'])) {
    if (isset($_POST['modifier'])) {
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $email = $_POST['email'];
        $utilisateur = new \LibertaMobile\Model\Utilisateur($this->db);
        if ($utilisateur->updateUtilisateur($_SESSION['user']['id'], $nom, $prenom, $email)) {
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
    $content = '<section class="container mx-auto py-8">
        <div class="card max-w-md mx-auto">
            <h2 class="text-3xl font-bold mb-6 text-center">Mon profil</h2>
            <form method="POST">
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
                <button type="submit" name="modifier" class="bg-accent text-white py-2 px-4 rounded w-full">Modifier</button>
            </form>
            <form method="POST" class="mt-4">
                <button type="submit" name="deconnexion" class="bg-gray-600 text-white py-2 px-4 rounded w-full">Se déconnecter</button>
            </form>';
    if (isset($erreur)) {
        $content .= '<p class="text-red-600 mt-4">' . $erreur . '</p>';
    }
    if (isset($message)) {
        $content .= '<p class="text-green-600 mt-4">' . $message . '</p>';
    }
    $content .= '</div>
        <div class="card mt-8">
            <h3 class="text-2xl font-bold mb-4">Historique des commandes</h3>';
    $stmt = $this->db->getPdo()->prepare("SELECT * FROM commande WHERE utilisateur_id = ? ORDER BY date_commande DESC");
    $stmt->execute([$_SESSION['user']['id']]);
    $commandes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (empty($commandes)) {
        $content .= '<p class="text-gray-600">Aucune commande.</p>';
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
    $content .= '</div></section>';
}
?>