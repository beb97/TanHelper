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

        $scope.defaultValue = {
            codeLieu: "RAZA",
            numLigne: "1",
            sens: 1
        };

        $scope.filter = {
            numLigne: [],
            sens: [],
            selectedLigne: [],
            resetFilter: function () {
                $scope.filter.selectedLigne.length=0;
                $scope.filter.numLigne.length=0;
                $scope.filter.sens.length=0;
            },
            isLigneGreyed: function (ligne) {
                if ($scope.filter.selectedLigne.length == 0) {
                    console.log("PAS DE FILTRE");
                    return false;
                } else if ($scope.filter.selectedLigne.indexOf(ligne) != -1) {
                    console.log("FILTRE OK");
                    return false;
                } else {
                    console.log("FILTRE KO");
                    return true;
                }
            }
        };

        $scope.ligne =  {
            numLigne: "1",
            libelle: "Ranzay"
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

        $scope.tramSettings = {
            limit: 15,
            numberOfTramsToShow: 15,
            numberOfTramsToShowMax: 15,

            isArretShow: false
        };

        $scope.selectedArret = '0';

        // Les retours des GET
        $scope.arrets = [{libelle:"Choisir arret...", codeLieu:'0'}];
        $scope.sens = [{sens:1, directionSens1:"Sens 1"}, {sens:2, directionSens2:"Sens 2"}];
        $scope.retourLigne;

        $scope.initTram = function () {
            $scope.filter.numLigne.push($scope.defaultValue.numLigne);
            $scope.filter.selectedLigne.push($scope.defaultValue.numLigne);
            $scope.filter.sens.push($scope.defaultValue.sens);

            $scope.ligne.codeLieu = $scope.defaultValue.codeLieu;

            $scope.getHoraires();

        };

        $scope.gererArrets = function() {

            // Afficher bloc arrets
            // Ne charger les arrets qu'une fois
            if (!$scope.tramSettings.isArretShown) {
                $scope.tramSettings.isArretShown = true;
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
                    console.log('LOADED ARRETS');
                }
                , function (response) { //ERROR
                    console.log('FAILED ARRETS')
                }
            );
        };

        $scope.updateLigne = function (ligne) {

            if ($scope.filter.selectedLigne.indexOf(ligne) == -1) {
                $scope.filter.selectedLigne.push(ligne);
            } else {
                $scope.filter.selectedLigne.pop(ligne);
            }
        };

        $scope.updateSens = function (sens) {
            if ($scope.filter.sens.indexOf(sens) == -1) {
                $scope.filter.sens.push(sens);
            } else {
                $scope.filter.sens.pop(sens);
            }
        };

        $scope.evaluateDisplay = function () {
            return function (nextTram) {
                var toDisplay = true;

                // Si on a un filtre sur la ligne
                if ($scope.filter.selectedLigne.length > 0) {

                    // On ne retourne pas l'horaire si elle ne porte pas sur nos lignes
                    if ( $scope.filter.selectedLigne.indexOf(nextTram.ligne.numLigne) === -1) {
                        return false;
                    }
                }

                if ($scope.filter.sens.length > 0) {

                    // On ne retourne pas l'horaire si elle ne porte pas sur nos lignes
                    if ( $scope.filter.sens.indexOf(nextTram.sens) === -1) {
                        return false;
                    }
                }

                return toDisplay;
            }
        };

        $scope.gererHoraires = function () {
            // On affecte la nouvelle ligne
            $scope.ligne.codeLieu = $scope.selectedArret.codeLieu;
            $scope.ligne.libelle = $scope.selectedArret.libelle;
            $scope.ligne.sens = $scope.selectedArret.sens;


            // On vide les filtres
            $scope.filter.resetFilter();

            // On ajoute les lignes possible au filtre
            for (let currentLigne of $scope.selectedArret.ligne) {
                $scope.filter.numLigne.push(currentLigne.numLigne);
            }

            // On vide les horaires actuelles
            $scope.tram = "";

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
                params: { url: "http://open.tan.fr/ewp/horairesarret.json/"+$scope.ligne.codeLieu+"/"+$scope.ligne.codeLieu+"/"+$scope.ligne.sens }
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

    // Gère le cas ou l'image n'est pas chargée
    app.directive('errSrc', function() {
        return {
            link: function(scope, element, attrs) {
                element.bind('error', function() {
                    if (attrs.src != attrs.errSrc) {
                        attrs.$set('src', attrs.errSrc);
                    }
                });
            }
        }
    });

})();