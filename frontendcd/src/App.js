import React, { useState } from "react";
import { BrowserRouter, Routes, Route } from "react-router-dom";
import Header from "./components/Header";
import Telephones from "./pages/Telephones";
import Packs from "./pages/Packs";
import Forfaits from "./pages/Forfaits";
import Panier from "./pages/Panier";
import "./App.css";

function App() {
  const [panier, setPanier] = useState([]);
  const [favoris, setFavoris] = useState([]);
  const [search, setSearch] = useState("");

  // Ajout au panier
  const ajouterAuPanier = (produit) => {
    setPanier((prev) => [...prev, produit]);
  };

  // Ajout aux favoris
  const ajouterAuxFavoris = (produit) => {
    setFavoris((prev) => [...prev, produit]);
  };

  return (
    <BrowserRouter>
      <Header search={search} setSearch={setSearch} panier={panier} />
      <div className="container">
        <Routes>
          <Route path="/" element={<Home />} />
          <Route
            path="/telephones"
            element={
              <Telephones
                ajouterAuPanier={ajouterAuPanier}
                ajouterAuxFavoris={ajouterAuxFavoris}
                search={search}
              />
            }
          />
          <Route
            path="/packs"
            element={
              <Packs
                ajouterAuPanier={ajouterAuPanier}
                ajouterAuxFavoris={ajouterAuxFavoris}
                search={search}
              />
            }
          />
          <Route
            path="/forfaits"
            element={
              <Forfaits
                ajouterAuPanier={ajouterAuPanier}
                ajouterAuxFavoris={ajouterAuxFavoris}
                search={search}
              />
            }
          />
          <Route path="/panier" element={<Panier panier={panier} setPanier={setPanier} />} />
        </Routes>
      </div>
    </BrowserRouter>
  );
}

function Home() {
  return (
    <div className="home">
      <h1>Bienvenue sur Liberta Mobile</h1>
      <p>Choisissez une catégorie dans le menu ci-dessus.</p>
    </div>
  );
}

export default App;
