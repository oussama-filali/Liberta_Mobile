<?php

include_once '../config/database.php';
include_once '../models/User.php';

class UserController {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect();
    }

    public function registerUser($data) {
        $query = 'INSERT INTO users (email, password, full_name) VALUES (:email, :password, :full_name)';
        $stmt = $this->conn->prepare($query);

        // Hasher le mot de passe (toujours sécuriser le stockage des passwords !)
        $hashed_password = password_hash($data['password'], PASSWORD_DEFAULT);

        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':password', $hashed_password);
        $stmt->bindParam(':full_name', $data['full_name']);

        if ($stmt->execute()) {
            echo json_encode(['message' => 'User registered']);
        } else {
            echo json_encode(['message' => 'Error while registering user']);
        }
    }

    public function loginUser($data) {
        $query = 'SELECT * FROM users WHERE email = :email';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $data['email']);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($data['password'], $user['password'])) {
            echo json_encode(['message' => 'Login successful', 'user' => $user]);
        } else {
            echo json_encode(['message' => 'Invalid credentials']);
        }
    }
}
