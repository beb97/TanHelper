<?php
/**
 * Created by PhpStorm.
 * User: pbebon
 * Date: 19/12/2016
 * Time: 17:35
 */



header('Content-Type: application/json');
$url = "http://open.tan.fr/ewp/tempsattente.json/RAZA";
$codesArretBrut  = file_get_contents($url);
echo $codesArretBrut;