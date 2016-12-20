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
            numero: 1,
            arret: "Ranzay",
            sens: 1
        };
        $scope.otherLigne;

        $scope.limit = 10;
        $scope.numberOfTramsToShow = 3;
        $scope.numberOfTramsToShowMax = 9;

        $scope.showOtherArret = false;
        $scope.showOtherLigne = false;
        $scope.showOtherSens = false;
        $scope.selectedArret = '0';
        $scope.selectedLigne = '';
        $scope.selectedSens = 1;
        $scope.arrets = [{libelle:"Choisir arret...", codeLieu:'0'}];
        $scope.sens = [{sens:1}, {sens:2}];

        $scope.displayOtherArrets = function() {
            // Ne charger les arrets qu'une fois
            if ($scope.showOtherArret === false) {
                $scope.showOtherArret = true;

                var req = {
                    method: "GET",
                    url: $scope.phpProxy,
                    params: { url: "http://open.tan.fr/ewp/arrets.json"}
                };

                $http(req).then(function(response,status) {
                        // SUCCESS
                        $scope.arrets = response.data;
                        $scope.selectedArret = $scope.arrets[0];
                        // DEBUG
                        console.log(response.data);
                        $scope.status = status;
                        console.log('HELLO ARRETS');

                    }
                    , function (response) {
                        //ERROR
                        console.log('FAILED PROXY')
                    }
                );
            }
        };

        $scope.displayOtherLigne = function() {
            $scope.showOtherLigne = true;
            $scope.selectedLigne = $scope.selectedArret.ligne.numero;
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

                if (nextTram.ligne.numLigne != $scope.ligne.numero) return false;
                if (nextTram.ligne.typeLigne != 1) return false;
                if (nextTram.sens != $scope.ligne.sens) return false;

                return toDisplay;
            }
        };

        var urlHoraires = {
            method: "GET",
            url: $scope.phpProxy,
            params: { url: "http://open.tan.fr/ewp/tempsattente.json/RAZA"}
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

    }] );

})();