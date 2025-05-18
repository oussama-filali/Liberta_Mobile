<?php
// public/profil.php

if (!isset($_SESSION['user'])) {
    header('Location: ?page=profil&action=login');
    exit;
}

$user = $_SESSION['user'];

$content = '<section class="container py-10">
    <div class="card max-w-xl mx-auto">
        <h2 class="text-2xl font-bold mb-4">Mon Profil</h2>
        <p><strong>Nom :</strong> ' . htmlspecialchars($user['nom']) . '</p>
        <p><strong>Prénom :</strong> ' . htmlspecialchars($user['prenom']) . '</p>
        <p><strong>Email :</strong> ' . htmlspecialchars($user['email']) . '</p>
        <form method="POST" class="mt-4">
            <button name="deconnexion" class="btn bg-gray-600 text-white">Se déconnecter</button>
        </form>
    </div>
</section>';

if (isset($_POST['deconnexion'])) {
    session_destroy();
    header('Location: ?page=profil&action=login');
    exit;
}
