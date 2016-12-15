<!--
http://open.tan.fr/ewp/horairesarret.json/RAZA/1/1
SENS 1 : François Mitterrand / Jamet
SENS 2 : Ranzay

Champ “codeCouleur”
BLEU = “1”; 100%
VERT = “2”;
JAUNE = “3”;
VIOLET = “4”;
BLANC = “5”;
ORANGE = “6”; 0%

"etatTrafic" => 1, "libelleTrafic" => "Trafic normal"

-->
<html ng-app="tram">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Départs des prochains tram">
    <meta name="author" content="PB">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <TITLE>TAN prochains départs </TITLE>
</head>
<body>
<div class="container" ng-controller="TramController as tram">
    <h2 class='bg-primary text-center'> {{tram.ligne.arret}} </h2>
    <h5 class='bg-primary text-center' style='margin-top:-10px'>Ligne {{tram.ligne.numero}}  direction {{tram.linge.sens}} </h5>


    <p>
        <div class='collapse' id='plushoraires' aria-expanded='false'>
    <p class='bg-success'>
        <strong>
    <p>
        {{tram.nextTram.terminus}} : {{tram.nextTram.attente}}
    </p>
    </strong>
    </p>
    </p>




</div>

<!-- ANGULAR -->
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.0/angular.js"></script>
<script src="js/app.js"></script>

<!-- PERSO -->
<script src="js/tan.js"></script>

<!--  JQUERY  -->
<script src="//code.jquery.com/jquery-1.10.2.min.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>

<!-- BOOTSTRAP -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
</body>
</html>