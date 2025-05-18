const searchInput = document.getElementById('search');
if (searchInput) {
    searchInput.addEventListener('input', async (e) => {
        const query = e.target.value;
        if (query.length < 3) {
            document.getElementById('suggestions')?.remove();
            return;
        }
        try {
            const response = await fetch('/LIBERTA_MOBILE/api/produits.php?search=' + encodeURIComponent(query));
            const suggestions = await response.json();
            let suggestionBox = document.getElementById('suggestions');
            if (suggestionBox) suggestionBox.remove();
            suggestionBox = document.createElement('div');
            suggestionBox.id = 'suggestions';
            suggestionBox.className = 'absolute bg-white border p-2 mt-1 w-full rounded shadow-lg';
            suggestions.forEach(s => {
                const div = document.createElement('div');
                div.textContent = s.nom;
                div.className = 'p-2 hover:bg-gray-100 cursor-pointer rounded';
                div.onclick = () => window.location.href = `?page=produit&id=${s.id}`;
                suggestionBox.appendChild(div);
            });
            searchInput.parentNode.appendChild(suggestionBox);
        } catch (error) {
            console.error('Erreur recherche :', error);
        }
    });
}

class Panier {
    constructor() {
        this.items = JSON.parse(localStorage.getItem('panier')) || [];
    }

    async ajouterProduit(idProduit, quantite) {
        const response = await fetch('/LIBERTA_MOBILE/api/produits.php?id=' + idProduit);
        const produit = await response.json();
        const existing = this.items.find(item => item.id === idProduit);
        if (existing) existing.quantite += quantite;
        else this.items.push({ id: produit.id, nom: produit.nom, prix: produit.prix, quantite });
        localStorage.setItem('panier', JSON.stringify(this.items));
    }

    viderPanier() {
        this.items = [];
        localStorage.setItem('panier', JSON.stringify(this.items));
    }
}

const stripe = Stripe('pk_test_votre_cle_publique');
const panier = new Panier();

async function procederPaiement() {
    try {
        const response = await fetch('/LIBERTA_MOBILE/api/creer-session-paiement.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(panier.items)
        });
        const session = await response.json();
        await stripe.redirectToCheckout({ sessionId: session.id });
    } catch (error) {
        console.error('Erreur paiement :', error);
        alert('Erreur lors du paiement');
    }
}
let index = 0;
const slides = document.querySelectorAll('.carousel-image');
setInterval(() => {
    slides.forEach((img, i) => img.classList.toggle('active', i === index));
    index = (index + 1) % slides.length;
}, 3000);
