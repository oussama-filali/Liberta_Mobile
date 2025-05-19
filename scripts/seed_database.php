<?php
require_once __DIR__ . '/../src/config/database.php';
use Liberta_Mobile\Config\Database;

$db = new Database();
$pdo = $db->getPdo();

// --- Marques
$marques = ['Apple', 'Samsung', 'Xiaomi'];
foreach ($marques as $marque) {
    $pdo->prepare("INSERT INTO marque (nom) VALUES (?)")->execute([$marque]);
}
echo "✔ Marques insérées\n";

// --- Modèles par marque
$modeleData = [
    'Apple' => [
        'iPhone 16 Pro Titane Sable',
        'iPhone 16 Noir',
        'iPhone 16e Noir',
        'iPhone 15 Noir'
    ],
    'Samsung' => [
        'Galaxy S25 Ultra Bleu Titane',
        'Galaxy S25 Edge Noir Absolu',
        'Galaxy S24 Noir',
        'Galaxy A56 5G Graphite'
    ],
    'Xiaomi' => [
        '14 Pro',
        'Redmi Note 14 Pro 5G Noir',
        '15 Ultra Chrome',
        '15 5G Noir',
        '14T Noir',
        '14',
        '15 Ultra Pack Photo Pro'
    ]
];

$model_id_map = [];
foreach ($modeleData as $marque => $modeles) {
    $marque_id = array_search($marque, $marques) + 1;
    foreach ($modeles as $nom) {
        $pdo->prepare("INSERT INTO modele (nom, marque_id) VALUES (?, ?)")->execute([$nom, $marque_id]);
        $model_id_map[$nom] = $pdo->lastInsertId();
    }
}
echo "✔ Modèles insérés\n";

// --- Forfaits
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

// --- Produits : téléphones
$produits = [
    ['Apple', 'iPhone 16 Pro Titane Sable', 'iphone-16-pro.jpg', 1399],
    ['Apple', 'iPhone 16 Noir', 'iphone-16.jpg', 1199],
    ['Apple', 'iPhone 16e Noir', 'iphone-16e.jpg', 999],
    ['Apple', 'iPhone 15 Noir', 'iphone-15.jpg', 899],
    ['Samsung', 'Galaxy S25 Ultra Bleu Titane', 'galaxy-s25-ultra.jpg', 1399],
    ['Samsung', 'Galaxy S25 Edge Noir Absolu', 'galaxy-s25-edge.jpg', 1299],
    ['Samsung', 'Galaxy S24 Noir', 'galaxy-s24.jpg', 1099],
    ['Samsung', 'Galaxy A56 5G Graphite', 'galaxy-a56.jpg', 699],
    ['Xiaomi', '14 Pro', 'xiaomi-14-pro.jpg', 899],
    ['Xiaomi', 'Redmi Note 14 Pro 5G Noir', 'xiaomi-redmi-note14-pro-5g.jpg', 399],
    ['Xiaomi', '15 Ultra Chrome', 'xiaomi-15-ultra.jpg', 999],
    ['Xiaomi', '15 5G Noir', 'xiaomi-15-5g.jpg', 849],
    ['Xiaomi', '14T Noir', 'xiaomi-14t.jpg', 749],
    ['Xiaomi', '14', 'xiaomi-14.jpg', 799],
    ['Xiaomi', '15 Ultra Pack Photo Pro', 'xiaomi-15-ultra-pack.jpg', 1199],
];

foreach ($produits as [$marque, $modele_nom, $image, $prix]) {
    $marque_id = array_search($marque, $marques) + 1;
    $modele_id = $model_id_map[$modele_nom];
    $nom = "$modele_nom";
    $desc = "Découvrez le $nom avec des performances exceptionnelles.";
    $pdo->prepare("INSERT INTO produit (nom, description, prix, image_url, stock, type, marque_id, modele_id)
        VALUES (?, ?, ?, ?, ?, 'telephone', ?, ?)")
        ->execute([$nom, $desc, $prix, $image, 20, $marque_id, $modele_id]);
}
echo "✔ Produits téléphones insérés\n";

// --- Produits : forfaits seuls
$forfaitsDB = $pdo->query("SELECT * FROM forfait")->fetchAll(PDO::FETCH_ASSOC);
foreach ($forfaitsDB as $f) {
    $desc = "Forfait " . $f['data'] . " Go en " . $f['reseau'] . ", appels/SMS illimités.";
    $pdo->prepare("INSERT INTO produit (nom, description, prix, image_url, stock, type, forfait_id)
        VALUES (?, ?, ?, ?, ?, 'forfait', ?)")
        ->execute([$f['nom'], $desc, $f['prix'], 'forfait.jpg', 999, $f['id']]);
}
echo "✔ Produits forfaits seuls insérés\n";
