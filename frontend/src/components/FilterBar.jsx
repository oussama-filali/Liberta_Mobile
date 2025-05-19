// frontend/src/components/FilterBar.jsx
import React from 'react';
import './FilterBar.css';

export default function FilterBar({ selectedType, onChangeType }) {
  return (
    <div className="filters">
      {[
        { label: 'Tous', value: '' },
        { label: 'Téléphones seuls', value: 'telephone' },
        { label: 'Forfaits seuls', value: 'forfait' },
        { label: 'Packs Téléphone + Forfait', value: 'pack' },
      ].map((f) => (
        <button
          key={f.value}
          className={`filter-btn ${selectedType === f.value ? 'active' : ''}`}
          onClick={() => onChangeType(f.value)}
        >
          {f.label}
        </button>
      ))}
    </div>
  );
}
