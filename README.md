# LabGenius
Ceci est un travail réalisé par un trio d'étudiants en informatique portant sur le thème de la synthèse génétique.
1. LabGenius : Simulateur de Laboratoire Génétique

LabGenius est une application web interactive conçue pour simuler la manipulation de séquences ADN. Ce projet démontre l'utilisation de technologies Web modernes pour résoudre des problématiques de bio-informatique simples.

2. Fonctionnalités
- Dashboard de Session : Analyse en temps réel du taux de GC (Guanine-Cytosine) et AT (Adénine-Thymine).
- Éditeur Séquenceur : 
    * Mutation : Simule une erreur de réplication sur une base aléatoire.
    * Transcription : Convertit l'ADN en ARNm (Thymine ➔ Uracile).
    * Complémentarité : Calcule le brin d'ADN opposé (A-T, C-G).
    * Unité de Synthèse : Simulation de production moléculaire avec calcul de stabilité thermique et rapport de pureté.
    * Bibliothèque : Séquences pré-enregistrées (Insuline, Hémoglobine) pour test rapide.

3. Architecture Technique
Le projet suit une structure modulaire et asynchrone :
 * Frontend : HTML5, CSS3 (Variables dynamiques), JavaScript (Fetch API).
 * Backend : PHP  gérant la logique métier et la persistance via `$_SESSION`.
 * Communication : Échanges de données au format JSON pour une expérience sans rechargement de page (SPA).

Equipe de travail constitué de :
 - DOS SANTOS Junior
 - MOUKILA Edgard Junior
 - KPANOU Marcos Junior
