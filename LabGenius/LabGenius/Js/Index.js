/* ui : Gère l'architecture SPA et les interactions globales*/
const ui = {
    init() {
        // Gestion de la navigation par onglets (SPA)
        document.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', (e) => {
                e.preventDefault();
                const target = link.getAttribute('data-section');
                
                // Switch visuel des liens
                document.querySelectorAll('.nav-link').forEach(l => l.classList.remove('active'));
                link.classList.add('active');
                
                // Switch des sections
                document.querySelectorAll('.section').forEach(s => {
                    s.classList.remove('active');
                    if(s.id === target) s.classList.add('active');
                });
            });
        });

        // Toggle du mode clair/sombre
        document.getElementById('themeToggle').addEventListener('click', () => {
            document.documentElement.classList.toggle('light');
        });
    },

    // Système de notification flottante
    showToast(message) {
        const t = document.getElementById('toast');
        document.getElementById('toastMessage').innerText = message;
        t.classList.add('show');
        setTimeout(() => t.classList.remove('show'), 3000);
    }
};

// Lancement de l'interface au chargement du DOM
document.addEventListener('DOMContentLoaded', () => ui.init());