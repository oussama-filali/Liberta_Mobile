// frontend/src/components/Header.jsx
import React from 'react';
import { Link, useLocation } from 'react-router-dom';
import './Header.css'; // on va créer ce CSS

function Header() {
  const location = useLocation();
  return (
    <header className="header">
      <div className="container header-container">
        <h1 className="logo"><Link to="/boutique">Liberta Mobile</Link></h1>
        <nav className="nav">
          <Link to="/boutique" className={location.pathname === '/boutique' ? 'active' : ''}>
            Boutique
          </Link>
          <Link to="/pack" className={location.pathname === '/pack' ? 'active' : ''}>
            Créer un Pack
          </Link>
          <Link to="/boutique" className="btn-small">Panier</Link>
          <a href="?page=profil&action=login" onClick={(e) => { e.preventDefault(); window.toggleModal(); }}>
            <img src="/LIBERTA_MOBILE/public/assets/icons/user.svg" alt="Connexion" width="24" />
          </a>
        </nav>
      </div>
    </header>
  );
}

export default Header;
