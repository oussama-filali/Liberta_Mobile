<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json');

include_once '../controllers/ProductController.php';

$controller = new ProductController();

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        $controller->getProducts();
        break;
    case 'POST':
        $input = json_decode(file_get_contents("php://input"), true);
        $controller->createProduct($input);
        break;
    default:
        http_response_code(405);
        echo json_encode(['message' => 'Method not allowed']);
        break;
}
