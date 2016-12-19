<?php
/**
 * Created by PhpStorm.
 * User: pbebon
 * Date: 19/12/2016
 * Time: 15:55
 */

    header('Content-Type: application/json');
	$codesArretBrut  = file_get_contents("http://open.tan.fr/ewp/arrets.json");
    echo $codesArretBrut;

?>