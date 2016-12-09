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
	<TITLE>Selecteur de ligne</TITLE>
</head>
<body>
    <div class="container">

		<?php 
			$codesArretBrut  = file_get_contents("http://open.tan.fr/ewp/arrets.json");
			$codesArret = json_decode($codesArretBrut);
			// print_r($codesArret);

		?>
	
		<form action='index.php' type='get'>
			<select name='a' size='1'/>
				<option value=''>CODE ARRET</option>
				
				<?php
					foreach ($codesArret as $codeArret) {
						$codeLieu = $codeArret->{'codeLieu'};
						$libelle = $codeArret->{'libelle'};
						echo"<option value='$codeLieu'>$libelle</option>";
						//echo"<option value='$codeArret->{'codeLieu'}'>$codeArret->{'libelle'}</option>";
					}		
				?>
			
			</select> 
			
			<select name='l' size='1'/>
				<option value=''>LIGNE</option>
				
				<?php
					$selectedLieu = "COMM";
					foreach ($codesArret as $codeArret) {
						if( $selectedLieu == $codeArret->{'codeLieu'} ) {
							foreach ($codeArret->{'ligne'} as $ligne) {
								$numLigne = $ligne->{'numLigne'};
								echo"<option value='$numLigne'>$numLigne</option>";
							}
							break; // On sort de la boucle
						}
						//echo"<option value='$codeArret->{'codeLieu'}'>$codeArret->{'libelle'}</option>";
					}		
				?>
			</select> 
			<select name='s' size='1'/>
				<option value=''>SENS</option>
				<option value='1'>1</option>
				<option value='2'>2</option>
			</select> 
			<button type='submit'>GO</button>
			  <a href='http://open.tan.fr/ewp/arrets.json'>(Liste des codes arrets)</a>
		</form>

    </div>
	
	<!--  JQUERY  -->
	<script src="//code.jquery.com/jquery-1.10.2.min.js"></script>
  	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
  	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">

	<!-- BOOTSTRAP -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
</body>
</html>