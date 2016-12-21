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
    <link rel="icon" type="image/x-icon" href="favicon.ico" />

    <TITLE>TAN prochains départs </TITLE>
</head>
<body>
<div id="tram" class="container" ng-controller="TramController as tramCtrl" ng-cloak>
    <h2 class='bg-primary text-center' ng-bind="ligne.libelle">Loading..</h2>
    <h5 class='bg-primary text-center' style='margin-top:-10px' ng-bind-template="Ligne {{ligne.numLigne}} direction {{ligne.sens}}"></h5>
    <img ng-src="img/lignes/{{ligne.numero}}.gif"></img>

    <div id="tramproche" ng-init="getHoraires()">
        <div >
            <p ng-repeat="nextTram in tram | limitTo:limit | filter:evaluateDisplay()" ng-class="{ 'bg-success' : $first}" ng-bind-template="{{nextTram.terminus}} : {{nextTram.temps}}"></p>
        </div>
    </div>

    <div ng-show="isLigneShown" ng-repeat="l in selectedArret.ligne">
        <img ng-src="img/lignes/{{l.ligne.numLigne}}.gif"></img>
    </div>

<!--    <button class="btn btn-default" type="button" id="afficherPlusHoraires" ng-click="loadMore()">-->
<!--        Plus d'horaires...-->
<!--    </button>-->

    <button class="btn btn-info" type="button" id='afficherLignes' ng-click="gererArrets()">
        Afficher une autre ligne
    </button>

    <div id="arretSelector" ng-show="isArretShown" ng-cloak>
        <select ng-change="gererLignes()" ng-model="selectedArret" ng-options="arret as arret.libelle for arret in arrets" ></select>
<!--        <select ng-change="gererLignes()" ng-model="selectedArret" ng-options="arret as arret.libelle for arret in arrets | filter:{libelle:ligneCompletion}" ></select>-->
<!--        <input ng-model="ligneCompletion"></input>-->


        <select ng-show="isLigneShown" ng-change="gererSens()" ng-model="newLigne.numLigne" ng-options="ligne.numLigne as ligne.numLigne for ligne in selectedArret.ligne" ></select>
        <select ng-show="isSensShown" ng-change="updateSens()" ng-model="newLigne.sens" ng-options="s.sens as s.sens for s in sens"></select>

        <button class="btn btn-success" type="button" id='afficherHoraires' ng-click="gererHoraires()">
            Afficher
        </button>
    </div>

</div>

<div class="container" ng-controller="TraficController as trafic" ng-cloak>
    <h2 class="bg-primary text-center">Etat du réseau TAN</h2>
    <p class='bg-success' ng-bind="trafic.trafic.status">
    </p>
    <p class='' ng-bind="trafic.trafic.niveau">
    </p>
    <button class="btn btn-info" type="button" id='affichertravaux' ng-click="trafic.loadTravaux = !trafic.loadTravaux">
        Afficher les travaux
    </button>
    <div id="travaux" ng-show="trafic.loadTravaux" ng-repeat="incident in trafic.travaux track by $index" ng-init="details = false">
        <button ng-bind-template="{{incident.titre}} : Lignes {{incident.lignes}}" class="btn btn-secondary" id='afficherdetails' ng-click="details = !details">
        </button>
        <div id="details" ng-show="details">
            <p class='' ng-bind-template="{{incident.horaires}}"><u>   </u></p>
            <p class='' ng-bind-template="{{incident.message}}"></p>
        </div>
    </p>
</div>
</p>
</div>
</div>


</div>



<!-- ANGULAR -->
<script type="text/javascript" src="js/angular.js"></script>
<script type="text/javascript" src="js/app.js"></script>
<script type="text/javascript" src="js/horaires.js"></script>

<!-- PERSO -->
<!-- <script type="text/javascript" src="js/tan.js"></script> -->

<!--  JQUERY  -->

<script type="text/javascript" src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>

<!-- BOOTSTRAP -->
<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
</body>
</html>