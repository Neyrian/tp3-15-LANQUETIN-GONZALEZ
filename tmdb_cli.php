<?php
/*
Script CLI qui affiche les informations de la data base pour le film Fight Club, ID= 550.
*/
require_once("tp3-helpers.php");
$answer = tmdbget("movie/550");
print_r(json_decode($answer));
?>
