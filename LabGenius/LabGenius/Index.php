<?php 
session_start(); // Démarre la session pour stocker l'ADN entre les pages
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>LabGenius | Simulateur de Laboratoire</title>
    <link rel="stylesheet" href="/Css/Add.css">
    <link rel="stylesheet" href="/Css/header.css">
    <link rel="stylesheet" href="/Css/media.css">
    <link rel="stylesheet" href="/Css/Résultat.css">
    <link rel="stylesheet" href="/Css/sections.css">
</head>
<body>

<header class="topbar">
    <div class="logo-container">
        <div class="nav-left">
            <img src="/Img/Logo.jpeg" alt="Logo" class="logo-img">
            <span class="logo-text"><span class="lab">Lab</span><span class="genius">Genius</span></span>
        </div>
        <nav class="topnav">
            <a href="#" class="nav-link active" data-section="dashboard">Dashboard</a>
            <a href="#" class="nav-link" data-section="sequencer">Séquenceur</a>
            <a href="#" class="nav-link" data-section="synthesis">Synthèse</a>
            <a href="#" class="nav-link" data-section="library">Bibliothèque</a>
            <a href="#" class="nav-link" data-section="notebook">Carnet</a>
        </nav>
        <div class="header-right">
            <button class="icon-btn" id="themeToggle">🌓</button>
        </div>
    </div>
</header>

<section class="hero">
    <div class="hero-left">
      <h1>Laboratoire Génétique Virtuel</h1>
      <p>
        Explorez, analysez et manipulez des séquences ADN dans un environnement scientifique interactif.
        Centralisez vos séquences, lancez des synthèses, et organisez vos notes de laboratoire.
      </p>

      <div class="hero-actions">
        <a href="#" class="nav-link" data-section="sequencer">
            <button class="btn" type="button" data-go="sequenceur">
                <i class="fa-solid fa-dna"></i> Ouvrir le séquenceur
            </button>
        </a>
        <button class="btn btn-ghost" type="button" data-go="dashboard">
          <i class="fa-solid fa-house"></i> Aller au dashboard
        </button>
      </div>
    </div>

    <div class="hero-right">
      <div class="dna-3d" aria-hidden="true">
        <div class="pair"><span></span></div><div class="pair"><span></span></div><div class="pair"><span></span></div><div class="pair"><span></span></div><div class="pair"><span></span></div>
        <div class="pair"><span></span></div><div class="pair"><span></span></div><div class="pair"><span></span></div><div class="pair"><span></span></div><div class="pair"><span></span></div>
        <div class="pair"><span></span></div><div class="pair"><span></span></div><div class="pair"><span></span></div><div class="pair"><span></span></div><div class="pair"><span></span></div>
        <div class="pair"><span></span></div><div class="pair"><span></span></div><div class="pair"><span></span></div><div class="pair"><span></span></div><div class="pair"><span></span></div>
      </div>
    </div>
  </section>

<main class="app">
    <section id="dashboard" class="section active">
        <h2>Tableau de Bord</h2>
        <div class="boxes">
            <div class="box"><h3>ADN Session</h3><p id="statDna" class="mono">---</p></div>
            <div class="box"><h3>Taux GC</h3><p id="statGC" style="color:var(--a1)">0%</p></div>
            <div class="box"><h3>Taux AT</h3><p id="statAT" style="color:var(--a2)">0%</p></div>
        </div>
    </section>

    <section id="sequencer" class="section">
        <h2>Éditeur de Génome</h2>
        <div class="card">
            <input type="text" id="dnaInput" class="input mono" placeholder="Séquence ADN (ATGC)..." oninput="this.value = this.value.toUpperCase()">
            <button class="btn mt12" style="width:100%" onclick="dnaEngine.saveSequence()">💾 Fixer la Séquence</button>
            
            <div class="row mt12">
                <button class="btn btn-ghost" onclick="dnaEngine.runAction('mutate')">🧬 Mutation</button>
                <button class="btn btn-ghost" onclick="dnaEngine.runAction('transcribe')">🧪 Transcription</button>
                <button class="btn btn-ghost" onclick="dnaEngine.runAction('complement')">🔗 Complément</button>
            </div>

            <div id="res-mutate" class="mt12"></div>
            <div id="res-transcribe" class="mt12"></div>
            <div id="res-complement" class="mt12"></div>
        </div>
    </section>

    <section id="synthesis" class="section">
        <h2>Unité de Synthèse</h2>
        <div class="card">
            <p>Cible : <span id="targetSeqDisplay" class="mono">Aucune</span> 
            <button class="btn btn-ghost" onclick="dnaEngine.loadForSynthesis()">📥 Charger</button></p>
            <div class="progress-container"><div id="progressBar"></div></div>
            <p style="text-align:center"><span id="syncPercent">0</span>% de progression</p>
            <div id="synthReport" class="mt12"></div>
            <button class="btn" id="startSynth" onclick="dnaEngine.startSynthesis()">🚀 Lancer la Synthèse</button>
        </div>
    </section>

    <section id="library" class="section">
        <h2>Bibliothèque de Séquences</h2>
        <div class="grid-2">
            <div class="box clickable" onclick="dnaEngine.importLib('ATGCGTACGTAG')">
                <h4>Hémoglobine (Fragment)</h4>
                <code>ATGCGTACGTAG</code>
            </div>
            <div class="box clickable" onclick="dnaEngine.importLib('CCGGCCGGCCGG')">
                <h4>Kératine (Riche en GC)</h4>
                <code>CCGGCCGGCCGG</code>
            </div>
            <div class="box clickable" onclick="dnaEngine.importLib('TATAATAAATAA')">
                <h4>Boîte TATA (Promoteur)</h4>
                <code>TATAATAAATAA</code>
            </div>
            <div class="box clickable" onclick="dnaEngine.importLib('ATGCCCCAA')">
                <h4>Insuline Bovine</h4>
                <code>ATGCCCCAA</code>
            </div>
        </div>
    </section>

    <section id="notebook" class="section">
        <h2>Carnet de Laboratoire</h2>
        <textarea id="noteInput" class="input note-area" placeholder="Observations..."></textarea>
        <button class="btn mt12" onclick="dnaEngine.saveNote()">Sauvegarder</button>
        <div id="notesContainer"></div>
    </section>
</main>

<div id="toast" class="toast"><span id="toastMessage"></span></div>

<script src="/Js/ADN_map.js"></script>
<script src="/Js/Index.js"></script>
</body>
</html>