import React from "react";

export default function Panier({ panier, setPanier }) {
  const total = panier.reduce((sum, p) => sum + Number(p.prix), 0);

  // Retirer un produit du panier
  const retirerDuPanier = (index) => {
    setPanier((prev) => prev.filter((_, i) => i !== index));
  };

  // Paiement Stripe
  async function payerAvecStripe() {
    const res = await fetch("http://localhost/Liberta_Mobile/backend/api/vendor/stripe/create-checkout-session.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({
        produits: panier.map(p => ({
          nom: p.nom,
          prix: p.prix,
          quantite: 1
        }))
      })
    });
    const data = await res.json();
    if (data.url) window.location.href = data.url;
  }

  return (
    <div>
      <h2>Votre panier</h2>
      {panier.length === 0 ? (
        <p>Votre panier est vide.</p>
      ) : (
        <>
          <ul>
            {panier.map((p, i) => (
              <li key={i} style={{ marginBottom: "1rem" }}>
                <strong>{p.nom}</strong> - {p.prix} €
                <button
                  style={{
                    marginLeft: "1rem",
                    background: "#e60000",
                    color: "#fff",
                    border: "none",
                    borderRadius: "5px",
                    padding: "0.3rem 0.7rem",
                    cursor: "pointer"
                  }}
                  onClick={() => retirerDuPanier(i)}
                >
                  Retirer
                </button>
              </li>
            ))}
          </ul>
          <p style={{ fontWeight: "bold" }}>Total : {total} €</p>
          <button className="btn-stripe" onClick={payerAvecStripe}>
            Payer avec Stripe
          </button>
        </>
      )}
    </div>
  );
}