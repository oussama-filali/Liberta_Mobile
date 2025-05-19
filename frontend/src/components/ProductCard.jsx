// frontend/src/components/ProductCard.jsx
import React from 'react';
import './ProductCard.css';

export default function ProductCard({ produit }) {
  const { id, nom, description, prix, image_url } = produit;
  return (
    <div className="card">
      <img
        src={`/LIBERTA_MOBILE/public/images/${image_url || 'default.jpg'}`}
        alt={nom}
      />
      <div className="content">
        <h3>{nom}</h3>
        <p>{description}</p>
        <p className="price">{parseFloat(prix).toFixed(2)} €</p>
        <a href={`?page=produit&id=${id}`} className="btn-small">
          Voir détails
        </a>
      </div>
    </div>
  );
}
