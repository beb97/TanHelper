// Debut wrapper global
(function () {


var app = angular.module('tram', []);

app.controller('TramController', function () {
    this.tram = nextTram;
    this.ligne = currentLigne;
});

var currentLigne = {
    numero: 1,
    arret: "Ranzay",
    sens: 1

}

var nextTram = {
    terminus: 'Beuajoire',
    attente: 5
}

// Fin wrapper global
})

/* URLS


 $jsonTempsAttente  = file_get_contents("http://open.tan.fr/ewp/tempsattente.json/$globalArret");
 $temps = json_decode($jsonTempsAttente);

 $jsonHoraires     = file_get_contents("http://open.tan.fr/ewp/horairesarret.json/$globalArret/$globalLigne/$globalSens");
 $horaires = json_decode($jsonHoraires);

 $jsonReel  = file_get_contents("http://data.nantes.fr/api/getInfoTraficTANTempsReel/1.0/39W9VSNCSASEOGV/?output=json");
 $infosTempsReel = json_decode($jsonReel);

 $jsonPrev  = file_get_contents("http://data.nantes.fr/api/getInfoTraficTANPrevisionnel/1.0/39W9VSNCSASEOGV/?output=json");
 $infosPrevisionnelles = json_decode($jsonPrev);
 */