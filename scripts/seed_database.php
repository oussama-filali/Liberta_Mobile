<?php
require_once __DIR__ . '/../src/config/database.php';

use Liberta_Mobile\Config\Database;

$db = new Database();
$pdo = $db->getPdo();

$marques = ['Apple', 'Samsung', 'Xiaomi'];
$images = [
    'Apple' => 'https://fdn2.gsmarena.com/vv/bigpic/apple-iphone-15.jpg',
    'Samsung' => 'https://fdn2.gsmarena.com/vv/bigpic/samsung-galaxy-s24-ultra.jpg',
    'Xiaomi' => 'https://fdn2.gsmarena.com/vv/bigpic/xiaomi-14.jpg'
];

// 1. MARQUES
foreach ($marques as $nom) {
    $pdo->prepare("INSERT INTO marque (nom) VALUES (?)")->execute([$nom]);
}
echo "✔ Marques insérées\n";

// 2. MODELES (20 par marque)
foreach ($marques as $i => $nom) {
    $marque_id = $i + 1;
    for ($j = 1; $j <= 20; $j++) {
        $modele = "$nom Model $j";
        $pdo->prepare("INSERT INTO modele (nom, marque_id) VALUES (?, ?)")->execute([$modele, $marque_id]);
    }
}
echo "✔ 60 modèles insérés\n";

// 3. FORFAITS
$forfaits = [
    ['Liberta 20 Go 4G/5G', 8.99, '4G', 20],
    ['Liberta 160 Go 4G/5G', 16.99, '5G', 160],
    ['Liberta 250 Go 4G/5G', 22.99, '5G', 250],
];
foreach ($forfaits as $f) {
    $pdo->prepare("INSERT INTO forfait (nom, prix, reseau, data) VALUES (?, ?, ?, ?)")
        ->execute([$f[0], $f[1], $f[2], $f[3]]);
}
echo "✔ Forfaits insérés\n";

// 4. PRODUITS : téléphones (avec image_url, stock, prix aléatoire)
foreach ($marques as $m_index => $marque) {
    for ($m = 1; $m <= 20; $m++) {
        $nom = "$marque Model $m";
        $description = "Découvrez le $nom, un smartphone performant et moderne.";
        $prix = rand(399, 1199);
        $image_url = $images[$marque];
        $modele_id = ($m_index * 20) + $m;

        $pdo->prepare("INSERT INTO produit (nom, description, prix, image_url, stock, type, marque_id, modele_id)
            VALUES (?, ?, ?, ?, ?, 'telephone', ?, ?)")
            ->execute([$nom, $description, $prix, $image_url, 10, $m_index + 1, $modele_id]);
    }
}
echo "✔ Téléphones insérés\n";

// 5. PRODUITS : forfaits
for ($i = 1; $i <= 3; $i++) {
    $forfait = $pdo->query("SELECT * FROM forfait WHERE id = $i")->fetch();
    $pdo->prepare("INSERT INTO produit (nom, description, prix, type, forfait_id, stock)
        VALUES (?, ?, ?, 'forfait', ?, 999)")
        ->execute([
            $forfait['nom'],
            "Profitez d'un forfait de " . $forfait['data'] . " Go sur le réseau " . $forfait['reseau'],
            $forfait['prix'],
            $forfait['id']
        ]);
}
echo "✔ Produits forfaits insérés\n";
?>