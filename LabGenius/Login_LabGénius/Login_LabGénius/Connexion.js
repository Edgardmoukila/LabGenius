/* ── Bascule tabs ── */
    function switchTab(tab) {
        document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
        document.querySelectorAll('.form-panel').forEach(p => p.classList.remove('active'));
        document.getElementById('tab-' + tab).classList.add('active');
        document.getElementById('panel-' + tab).classList.add('active');
        hideFeedback();
    }

    /* ── Feedback ── */
    function showFeedback(msg, type) {
        const el = document.getElementById('feedback');
        el.textContent = msg;
        el.className = 'msg ' + type + ' visible';
    }

    function hideFeedback() {
        document.getElementById('feedback').className = 'msg';
    }

    /* ── Soumission ── */
    function handleSubmit(e, type) {
        e.preventDefault();
        hideFeedback();

        const btn      = document.getElementById(type === 'login' ? 'login-btn' : 'register-btn');
        const spinner  = document.getElementById(type === 'login' ? 'login-spinner' : 'register-spinner');
        const btnText  = btn.querySelector('.btn-text');

        btnText.style.display = 'none';
        spinner.style.display = 'block';
        btn.disabled = true;

        setTimeout(() => {
            spinner.style.display = 'none';
            btnText.style.display = '';
            btn.disabled = false;

            if (type === 'login') {
                const email = document.getElementById('login-email').value;
                let role = 'client';
                if (email === 'admin@tala.com')          role = 'admin';
                else if (email === 'sponsor@partenaire.com') role = 'sponsor';

                showFeedback('Connexion réussie ! Redirection en tant que ' + role + '…', 'success');
                setTimeout(() => {
                    const dest = role === 'admin' ? 'index.html' : role === 'sponsor' ? 'partner-dashboard.html' : 'client-dashboard.html';
                    // window.location.href = dest;
                }, 1500);
            } else {
                showFeedback('Compte créé avec succès ! Bienvenue sur TalaVoyage 🌍', 'success');
            }
        }, 2000);
    }