<?php
session_start();

$is_admin = $_SESSION['is_admin'] ?? false;
$is_electeur = $_SESSION['is_electeur'] ?? false;
$is_connecter = $_SESSION['is_connecter'] ?? false;
$nom = $_SESSION['nom'] ?? '';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Coup de Sifflet - Accueil</title>

<link rel="stylesheet" href="assets/css/style.css">

<!-- Leaflet -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" defer></script>

<style>
#map {
  height: 520px;
  width: min(1100px, 92vw);
  margin: 25px auto;
  border-radius: 14px;
}

/* Clubs grid */
.clubs-grid {
  width: min(1100px, 92vw);
  margin: 20px auto;
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 16px;
}

.club-card {
  background: var(--bg);
  border-left: 8px solid var(--yellow);
  border-radius: 14px;
  padding: 14px 16px;
  font-family: var(--font);
  font-weight: 600;
  box-shadow: 0 6px 16px rgba(0,0,0,.08);
  transition: .15s;
}

.club-card:hover {
  transform: translateY(-2px);
  box-shadow: 0 10px 24px rgba(0,0,0,.12);
  border-left-color: var(--blue);
}

@media (max-width: 700px) {
  .clubs-grid { grid-template-columns: 1fr; }
}

.panel {
  width: min(1100px, 92vw);
  margin: 10px auto;
  padding: 10px 14px;
  border-radius: 12px;
  background: rgba(0,0,0,.06);
  display: flex;
  justify-content: space-between;
  align-items: center;
}

#clubsView { display: none; }
</style>
</head>

<body>

<header>
  <h1>Coup de Sifflet</h1>
  <nav>
    <a href="Index.php?page=accueil">Accueil</a>
    <a href="Index.php?page=contact">Contact</a>
    <?php if ($is_connecter) { ?>
      <a href="Index.php?page=deconnexion">Déconnexion</a>
    <?php } else { ?>
      <a href="Index.php?page=connexion">Connexion</a>
    <?php } ?>
  </nav>
</header>

<main>

<section class="hero-compact">
  <div class="hero-left">
    <strong>Coup de Sifflet</strong>
    <span>— Plateforme de vote européenne</span>
  </div>

  <?php if ($is_connecter) { ?>
    <div class="hero-right">
      Bienvenue <strong><?= htmlspecialchars($nom) ?></strong>
    </div>
  <?php } ?>
</section>


<?php if ($is_connecter) { ?>

<h2 class="map-title">Choisis un pays</h2>

<div id="mapView">
  <div class="panel">
    Pays sélectionné : <strong id="selectedCountry">Aucun</strong>
  </div>
  <div id="map"></div>
</div>

<div id="clubsView">
  <div class="panel">
    Pays : <strong id="clubsCountry"></strong>
    <button id="backBtn" class="btn">Retour à la carte</button>
  </div>
  <div id="clubsList" class="clubs-grid"></div>
</div>

<script>
document.addEventListener("DOMContentLoaded", () => {

const map = L.map("map").setView([54.5, 15], 4);
L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
  attribution: "&copy; OpenStreetMap"
}).addTo(map);

const selectedCountry = document.getElementById("selectedCountry");
const clubsView = document.getElementById("clubsView");
const mapView = document.getElementById("mapView");
const clubsCountry = document.getElementById("clubsCountry");
const clubsList = document.getElementById("clubsList");
const backBtn = document.getElementById("backBtn");

const countryLabel = {
  "United Kingdom":"England",
  "France":"France",
  "Portugal":"Portugal",
  "Germany":"Germany",
  "Spain":"Spain",
  "Italy":"Italy",
  "Netherlands":"Netherlands",
  "Deutschland":"Germany",
  "España":"Spain",
  "Italia":"Italy"
};

const iso2 = {
  "England":"GB","France":"FR","Portugal":"PT",
  "Germany":"DE","Spain":"ES","Italy":"IT","Netherlands":"NL"
};

function showClubs(display) {
  clubsCountry.textContent = display;
  clubsList.innerHTML = `<div class="club-card">Chargement…</div>`;
  mapView.style.display = "none";
  clubsView.style.display = "block";

  fetch("get_equipes.php?country=" + iso2[display])
    .then(r => r.json())
    .then(d => {
      if (!d.equipes || d.equipes.length === 0) {
        clubsList.innerHTML = `<div class="club-card">Aucune équipe trouvée</div>`;
        return;
      }
      clubsList.innerHTML = d.equipes
        .map(n => `<div class="club-card">${n}</div>`).join("");
    });
}

backBtn.onclick = () => {
  clubsView.style.display = "none";
  mapView.style.display = "block";
  setTimeout(() => map.invalidateSize(), 50);
};

function onEachFeature(f, l) {
  l.setStyle({ color:"#222", weight:1, fillColor:"#3c6382", fillOpacity:.4 });
  l.on("click", () => {
    const raw = f.properties.CNTR_NAME;
    const display = countryLabel[raw] || raw;
    selectedCountry.textContent = display;
    showClubs(display);
  });
}

fetch("assets/geo/europe_full.geojson")
.then(r => r.json())
.then(data => {
  const allowed = Object.keys(countryLabel);
  const filtered = {
    type:"FeatureCollection",
    features:data.features.filter(f => allowed.includes(f.properties.CNTR_NAME))
  };
  L.geoJSON(filtered, { onEachFeature }).addTo(map);
});

});
</script>

<?php } ?>

</main>

<footer>
<p>&copy; 2025 - Coup de Sifflet</p>
</footer>

</body>
</html>
