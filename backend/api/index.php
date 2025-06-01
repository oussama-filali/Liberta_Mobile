<?php
// backend/api/routes/index.php
require_once '../middleware/cors.php';
require_once '../config/Database.php';
require_once '../controller/ProduitController.php';

$db = (new Database())->connect();
$controller = new ProduitController($db);

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if (preg_match('#/api/produits/?$#', $uri)) {
    $controller->getAllProduits();
} elseif (preg_match('#/api/produits/(\d+)$#', $uri, $matches)) {
    $controller->getProduit($matches[1]);
} else {
    http_response_code(404);
    echo json_encode(["message" => "Route non trouvée"]);
}
