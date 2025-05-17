<?php
namespace LibertaMobile\Core;

class Panier {
    public $items;

    public function __construct() {
        $this->items = json_decode($_SESSION['panier'] ?? json_encode([]), true) ?: [];
    }

    public function ajouterProduit($idProduit, $quantite) {
        $existing = array_search($idProduit, array_column($this->items, 'id'));
        if ($existing !== false) {
            $this->items[$existing]['quantite'] += $quantite;
        } else {
            $this->items[] = ['id' => $idProduit, 'quantite' => $quantite];
        }
        $_SESSION['panier'] = json_encode($this->items);
    }

    public function viderPanier() {
        $this->items = [];
        $_SESSION['panier'] = json_encode($this->items);
    }
}
?>