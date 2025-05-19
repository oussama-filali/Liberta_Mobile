<?php
namespace Liberta_Mobile\Core;

class Panier {
    public $items;

    public function __construct() {
        $this->items = json_decode($_SESSION['panier'] ?? json_encode([]), true) ?: [];
    }

    public function ajouterProduit($id, $quantite) {
        foreach ($this->items as &$item) {
            if ($item['id'] === $id) {
                $item['quantite'] += $quantite;
                $_SESSION['panier'] = json_encode($this->items);
                return;
            }
        }

        // récupérer depuis DB ?
        // simplifié ici (à enrichir si besoin)
        $this->items[] = ['id' => $id, 'nom' => 'Produit #' . $id, 'prix' => 10, 'quantite' => $quantite];
        $_SESSION['panier'] = json_encode($this->items);
    }

    public function viderPanier() {
        $this->items = [];
        $_SESSION['panier'] = json_encode([]);
    }
}
