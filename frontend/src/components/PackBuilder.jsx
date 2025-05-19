// frontend/src/components/PackBuilder.jsx
import React, { useEffect, useState } from 'react';
import { fetchProduits } from '../utils/api';
import './PackBuilder.css';

export default function PackBuilder() {
  const [etape, setEtape] = useState(1);
  const [forfaits, setForfaits] = useState([]);
  const [telephones, setTelephones] = useState([]);
  const [selectedForfait, setSelectedForfait] = useState(null);
  const [selectedPhone, setSelectedPhone] = useState(null);

  useEffect(() => {
    async function load() {
      try {
        const dataForfaits = await fetchProduits({ type: 'forfait' });
        setForfaits(dataForfaits);
        const dataPhones = await fetchProduits({ type: 'telephone' });
        setTelephones(dataPhones);
      } catch (e) {
        console.error(e);
      }
    }
    load();
  }, []);

  function choisirForfait(f) {
    setSelectedForfait(f);
    setEtape(2);
    window.scrollTo({ top: 0, behavior: 'smooth' });
  }

  function choisirPhone(p) {
    setSelectedPhone(p);
    setEtape(3);
    window.scrollTo({ top: 0, behavior: 'smooth' });
  }

  function ajouterPack() {
    const cart = JSON.parse(localStorage.getItem('panier')) || [];
    cart.push(
      { id: selectedForfait.id, nom: selectedForfait.nom, prix: selectedForfait.prix, quantite: 1 },
      { id: selectedPhone.id, nom: selectedPhone.nom, prix: selectedPhone.prix, quantite: 1 }
    );
    localStorage.setItem('panier', JSON.stringify(cart));
    alert('Pack ajouté au panier !');
    window.location.href = '/LIBERTA_MOBILE/?page=panier';
  }

  return (
    <section className="container pack-builder">
      <h2 className="text-center">Créer votre Pack</h2>

      {etape === 1 && (
        <>
          <h3>1. Choisissez votre forfait</h3>
          <div className="grid">
            {forfaits.map((f) => (
              <div key={f.id} className="card">
                <h4>{f.nom}</h4>
                <p className="price">{parseFloat(f.prix).toFixed(2)} €</p>
                <button className="btn" onClick={() => choisirForfait(f)}>
                  Sélectionner
                </button>
              </div>
            ))}
          </div>
        </>
      )}

      {etape === 2 && (
        <>
          <h3>2. Choisissez votre téléphone</h3>
          <div className="grid">
            {telephones.map((p) => (
              <div key={p.id} className="card">
                <img
                  src={`/LIBERTA_MOBILE/public/images/${p.image_url}`}
                  alt={p.nom}
                />
                <h4>{p.nom}</h4>
                <p className="price">{parseFloat(p.prix).toFixed(2)} €</p>
                <button className="btn" onClick={() => choisirPhone(p)}>
                  Sélectionner
                </button>
              </div>
            ))}
          </div>
        </>
      )}

      {etape === 3 && (
        <div className="recap">
          <h3>Votre Pack</h3>
          <p>
            <strong>Forfait : </strong>
            {selectedForfait.nom} ({parseFloat(selectedForfait.prix).toFixed(2)} €)
          </p>
          <p>
            <strong>Téléphone : </strong>
            {selectedPhone.nom} ({parseFloat(selectedPhone.prix).toFixed(2)} €)
          </p>
          <button className="btn btn-large" onClick={ajouterPack}>
            Ajouter le pack au panier
          </button>
        </div>
      )}
    </section>
  );
}
