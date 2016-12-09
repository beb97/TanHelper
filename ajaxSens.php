<?php 

	$getArret = $_GET['arret'];
	$getLigne = $_GET['ligne'];
	$getSens = 1;
	
	$jsonHoraires = file_get_contents("http://open.tan.fr/ewp/horairesarret.json/$getArret/$getLigne/$getSens");
	$horaires = json_decode($jsonHoraires);
	// print_r($horaires);
	$globalNomSens1 = $horaires->{'ligne'}->{"directionSens1"};
	$globalNomSens2 = $horaires->{'ligne'}->{"directionSens2"};
	
?>

<select name='s' size='1'/>
	<option value='' disabled selected>SENS ?</option>
	<option value='1'><?php echo $globalNomSens1 ?></option>
	<option value='2'><?php echo $globalNomSens2 ?></option>
</select> 

<button type='submit'>GO</button>