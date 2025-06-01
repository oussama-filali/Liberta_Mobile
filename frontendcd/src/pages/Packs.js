import React, { useEffect, useState } from "react";

export default function Packs() {
  const [produits, setProduits] = useState([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    fetch("http://localhost/Liberta_Mobile/backend/api/produits/filtrer.php?type=telephone&pack=1")
      .then(res => res.json())
      .then(data => {
        setProduits(data);
        setLoading(false);
      });
  }, []);

  if (loading) return <p>Chargement...</p>;

  return (
    <div>
      <h2>Packs Téléphone + Forfait</h2>
      <div className="grid">
        {produits.map(produit => (
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
          </div>
        ))}
      </div>
    </div>
  );
}