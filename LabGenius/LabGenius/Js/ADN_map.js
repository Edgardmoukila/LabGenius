const dnaEngine = {
    async call(action, sequence) {
        const fd = new FormData();
        fd.append('action', action);
        fd.append('sequence', sequence);

        try {
            const response = await fetch('Php/ADN_map.php', { 
                method: 'POST', 
                body: fd 
            });

            if (!response.ok) throw new Error("Réponse serveur non valide");

            const data = await response.json();
            if (data.status === 'error') {
                ui.showToast(data.message);
                return null;
            }
            return data;
        } catch (error) {
            console.error("Erreur de communication :", error);
            ui.showToast("Erreur : Impossible de joindre le serveur.");
            return null;
        }
    },

    // Bouton de sauvegarde (Dashboard)
    async saveSequence() {
        const input = document.getElementById('dnaInput').value;
        if(!input) return ui.showToast("Séquence vide !");
        
        const data = await this.call('save', input);
        if (data) {
            document.getElementById('statDna').innerText = input.substring(0, 10) + "...";
            document.getElementById('statGC').innerText = data.stats.gc + "%";
            document.getElementById('statAT').innerText = data.stats.at + "%";
            ui.showToast("Séquence enregistrée.");
        }
    },

    // Boutons de manipulation (Séquenceur)
    async runAction(type) {
        const input = document.getElementById('dnaInput').value;
        if(!input) return ui.showToast("Saisissez une séquence.");

        const data = await this.call(type, input);
        if (data && data.result) {
            const container = document.getElementById("res-" + type);
            let h = `<p class="hint"><b>${data.label} :</b></p><div class="dna-sequence">`;
            for (let b of data.result) {
                h += `<span class="base-pill base-${b.toLowerCase()}">${b}</span>`;
            }
            container.innerHTML = h + "</div>";
        }
    },

    // Machine de synthèse (Synthèse)
    async startSynthesis() {
        const target = document.getElementById('targetSeqDisplay').innerText;
        if (target === "Aucune" || target === "") return ui.showToast("Chargez une cible.");

        const btn = document.getElementById('startSynth');
        const bar = document.getElementById('progressBar');
        const pctText = document.getElementById('syncPercent');
        const report = document.getElementById('synthReport');
        
        btn.disabled = true;
        let progress = 0;
        report.innerHTML = "";

        const response = await this.call('run_synthesis', target);

        const timer = setInterval(() => {
            if (progress >= 100) {
                clearInterval(timer);
                btn.disabled = false;
                const d = response.data;
                const color = d.status === "SUCCESS" ? "var(--a2)" : "#ff5f5f";
                report.innerHTML = `
                    <div class='box' style='border-color:${color}; margin-top:15px'>
                        <h4 style='color:${color}'>${d.status === "SUCCESS" ? "✅" : "❌"} ${d.status} (${d.purity}%)</h4>
                        <p>${d.msg}</p>
                    </div>`;
            } else {
                progress++;
                bar.style.width = progress + "%";
                pctText.innerText = progress;
            }
        }, 20);
    },

    // Charger la session dans la synthèse
    async loadForSynthesis() {
        const data = await this.call('get_session', '');
        if (data && data.sequence) {
            document.getElementById('targetSeqDisplay').innerText = data.sequence;
            ui.showToast("Données chargées.");
        }
    },

    // Bibliothèque
    importLib(seq) {
        document.getElementById('dnaInput').value = seq;
        ui.showToast("Séquence importée.");
        document.querySelector('[data-section="sequencer"]').click();
    }
};