// frontend/src/components/Footer.jsx
import React from 'react';
import './Footer.css';

function Footer() {
  return (
    <footer className="footer">
      © {new Date().getFullYear()} Liberta Mobile. Tous droits réservés.
    </footer>
  );
}

export default Footer;
