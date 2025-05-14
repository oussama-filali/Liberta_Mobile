document.addEventListener('DOMContentLoaded', () => {
    const app = document.getElementById('app');

    // Afficher la page de connexion
    const renderLogin = () => {
        app.innerHTML = `
            <div class="login-container">
                <h1>Connexion à votre Espace Client</h1>
                <form id="login-form" autocomplete="off">
                    <input type="email" id="email" placeholder="Adresse e-mail" required>
                    <input type="password" id="password" placeholder="Mot de passe" required>
                    <button type="submit">Se connecter</button>
                </form>
                <p id="error-message" class="error"></p>
                <p style="margin-top:18px;">Pas encore de compte ? <a href="#" id="to-register">Créer un compte</a></p>
            </div>
        `;

        document.getElementById('login-form').addEventListener('submit', async (e) => {
            e.preventDefault();
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;

            const response = await fetch('/api/login.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ email, password }),
            });

            const result = await response.json();
            if (result.success) {
                renderProducts();
            } else {
                document.getElementById('error-message').textContent = result.message;
            }
        });

        document.getElementById('to-register').onclick = (e) => {
            e.preventDefault();
            renderRegister();
        };
    };

    // Afficher la page d'inscription
    const renderRegister = () => {
        app.innerHTML = `
            <div class="register-container">
                <h1>Créer votre compte Liberta</h1>
                <form id="register-form" autocomplete="off">
                    <input type="text" id="nom" placeholder="Nom" required>
                    <input type="text" id="prenom" placeholder="Prénom" required>
                    <input type="date" id="date_naissance" placeholder="Date de naissance" required>
                    <input type="email" id="email" placeholder="Adresse e-mail" required>
                    <input type="password" id="password" placeholder="Créer un mot de passe" required>
                    <button type="submit">S'inscrire</button>
                </form>
                <p id="register-error-message" class="error"></p>
                <p style="margin-top:18px;">Déjà inscrit ? <a href="#" id="to-login">Se connecter</a></p>
            </div>
        `;

        document.getElementById('register-form').addEventListener('submit', async (e) => {
            e.preventDefault();
            const nom = document.getElementById('nom').value;
            const prenom = document.getElementById('prenom').value;
            const date_naissance = document.getElementById('date_naissance').value;
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;

            const response = await fetch('/api/register.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ nom, prenom, date_naissance, email, password }),
            });

            const result = await response.json();
            if (result.success) {
                alert('Inscription réussie ! Connectez-vous.');
                renderLogin();
            } else {
                document.getElementById('register-error-message').textContent = result.message;
            }
        });

        document.getElementById('to-login').onclick = (e) => {
            e.preventDefault();
            renderLogin();
        };
    };

    // Afficher les produits après connexion
    const renderProducts = async () => {
        const response = await fetch('/api/produits.php');
        const produits = await response.json();

        app.innerHTML = `
            <div class="products-container">
                <h1>Nos Offres Mobiles</h1>
                <div class="products-grid">
                    ${produits.map(produit => `
                        <div class="product-card">
                            <img src="/public/images/${produit.image_url}" alt="${produit.nom}">
                            <h2>${produit.nom}</h2>
                            <p>${produit.prix} €</p>
                        </div>
                    `).join('')}
                </div>
            </div>
        `;
    };

    // Afficher la page de connexion au chargement
    renderLogin();
});
