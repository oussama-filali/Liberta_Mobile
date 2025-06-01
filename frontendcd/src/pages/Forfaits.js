import React, { useEffect, useState } from "react";

export default function Forfaits() {
  const [forfaits, setForfaits] = useState([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    fetch("http://localhost/Liberta_Mobile/backend/api/produits/filtrer.php?type=forfait")
      .then(res => res.json())
      .then(data => {
        setForfaits(data);
        setLoading(false);
      });
  }, []);

  if (loading) return <p>Chargement...</p>;

  return (
    <div>
      <h2>Forfaits seuls</h2>
      <div className="grid">
        {forfaits.map(forfait => (
          <div key={forfait.id} className="card">
            <h3>{forfait.nom}</h3>
            <p>{forfait.description}</p>
            <p className="prix">{forfait.prix} €</p>
          </div>
        ))}
      </div>
    </div>
  );
}