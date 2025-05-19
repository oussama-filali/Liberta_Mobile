// frontend/src/utils/api.js

const API_BASE = '/LIBERTA_MOBILE/api';

export async function fetchProduits(filters = {}) {
  // Exemple : filters = { type: 'forfait' } ou { type: 'telephone' }
  const params = new URLSearchParams(filters).toString();
  const url = API_BASE + '/produits.php' + (params ? `?${params}` : '');
  const res = await fetch(url);
  if (!res.ok) throw new Error('Erreur API : ' + res.status);
  return res.json();
}

export async function fetchProduitById(id) {
  const res = await fetch(`${API_BASE}/produits.php?id=${id}`);
  if (!res.ok) throw new Error('Erreur API : ' + res.status);
  return res.json();
}

export async function searchProduits(query) {
  const res = await fetch(`${API_BASE}/produits.php?search=${encodeURIComponent(query)}`);
  if (!res.ok) throw new Error('Erreur API : ' + res.status);
  return res.json();
}

export async function createCheckoutSession(cartItems) {
  const res = await fetch(`${API_BASE}/creer-session-paiement.php`, {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(cartItems),
  });
  if (!res.ok) {
    const body = await res.json();
    throw new Error(body.error || 'Erreur création session Stripe');
  }
  return res.json();
}
