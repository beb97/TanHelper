// Debut wrapper global
(function () {

    var app = angular.module('tram', []);

    app.controller('TraficController', function () {
        this.trafic = trafic;
        this.travaux = travaux;

        this.loadTravaux = false;
    });

    app.controller('TramController', ['$http', '$scope', function ($http, $scope) {
        this.tram = nextTram;
        this.ligne = currentLigne;

        this.numberOfTramsToShow = 3;
        this.numberOfTramsToShowMax = 9;
        this.loadMore = false;

        this.temp;

        this.urlHoraires = 'http://dotaspirit.com/t2/ajaxTest.php';

        this.urlHoraires = 'http://dotaspirit.com/t2/ajaxTest.php';
        $http.get(this.urlHoraires).then(function(response,status) {
                // SUCCESS
                $scope.temp = response.data;
                $scope.status = status;
                console.log('HELLO ARRETS');
            }
            , function (response) {
                //ERROR
                console.log('Open data didnt work')
            }
        );

        this.urlHoraires = 'http://dotaspirit.com/t2/ajaxAttente.php';
        $http.get(this.urlHoraires).then(function(response,status) {
                // SUCCESS
                console.log('HELLO HORRAIRES');
                $scope.tram = response.data;
                console.log($scope.tram);
                $scope.status = status;
            }
            , function (response) {
                //ERROR
                console.log('Open data didnt work')
            }
        );


    }] );

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



    var currentLigne = {
        numero: 1,
        arret: "Ranzay",
        sens: 1

    };

    var nextTram =[
        {
            terminus: 'Beuajoire',
            attente: 5
        },
        {
            terminus: 'Beuajoire',
            attente: 10
        },
        {
            terminus: 'Beuajoire',
            attente: 15
        },
        {
            terminus: 'Beuajoire',
            attente: 20
        }
        ,        {
            terminus: 'Jamet',
            attente: 30
        }
    ];



// Fin wrapper global
})();

/* URLS

 http://open.tan.fr/ewp/tempsattente.json
 http://open.tan.fr/ewp/horairesarret.json
 http://data.nantes.fr/api/getInfoTraficTANTempsReel/1.0/CTVUMHRNPTQWKE8/?output=json
 http://data.nantes.fr/api/getInfoTraficTANPrevisionnel/1.0/CTVUMHRNPTQWKE8/?output=json

 */