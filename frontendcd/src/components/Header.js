import React from "react";
import { NavLink } from "react-router-dom";
import "./Header.css";

export default function Header({ search, setSearch, panier }) {
  return (
    <nav className="main-nav">
      <NavLink to="/telephones" className="nav-link">Téléphones seuls</NavLink>
      <NavLink to="/packs" className="nav-link">Packs Téléphone + Forfait</NavLink>
      <NavLink to="/forfaits" className="nav-link">Forfaits seuls</NavLink>
      <NavLink to="/panier" className="nav-link">Panier ({panier.length})</NavLink>
      <input
        type="text"
        placeholder="Recherche..."
        value={search}
        onChange={e => setSearch(e.target.value)}
        className="search-bar"
      />
    </nav>
  );
}