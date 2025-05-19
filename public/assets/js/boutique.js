document.addEventListener('DOMContentLoaded', () => {
  const grid = document.getElementById('product-grid');
  const buttons = document.querySelectorAll('.filter-btn');
  let allProducts = [];

  async function fetchProducts() {
    try {
      const res = await fetch('/LIBERTA_MOBILE/api/produits.php');
      allProducts = await res.json();
      render(allProducts);
    } catch (err) {
      console.error("Erreur récupération produits", err);
      grid.innerHTML = '<p>Erreur lors du chargement.</p>';
    }
  }

  function render(products) {
    grid.innerHTML = '';
    if (products.length === 0) {
      grid.innerHTML = '<p>Aucun produit trouvé.</p>';
      return;
    }

    products.forEach(p => {
      const card = document.createElement('div');
      card.className = 'card';

      card.innerHTML = `
        <img src="/LIBERTA_MOBILE/public/images/${p.image_url || 'default.jpg'}" alt="${p.nom}">
        <div class="content">
          <h3>${p.nom}</h3>
          <p>${p.description || ''}</p>
          <p class="price">${parseFloat(p.prix).toFixed(2)} €</p>
          <a href="?page=produit&id=${p.id}">Voir détails</a>
        </div>
      `;

      grid.appendChild(card);
    });
  }

  // Filtres
  buttons.forEach(btn => {
    btn.addEventListener('click', () => {
      const type = btn.dataset.type;
      const filtered = type === 'pack'
        ? allProducts.filter(p => p.type === 'telephone' && p.forfait_id !== null)
        : type
        ? allProducts.filter(p => p.type === type)
        : allProducts;
      render(filtered);
    });
  });

  fetchProducts();
});
