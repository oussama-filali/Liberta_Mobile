<?php
require_once '../models/Produit.php';

class ProduitController {
    private $produit;

    public function __construct($db) {
        $this->produit = new Produit($db);
    }

    public function getAllProduits() {
        $stmt = $this->produit->getAll();
        $produits = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($produits);
    }

    public function getProduit($id) {
        $produit = $this->produit->getById($id);
        if ($produit) {
            echo json_encode($produit);
        } else {
            http_response_code(404);
            echo json_encode(["message" => "Produit non trouvé"]);
        }
    }
}
