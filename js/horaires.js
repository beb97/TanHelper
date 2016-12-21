/**
 * Created by pbebon on 20/12/2016.
 */
(function(){
    var app = angular.module('horaires', []);

    /*
     app.directive('productPanels', function(){
     return {
     restrict: 'E',
     templateUrl: 'product-panels.html'
     };
     });
     */
    app.controller('TramController', ['$http', '$scope', function ($http, $scope) {

        $scope.phpProxy = "http://dotaspirit.com/t2/ajaxProxy.php";
        // http://open.tan.fr/ewp/horairesarret.json/RAZA/1/1
        // http://open.tan.fr/ewp/tempsattente.json/RAZA
        // http://open.tan.fr/ewp/arrets.json
        // http://data.nantes.fr/api/getInfoTraficTANTempsReel/1.0/CTVUMHRNPTQWKE8/?output=json
        // http://data.nantes.fr/api/getInfoTraficTANPrevisionnel/1.0/CTVUMHRNPTQWKE8/?output=json

        $scope.tram;

        $scope.ligne =  {
            numLigne: 1,
            libelle: "Ranzay",
            codeLieu: "RAZA",
            codeArret: "RAZA1",
            sens: 1,
            directionSens: "1"
        };

        $scope.newLigne = {
            numLigne: 1,
            libelle: "Ranzay",
            codeLieu: "RAZA",
            codeArret: "RAZA1",
            sens: 1,
            directionSens: "1"
        };

        // http://open.tan.fr/ewp/arrets.json
        $scope.templateArrets = {
            codeLieu:"RAZA",
            libelle:"Ranzay",
            distance:null,
            ligne : [{
                numLigne:"2",
            }, {
                numLigne:"C2"
            }
            ]
        };

        // http://open.tan.fr/ewp/tempsattente.json/RAZA
        $scope.templateTempsAttente = {
            sens:1,
            terminus:"Beaujoire",
            temps:"5 mn",
            ligne : {
                numLigne:1,
                typeLigne:1
            },
            arret : {
                codeArret: "RAZA1"
            }
        };

        // http://open.tan.fr/ewp/horairesarret.json/RAZA/1/1
        $scope.templateHorairesArret = {
            arret: {
                codeArret:"RAZA2",
                libelle:"Ranzay"
            },
            ligne: {
                numLigne:1,
                directionSens1:"François Mitterrand",
                directionSens2:"Beaujoire",
                accessible:1,
                etatTrafic:1
            },
            codeCouleur:2
        };

        $scope.limit = 10;
        $scope.numberOfTramsToShow = 3;
        $scope.numberOfTramsToShowMax = 9;

        $scope.isArretShown = false;
        $scope.isLigneShown = false;
        $scope.isSensShown = false;
        $scope.selectedArret = '0';
        $scope.selectedLigne = '';
        $scope.selectedSens = 1;

        // Les retours des GET
        $scope.arrets = [{libelle:"Choisir arret...", codeLieu:'0'}];
        $scope.sens = [{sens:1, directionSens1:"Sens 1"}, {sens:2, directionSens2:"Sens 2"}];
        $scope.retourLigne;

        $scope.gererArrets = function() {

            // Afficher bloc arrets
            // Ne charger les arrets qu'une fois
            if (!$scope.isArretShown) {
                $scope.isArretShown = true;
                // Charger arrets
                $scope.loadArrets();
            }
        };

        $scope.loadArrets = function () {
            var req = {
                method: "GET",
                url: $scope.phpProxy,
                params: { url: "http://open.tan.fr/ewp/arrets.json"}
            };

            $http(req).then(function(response,status) { // SUCCESS
                    $scope.arrets = response.data;
                    $scope.status = status;
                    console.log('LOADED ARRETS');

                }
                , function (response) { //ERROR
                    console.log('FAILED ARRETS')
                }
            );
        };

        $scope.gererLignes = function() {
            $scope.isLigneShown = true;
            // Affectation des nouvelles valeurs de l'arret
            //$scope.newLigne.numLigne = $scope.selectedArret.ligne.numero;
            $scope.newLigne.codeLieu = $scope.selectedArret.codeLieu;
            $scope.newLigne.libelle = $scope.selectedArret.libelle;
        };

        $scope.gererSens = function () {
            // Affectation des nouvelles valeurs de la ligne
            $scope.isSensShown = true;
            // Récupération des sens
            $scope.getLigne();
            // Ceci est deja setté par le model
            // $scope.newLigne.numLigne = $scope.selectedArret.ligne.numero;
        };

        $scope.updateSens = function () {
            // Affectation des nouvelles valeurs de la ligne
            if ($scope.newLine.sens === 1 ) {
                $scope.newLigne.directionSens = $scope.newLigne.directionSens1;
            } else {
                $scope.newLigne.directionSens = $scope.newLigne.directionSens2;
            }
            // Ceci est deja setté par le model
            // $scope.newLigne.numLigne = $scope.selectedArret.ligne.numero;
        };

        $scope.displayOtherSens = function() {
            $scope.showOtherSens = true;
            $scope.selectedSens = 1;
        };

        $scope.loadMore = function () {
            if ($scope.limit === $scope.numberOfTramsToShow) {
                $scope.limit = $scope.numberOfTramsToShowMax;
            } else {
                $scope.limit = $scope.numberOfTramsToShow;
            }
        };

        $scope.evaluateDisplay = function () {
            return function (nextTram) {
                var toDisplay = true;

                if (nextTram.ligne.numLigne != $scope.ligne.numLigne) return false;
                //  if (nextTram.ligne.typeLigne != 1) return false;
                //   if (nextTram.sens != $scope.ligne.sens) return false;

                return toDisplay;
            }
        };

        $scope.gererHoraires = function () {
            // On affecte la nouvelle ligne
            $scope.ligne.codeLieu = $scope.newLigne.codeLieu;
            $scope.ligne.libelle = $scope.newLigne.libelle;
            $scope.ligne.numLigne = $scope.newLigne.numLigne;
            $scope.ligne.sens = $scope.newLigne.sens;
            $scope.ligne.directionSens = $scope.newLigne.directionSens;
            // On récupère les infos correspondantes
            $scope.getHoraires();
        };

        $scope.getHoraires = function () {
            var urlHoraires = {
                method: "GET",
                url: $scope.phpProxy,
                params: { url: "http://open.tan.fr/ewp/tempsattente.json/"+$scope.ligne.codeLieu}
            };

            //AJOUT DES VARIABLES ARRET LIGNE SENS
            $http(urlHoraires).then(function(response,status) {
                    // SUCCESS
                    console.log('HELLO HORRAIRES');
                    $scope.tram = response.data;
                    // console.log($scope.tram);
                    $scope.status = status;
                }
                , function (response) {
                    //ERROR
                    console.log('Open data didnt work')
                }
            );
        };

        $scope.getLigne = function () {
            var urlHoraires = {
                method: "GET",
                url: $scope.phpProxy,
                params: { url: "http://open.tan.fr/ewp/horairesarret.json/"+$scope.newLigne.codeLieu+"/"+$scope.newLigne.codeLieu+"/"+$scope.newLigne.sens }
            };

            //AJOUT DES VARIABLES ARRET LIGNE SENS
            $http(urlHoraires).then(function(response,status) {
                    // SUCCESS
                    console.log('HELLO HORRAIRES');
                    $scope.mapperLigne(response.data);
                    // console.log($scope.tram);
                    $scope.status = status;
                }
                , function (response) {
                    //ERROR
                    console.log('Open data didnt work')
                }
            );
            // http://open.tan.fr/ewp/horairesarret.json/RAZA/1/1
        };

        $scope.mapperLigne = function (ligne) {
            $scope.sens[0].directionSens1 = ligne.ligne.directionSens1;
            $scope.sens[1].directionSens2 = ligne.ligne.directionSens2;
        }

    }] );

})();