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
<html ng-app="tram" >
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
<div class="container" ng-controller="TramController as tram" ng-cloak>
    <h2 class='bg-primary text-center' ng-bind="tram.ligne.arret">Loading..</h2>
    <h5 class='bg-primary text-center' style='margin-top:-10px' ng-bind-template="Ligne {{tram.ligne.numero}} direction {{tram.ligne.sens}}"></h5>


    <div id="tramproche">
        <div ng-repeat="nextTram in tram.tram | limitTo:tram.numberOfTramsToShow">
            <p ng-class="{ 'bg-success' : $first}" ng-bind-template="{{nextTram.terminus}} : {{nextTram.attente}}">
            </p>
        </div>

    </div>

    <div id="tramloin" ng-show="tram.loadMore" ng-repeat="nextTram in tram.tram | limitTo:tram.numberOfTramsToShowMax:tram.numberOfTramsToShow">
        <p class='' ng-bind-template="{{nextTram.terminus}} : {{nextTram.attente}}">
        </p>
    </div>

    <button class="btn btn-default" type="button" id="afficherHoraires" ng-click="tram.loadMore = !tram.loadMore">
    Plus d'horaires...
    </button>

    <button class="btn btn-info" type="button" id='afficherLignes'>
        Afficher une autre ligne
    </button>

</div>

<div class="container" ng-controller="TraficController as trafic">
    <h2 class="bg-primary text-center">Etat du réseau TAN</h2>
    <p class='bg-success' ng-bind="trafic.trafic.status">
    </p>
    <p class='' ng-bind="trafic.trafic.niveau">
    </p>
    <button class="btn btn-info" type="button" id='affichertravaux'>
        Afficher les travaux
    </button>

</div>

<!-- ANGULAR -->
<script type="text/javascript" src="js/angular.js"></script>
<script type="text/javascript" src="js/app.js"></script>

<!-- PERSO -->
<!-- <script type="text/javascript" src="js/tan.js"></script> -->

<!--  JQUERY  -->

<script type="text/javascript" src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>

<!-- BOOTSTRAP -->
<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
</body>
</html>