<?php
/**
 * Created by PhpStorm.
 * User: pbebon
 * Date: 20/12/2016
 * Time: 15:58
 */
$url = "http://open.tan.fr/ewp/tempsattente.json/RAZA?ligne=1&sens=2";
$parts = parse_url($url);
print_r($parts);

