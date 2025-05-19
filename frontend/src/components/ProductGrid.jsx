// frontend/src/components/ProductGrid.jsx
import React, { useState, useEffect } from 'react';
import { fetchProduits } from '../utils/api';
import ProductCard from './ProductCard';
import FilterBar from './FilterBar';
import './ProductGrid.css';

export default function ProductGrid() {
  const [produits, setProduits] = useState([]);
  const [filtered, setFiltered] = useState([]);
  const [filterType, setFilterType] = useState('');

  useEffect(() => {
    async function load() {
      try {
        // Récupère TOUS les produits
        const data = await fetchProduits();
        setProduits(data);
        setFiltered(data);
      } catch (e) {
        console.error(e);
      }
    }
    load();
  }, []);

  useEffect(() => {
    if (!filterType) {
      setFiltered(produits);
    } else if (filterType === 'pack') {
      setFiltered(
        produits.filter((p) => p.type === 'telephone' && p.forfait_id !== null)
      );
    } else {
      setFiltered(produits.filter((p) => p.type === filterType));
    }
  }, [filterType, produits]);

  return (
    <section className="container">
      <h2>Notre Boutique</h2>
      <FilterBar selectedType={filterType} onChangeType={setFilterType} />

      <div className="grid-cards">
        {filtered.length === 0 ? (
          <p>Aucun produit trouvé.</p>
        ) : (
          filtered.map((p) => <ProductCard key={p.id} produit={p} />)
        )}
      </div>
    </section>
  );
}
