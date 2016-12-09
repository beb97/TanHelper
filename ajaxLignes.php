<?php 
	$codesArretBrut  = file_get_contents("http://open.tan.fr/ewp/arrets.json");
	$codesArret = json_decode($codesArretBrut);
	
	$getArret = $_GET['arret'];
	// print_r($codesArret);

?>

<select name='l' size='1' id='selectLigne'/>
	<option value='' disabled selected>LIGNE ?</option>
	
	<?php
		$selectedLieu = $getArret;
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