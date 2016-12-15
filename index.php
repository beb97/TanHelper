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
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Départs des prochains trams">
    <meta name="author" content="PB">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">
	<TITLE>TAN prochains départs </TITLE>
</head>
<body>
    <div class="container">
		
		
	<?php
	$globalArret = "RAZA";
	$globalLigne = "1";
	$globalSens = "1";
	
	$getArret = $_GET['a'];
	$getLigne = $_GET['l'];
	$getSens = $_GET['s'];
	
	if(isset($getArret) && isset($getLigne) && isset($getSens)){
		$globalArret = $getArret;
		$globalLigne = $getLigne;
		$globalSens = $getSens;
	}
	
	$jsonTempsAttente  = file_get_contents("http://open.tan.fr/ewp/tempsattente.json/$globalArret");
	$temps = json_decode($jsonTempsAttente);
	
	$jsonHoraires     = file_get_contents("http://open.tan.fr/ewp/horairesarret.json/$globalArret/$globalLigne/$globalSens");
	$horaires = json_decode($jsonHoraires);
	
	$jsonReel  = file_get_contents("http://data.nantes.fr/api/getInfoTraficTANTempsReel/1.0/39W9VSNCSASEOGV/?output=json");
	$infosTempsReel = json_decode($jsonReel);

	$jsonPrev  = file_get_contents("http://data.nantes.fr/api/getInfoTraficTANPrevisionnel/1.0/39W9VSNCSASEOGV/?output=json");
	$infosPrevisionnelles = json_decode($jsonPrev);
	
	$globalNomArret = $horaires->{'arret'}->{'libelle'};
	$globalNomLigne = $horaires->{'ligne'}->{'numLigne'};
	$globalNomSens = $horaires->{'ligne'}->{"directionSens$globalSens"};
	// print_r($temps);
	
	echo "<h2 class='bg-primary text-center'>$globalNomArret</h2>";
	echo "<h5 class='bg-primary text-center' style='margin-top:-10px'>Ligne $globalNomLigne direction $globalNomSens</h5>";
	
	$compteurTrajet = 0;
	$nombreTrajetAAfficher = 3;
	foreach ($temps as $temp) {
		
		if (($temp->{'ligne'}->{"numLigne"} == $globalLigne) && ($temp->{'sens'} == $globalSens)) {
			$compteurTrajet++;
			// N'afficher que les X premiers trajets DEBUT
			if ($compteurTrajet == $nombreTrajetAAfficher+1) {

				echo "<p>";
				echo "<div class='collapse' id='plushoraires' aria-expanded='false'>";
			}
			
			// Le premier trajet est plus visible
			if ($compteurTrajet == 1) {
				echo "<p class='bg-success'>";
				echo "<strong>";
			} else {
					echo "<p>";
			}
			echo $temp->{'terminus'}, " : ", $temp->{'temps'}, "</p>", PHP_EOL;
			if ($compteurTrajet == 1) echo "</strong>";

		}
		
	}
	
	// N'afficher que les X premiers trajets FIN
	if ($compteurTrajet > $nombreTrajetAAfficher) {
		echo "</div>";
		
		echo "<button class=\"btn btn-default\" type=\"button\" data-toggle=\"collapse\" data-target=\"#plushoraires\" aria-expanded=\"false\" aria-controls=\"plushoraires\" >";
		echo "Plus d'horaires...";
		echo "</button>";
		
		echo "</p>";
	}
	
	// Si aucun trajet trouvé
	if ($compteurTrajet == 0) {
		echo "<p> Aucun trajet dans l'heure à venir.</p>";
	}
	
	// echo "<a href='autreligne.php'>Afficher une autre ligne</a>";
	echo "<button class=\"btn btn-info\" type=\"button\" data-toggle=\"collapse\" data-target=\"#plusdelignes\" aria-expanded=\"false\" aria-controls=\"plusdelignes\" id='afficherLignes'>";
	echo "Afficher une autre ligne";
	echo "</button>";
	
	echo "<p>";
	echo "<div class='collapse' id='plusdelignes' aria-expanded='false'>";
		echo "<form action='index.php' type='get'>";
			echo"<div id='arrets'></div>";
			echo"<div id='lignes'></div>";
			echo"<div id='sens'></div>";
		echo "</form>";
	echo "</div>";
	echo "</p>";

	?>
		
		<h2 class="bg-primary text-center">Etat du réseau TAN</h2>

	<?php


	$etatTrafic = $horaires->{'ligne'}->{'etatTrafic'};
	if ($etatTrafic == 1) {
		echo "<p class='bg-success'>";
		echo ("<strong>Trafic normal</strong></p>");
	} else {
		echo "<p class='bg-danger'>";
		echo ("<strong>Trafic potentiellement anormal</strong></p>");
	}
	echo "</p>", PHP_EOL;

	$codeCouleur = $horaires->{'codeCouleur'};
	$tauxTram    = 100 - (($codeCouleur - 1) * 20);

	echo "<p>", "Niveau de service : ", $tauxTram, "% de la capacité max.", "</p>", PHP_EOL;


	?>

<!-- <h2 class="bg-primary">Autres :</h2> -->
	<?php

	$alertesSorted = array();
	
	$alertes = $infosTempsReel->{"opendata"}->{"answer"}->{"data"}->{"ROOT"}->{"LISTE_INFOTRAFICS"}->{"INFOTRAFIC"};
	foreach ($alertes as $alerte) {
		$lignes = $alerte->{"TRONCONS"};
		$lignesFormates = str_replace("[", "", $lignes);
		$lignesFormates = $lignesFormates.$alerte->{"CODE"};
		$alertesSorted[$lignesFormates] = $alerte;
	}
	
	$alertes = $infosPrevisionnelles->{"opendata"}->{"answer"}->{"data"}->{"ROOT"}->{"LISTE_INFOTRAFICS"}->{"INFOTRAFIC"};
	foreach ($alertes as $alerte) {
		$lignes = $alerte->{"TRONCONS"};
		$lignesFormates = str_replace("[", "", $lignes);
		$lignesFormates = $lignesFormates.$alerte->{"CODE"};
		$alertesSorted[$lignesFormates] = $alerte;
	}
	// print_r($alertesSorted);
	ksort($alertesSorted);
	
	$alertes=$alertesSorted;
	
	echo "<button class=\"btn btn-info\" type=\"button\" data-toggle=\"collapse\" data-target=\"#alertes\" aria-expanded=\"false\" aria-controls=\"alertes\">";
	echo "Afficher les travaux";
	echo "</button>";

	echo "<p>";
	echo "<div class='collapse' id='alertes' aria-expanded='false'>";
		$numeroAlerte = 0;
		foreach ($alertes as $alerte) {
			$numeroAlerte++;
			echo "<p>";
			echo "<button class=\"btn btn-secondary\" type=\"button\" data-toggle=\"collapse\" data-target=\"#alerte$numeroAlerte\" aria-expanded=\"false\" aria-controls=\"alerte$numeroAlerte\">";
			echo $alerte->{"INTITULE"};
			echo "</button>";
			$lignes = $alerte->{"TRONCONS"};
			$symbolesToRemove = array("[", "]", "/-");
			
			$lignesFormates = str_replace($symbolesToRemove, "", $lignes);

			$lignesFormates = str_replace("/1", "(a)", $lignesFormates);
			$lignesFormates = str_replace("/2", "(b)", $lignesFormates);
			
			$lignesFormates = str_replace(";", " et ", $lignesFormates);
			$lignesFormates = str_replace("/", " / ", $lignesFormates);
			
			echo " Lignes ", $lignesFormates, PHP_EOL;
			
			echo "<div class=\"collapse\" id=\"alerte$numeroAlerte\" aria-expanded=\"false\">";
			echo "<div class=\"card card-block\">";	
				echo "<p><u>", "Du ", $alerte->{"DATE_DEBUT"}, " à ", $alerte->{"HEURE_DEBUT"};
				// Expression ternaire deguellase pour remplacer les dates de fin vide par "?".
				$messageDateFin = isset($alerte->{"DATE_FIN"})&&!empty($alerte->{"DATE_FIN"})?$alerte->{"DATE_FIN"}." à ".$alerte->{"HEURE_FIN"}:"?";
				echo " au ", $messageDateFin, "</u></p>", PHP_EOL;
				echo "<p>", $alerte->{"INTITULE"}, " : ", $alerte->{"RESUME"}, "</p>", PHP_EOL;
				// echo "<p>", "Lignes : ", $alerte->{"TRONCONS"}, "</p>", PHP_EOL;
			echo "</div>";
			echo "</div>";
			echo "</p>";
		}
	echo "</div>";
	echo "</p>";
	

	
	?>

    </div>

    <!-- ANGULAR -->
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.0/angular.js"></script>

	<!--  JQUERY  -->
	<script src="//code.jquery.com/jquery-1.10.2.min.js"></script>
  	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
	<script type="text/javascript" src="tan.js"></script>
  	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">

	<!-- BOOTSTRAP -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
</body>
</html>