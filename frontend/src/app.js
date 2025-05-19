// frontend/src/App.js
import React from 'react';
import { BrowserRouter, Routes, Route, Navigate } from 'react-router-dom';

import BoutiquePage from './components/BoutiquePage';
import PackBuilder from './components/PackBuilder';
import Header from './components/Header';
import Footer from './components/Footer';

function App() {
  return (
    <BrowserRouter>
      <Header />
      <Routes>
        <Route path="/" element={<Navigate to="/boutique" replace />} />
        <Route path="/boutique" element={<BoutiquePage />} />
        <Route path="/pack" element={<PackBuilder />} />
        {/* Tu peux ajouter d'autres routes React ici si besoin */}
      </Routes>
      <Footer />
    </BrowserRouter>
  );
}

export default App;
