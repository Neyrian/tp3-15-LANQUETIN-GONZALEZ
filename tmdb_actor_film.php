<?php

/*
Script qui affiche la filmographie d'un acteur, dont l'id et le nom est passé en argument lors de l'appel.
Les infrmations sont affichés dans un tableau, on y retrouve
la liste des films et le rôle de l'acteur dans ceux-ci.
*/
require_once("tp3-helpers.php");
//on récupère les infomations de l'acteur et on traite la réponse JSON
$actor_id = $_GET['id'];
$actor_name = $_GET['name'];
$json_brut = tmdbget("person/$actor_id/combined_credits");
$jsondecode = json_decode($json_brut);

echo "<head><title>$actor_name</title><meta charset=\"UTF-8\"><link rel=\"stylesheet\" type=\"text/css\" href=\"tmdb.css\"/></head><body>";
echo "<t>Liste des films de: $actor_name <br></t>";
echo "<table><tbody>";
echo "<tr class='info'><td></td><td>Titre des films</td><td>Rôle</td></tr>";
$i = 1; //compteur de film
foreach ($jsondecode->cast as $cast) {
  /*
  Dans les crédits de l'acteur, on retrouve aussi l'ensemble des films aux quels il a participé,
  pas forcément en tant qu'acteur.
  On affiche donc uniquement les films pour les quels il a été acteur, c'est a dire les films
  qui ont un original_title, car seuls les films possèdent pas ce champs.
  */
  if (isset($cast->original_title)) {
    echo "<tr><td>$i</td><td>$cast->original_title</td><td>$cast->character</td></tr>";
    $i = $i + 1;
  }

}
echo "</table></tbody>";
echo "</body></html>";
?>
