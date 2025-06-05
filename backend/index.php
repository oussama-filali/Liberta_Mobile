<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json');

include_once '../controllers/ProductController.php';
include_once '../controllers/UserController.php';

$productController = new ProductController();
$userController = new UserController();

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        $productController->getProducts();
        break;
    case 'POST':
        $input = json_decode(file_get_contents("php://input"), true);
        
        if ($_GET['action'] == 'createProduct') {
            $productController->createProduct($input);
        } elseif ($_GET['action'] == 'register') {
            $userController->registerUser($input);
        } elseif ($_GET['action'] == 'login') {
            $userController->loginUser($input);
        } else {
            http_response_code(400);
            echo json_encode(['message' => 'Invalid action']);
        }
        break;
    default:
        http_response_code(405);
        echo json_encode(['message' => 'Method not allowed']);
        break;
}
