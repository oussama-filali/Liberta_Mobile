import React, { useEffect, useState } from "react";

export default function Telephones({ ajouterAuPanier, ajouterAuxFavoris, search }) {
  const [produits, setProduits] = useState([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    fetch("http://localhost/Liberta_Mobile/backend/api/produits/filtrer.php?type=telephone&pack=0")
      .then(res => res.json())
      .then(data => {
        setProduits(data);
        setLoading(false);
      });
  }, []);

  const produitsFiltres = produits.filter(p =>
    p.nom.toLowerCase().includes(search.toLowerCase()) ||
    (p.description && p.description.toLowerCase().includes(search.toLowerCase()))
  );

  if (loading) return <p>Chargement...</p>;

  return (
    <div>
      <h2>Téléphones seuls</h2>
      <div className="grid">
        {produitsFiltres.map(produit => (
          <div key={produit.id} className="card">
            <img
              src={`http://localhost/Liberta_Mobile/backend/api/images/${produit.image_url}`}
              alt={produit.nom}
              className="card-img"
              onError={e => { e.target.style.display = "none"; }}
            />
            <h3>{produit.nom}</h3>
            <p>{produit.description}</p>
            <p className="prix">{produit.prix} €</p>
            <button onClick={() => ajouterAuPanier(produit)}>Ajouter au panier</button>
            <button onClick={() => ajouterAuxFavoris(produit)}>Favori ★</button>
          </div>
        ))}
      </div>
    </div>
  );
}