<?php
/**
 * Created by PhpStorm.
 * User: pbebon
 * Date: 20/12/2016
 * Time: 15:23
 */

// RECUPERATION DES PARAMS
//PARAM URL
$url = $_GET['url'];
$sanitizedUrl = $url;
//$sanitizedUrl = filter_input( INPUT_GET, $url, FILTER_SANITIZE_URL );
// OTHERS PARAMS
/*
foreach ($_GET as $key=>$value) {
    echo "$key = " . urldecode($value) . "<br />\n";
}
*/

// APPEL DE LA PAGE CIBLE
$targetContent  = file_get_contents($sanitizedUrl);

// RENVOIE DE LA PAGE
header('Content-Type: application/json');
echo $targetContent;