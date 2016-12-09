<?php 
	$codesArretBrut  = file_get_contents("http://open.tan.fr/ewp/arrets.json");
	$codesArret = json_decode($codesArretBrut);
	// print_r($codesArret);

?>

<select name='a' size='1' id='selectArret'/>

	<option value='' disabled selected>ARRET ?</option>
	<?php
		foreach ($codesArret as $codeArret) {
			$codeLieu = $codeArret->{'codeLieu'};
			$libelle = $codeArret->{'libelle'};
			echo"<option value='$codeLieu'>$libelle</option>";
		}		
	?>

</select>