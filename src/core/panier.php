<?php
// src/Core/Panier.php

namespace Liberta_Mobile\Core;

class Panier {
    public $items;

    public function __construct() {
        $this->items = json_decode($_SESSION['panier'] ?? json_encode([]), true) ?: [];
    }

    public function ajouterProduit($idProduit, $quantite) {
        $exist = array_search($idProduit, array_column($this->items, 'id'));
        if ($exist !== false) {
            $this->items[$exist]['quantite'] += $quantite;
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
