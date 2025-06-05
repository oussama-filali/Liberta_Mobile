<?php

include_once '../config/database.php';
include_once '../models/Product.php';

class ProductController {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect();
    }

    // GET all products
    public function getProducts() {
        $query = 'SELECT * FROM products';
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($products);
    }

    // POST new product (admin)
    public function createProduct($data) {
        $query = 'INSERT INTO products (name, description, price, image, category) VALUES (:name, :description, :price, :image, :category)';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':description', $data['description']);
        $stmt->bindParam(':price', $data['price']);
        $stmt->bindParam(':image', $data['image']);
        $stmt->bindParam(':category', $data['category']);

        if ($stmt->execute()) {
            echo json_encode(['message' => 'Product created']);
        } else {
            echo json_encode(['message' => 'Error while creating product']);
        }
    }
}
