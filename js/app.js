// Debut wrapper global
(function () {

    var app = angular.module('tram', ['horaires']);

    app.controller('TraficController', function () {
        this.trafic = trafic;
        this.travaux = travaux;
        this.loadTravaux = false;
    });

    var trafic = {
        status: "normal",
        niveau: 100
    };

    var travaux = [
        {
            titre: "Travaux",
            lignes: "1, 2, 3",
            horaires: "Lundi -> vendredi",
            message: "Coupure pour travaux"
        },
        {
            titre: "Travaux",
            lignes: "1, 2, 3",
            horaires: "Lundi -> samedi",
            message: "Coupure pour travaux"
        }];

// Fin wrapper global
})();