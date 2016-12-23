<html ng-app="tram" >
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Départs des prochains tram">
    <meta name="author" content="PB">
    <link rel="stylesheet" href="css/tanhelper.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">
<!--    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.5/css/bootstrap.min.css" integrity="sha384-AysaV+vQoT3kOAXZkl02PThvDr8HYKPZhNT5h/CXfBThSRXQ6jW5DO2ekP5ViFdi" crossorigin="anonymous">-->
    <link rel="icon" type="image/x-icon" href="favicon.ico" />

    <TITLE>TAN prochains départs </TITLE>
</head>
<body>
<div class="container">

<div id="tram" class="tram-container" ng-controller="TramController as tramCtrl" ng-cloak ng-init="initTram()">
    <h2 class='bg-primary text-center' ng-bind="ligne.libelle">Loading..</h2>
<!--    <h5 class='bg-primary text-center' ng-bind-template="Ligne {{filter.selectedLigne[0]}}"></h5>-->

    <div class="ligne-selector-container" >
        <button class="btn btn-info" ng-show="!tramSettings.isArretShown" type="button" id='afficherLignes' ng-click="gererArrets()">
            Autre ligne
        </button>
        <div id="arretSelector" ng-show="tramSettings.isArretShown" ng-cloak>
            <select ng-change="gererHoraires()" ng-model="selectedArret" ng-options="arret as arret.libelle for arret in arrets" ></select>
        </div>
    </div>

    <div class="ligne-selector-container">
        <div ng-show="tramSettings.isArretShown">
            <img class="ligne-selector" ng-class=" {'overlay' : filter.isLigneGreyed(currentLigne)} " ng-repeat="currentLigne in filter.numLigne" ng-click="updateLigne(currentLigne)" ng-src="img/lignes/{{currentLigne}}.gif" err-src="img/lignes/error.jpg"></img>
        </div >
    </div>

        <div id="tramproche" class="ligne row" ng-repeat="nextTram in tram | limitTo:tramSettings.limit | filter:evaluateDisplay()">
            <div class="col-xs-1 col-m-1" ><img class='ligne-thumbnail' ng-src="img/lignes/{{nextTram.ligne.numLigne}}.gif"  err-src="img/lignes/error.jpg"></img></div>
            <div class="col-xs-1 col-m-1 glyphicon" ng-click="updateSens(nextTram.sens)"  ng-class=" (nextTram.sens == 1) ? 'glyphicon glyphicon-chevron-left' : 'glyphicon glyphicon-chevron-right' "></div>
            <div class="col-xs-7 col-m-6" ng-class=" { 'bg-success' : $first}" ng-bind-template="{{nextTram.terminus}}"></div>
            <div class="col-xs-3 col-m-4" ng-class=" { 'bg-success' : $first}" ng-bind-template="{{nextTram.temps}}"></div>
        </div>

</div>

<div class="trafic-container" ng-controller="TraficController as trafic" ng-cloak>
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
<!--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.5/js/bootstrap.min.js" integrity="sha384-BLiI7JTZm+JWlgKa0M0kGRpJbF2J8q+qreVrKBC47e3K6BW78kGLrCkeRX6I9RoK" crossorigin="anonymous"></script>-->

</body>
</html>