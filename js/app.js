// Debut wrapper global
(function () {

    var app = angular.module('tram', []);

    app.controller('TraficController', function () {
        this.trafic = trafic;
        this.travaux = travaux;

    });

    app.controller('TramController', ['$http', '$scope', function ($http, $scope) {
        this.tram = nextTram;
        this.ligne = currentLigne;

        this.numberOfTramsToShow = 3;
        this.numberOfTramsToShowMax = 9;
        this.loadMore = false;

        this.temp = [];
        // this.urlHoraires = 'http://open.tan.fr/ewp/horairesarret.json/RAZA/1/1';
        // this.urlHoraires = 'http://data.nantes.fr/api/getInfoTraficTANTempsReel/1.0/CTVUMHRNPTQWKE8/?output=json';
        // this.urlHoraires = 'http://data.nantes.fr/api/getInfoTraficTANTempsReel/1.0/CTVUMHRNPTQWKE8';

        /* http://stackoverflow.com/questions/6213509/send-json-post-using-php

         $options = array(
         'http' => array(
         'method'  => 'POST',
         'content' => json_encode( $data ),
         'header'=>  "Content-Type: application/json\r\n" .
         "Accept: application/json\r\n"
         )
         );

         $context  = stream_context_create( $options );
         $result = file_get_contents( $url, false, $context );
         $response = json_decode( $result );

         */
        this.urlHoraires = 'http://data.nantes.fr/api/getInfoTraficTANTempsReel';
        var req = {
            method: 'GET',
            url: this.urlHoraires
        };

        $http.get(this.urlHoraires).then(function(response) {
                // SUCCESS
                this.temp = response.data;
                console.log('HELLO MDR');
            }
            , function (response) {
                //ERROR
                this.temp = "";
                console.log('FUCK YOU')
            }
        );
    }] );

    var trafic = {
        status: "normal",
        niveau: 100
    }


    var travaux = {
        lignes: "1, 2, 3",
        horaires: "Lundi -> vendredi",
        message: "Coupure pour travaux"

    }



    var currentLigne = {
        numero: 1,
        arret: "Ranzay",
        sens: 1

    }

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
    ]



// Fin wrapper global
})();

/* URLS

 http://open.tan.fr/ewp/tempsattente.json
 http://open.tan.fr/ewp/horairesarret.json
 http://data.nantes.fr/api/getInfoTraficTANTempsReel/1.0/CTVUMHRNPTQWKE8/?output=json
 http://data.nantes.fr/api/getInfoTraficTANPrevisionnel/1.0/CTVUMHRNPTQWKE8/?output=json

*/