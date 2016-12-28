<html ng-app="tram" >
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Départs des prochains tram">
    <meta name="author" content="PB">

    <link rel="stylesheet" href="css/tanhelper.css">

    <!--    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">-->
    <!--    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.5/css/bootstrap.min.css" integrity="sha384-AysaV+vQoT3kOAXZkl02PThvDr8HYKPZhNT5h/CXfBThSRXQ6jW5DO2ekP5ViFdi" crossorigin="anonymous">
    <link rel="icon" type="image/x-icon" href="favicon.ico" />

    <TITLE>TAN prochains départs </TITLE>
</head>
<body>
<div class="container">

    <div id="tram" class="tram-container" ng-controller="TramController as tramCtrl" ng-cloak ng-init="initTram()">

        <div class="table-responsive">
            <table class="table borderless">
                <thead class="">
                <tr>
                    <th class='bg-info text-xs-center'>
                        Arrêt
                        <h1 ng-bind="ligne.libelle">Loading..</h1>
                    </th>
                    <th class='bg-success text-xs-center'  ng-click="gererArrets()">
                        <div ng-show="!tramSettings.isArretShown">
                            Choisir
                            <h4><u>Autre arrêt</u></h4>
                        </div>
                        <div ng-show="tramSettings.isArretShown" >
                            <select autofocus="true" style="width: 120px" id="arretSelector" ng-change="gererHoraires()" ng-model="selectedArret" ng-options="arret as arret.libelle group by arret.distance disable when arret.disabled for arret in arrets" >
                                <option disabled>Chargement...</option>
                            </select>
                        </div>
                    </th>

                </tr>
                </thead>
            </table>
        </div>
        <!--    <h5 class='bg-primary text-center' ng-bind-template="Ligne {{filter.selectedLigne[0]}}"></h5>-->

        <!--    <div class="ligne-selector-container" >-->
        <!--        <button class="btn btn-info" ng-show="!tramSettings.isArretShown" type="button" id='afficherLignes' ng-click="gererArrets()">-->
        <!--            Autre ligne-->
        <!--        </button>-->
        <!--        <div id="arretSelector" ng-show="tramSettings.isArretShown" ng-cloak>-->
        <!--            <select class="selectpicker" data-live-search="true" ng-change="gererHoraires()" ng-model="selectedArret" ng-options="arret as arret.libelle  disable when arret.disabled for arret in arrets" >-->
        <!--                <option disabled>Chargement...</option>-->
        <!--            </select>-->
        <!--        </div>-->
        <!--    </div>-->

        <div class="ligne-selector-container">
            <div ng-show="tramSettings.isArretShown" ng-cloak>
                <img class="ligne-selector" ng-class=" {'overlay' : filter.isLigneGreyed(currentLigne)} " ng-repeat="currentLigne in filter.numLigne" ng-click="updateLigne(currentLigne)" ng-src="img/lignes/{{currentLigne}}.gif" err-src="img/lignes/error.jpg"></img>
            </div >
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-sm">
                <thead class="thead-inverse">
                <tr>
                    <th>Ligne</th>
                    <th>Sens</th>
                    <th>Direction</th>
                    <th>Attente</th>
                </tr>
                </thead>
                <tbody class="table-hover">
                <tr id="tramproche" class="" ng-class=" { 'bg-success' : $first}" ng-repeat="nextTram in tramFiltered = ( tramHoraires.horaires | filter:evaluateDisplay() | limitTo:tramSettings.limit) ">
                    <td><img class='ligne-thumbnail' ng-src="img/lignes/{{nextTram.ligne.numLigne}}.gif"  err-src="img/lignes/error.jpg"></img></td>
                    <td ng-click="updateSens(nextTram.sens)" ng-bind-template="{{tramHoraires.formatSens(nextTram.sens)}}"></td>
                    <td ng-class=" { 'bg-success' : $first}" ng-bind-template="{{nextTram.terminus}}"> </td>
                    <td ng-class=" { 'bg-success' : $first}" ng-bind-template="{{tramHoraires.formatAttente(nextTram.temps)}}"> </td>
                    <!--                    <td ng-class=" { 'bg-success' : $first}" ng-bind-template="{{nextTram.temps}}"> </td>-->
                </tr>

                <!-- SI PAS DE TRAM-->
                <tr ng-show="!tramFiltered.length">
                    <td></td>
                    <td></td>
                    <td>Aucun tram dans l'heure</td>
                    <td></td>
                </tr>

                </tbody>

            </table>

        </div>

    </div>

    <div ng-show="false" class="trafic-container" ng-controller="TraficController as trafic" ng-cloak>
        <h1 class='bg-info text-xs-center'>Etat du réseau TAN</h1>
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

<!--  JQUERY  -->
<script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ=" crossorigin="anonymous"></script>
<!--<script type="text/javascript" src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>-->

<!-- BOOTSTRAP -->
<!--<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>-->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.5/js/bootstrap.min.js" integrity="sha384-BLiI7JTZm+JWlgKa0M0kGRpJbF2J8q+qreVrKBC47e3K6BW78kGLrCkeRX6I9RoK" crossorigin="anonymous"></script>


<!-- BETTER SELECTOR -->
<!--<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.7.5/js/bootstrap-select.min.js"></script>-->


</body>
</html>