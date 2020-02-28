
<?php

/*
Script qui affiche l'ensemble des films de la database de TMDB dont le titre contient 'The lord of the Rings'
Le resultat est affiché dans un tableaux, on y retrouve les informations suivantes :
Pour chaques films, le tritre, la date de sortie, l'id et le casting.
Le casting est affiché dans un tableau avec le nom de l'acteru et son rôle dans le film.
Le nom du l'acteur est hyper-lien vers sa filmographie, et ces différents rôles,(voir tmdb_actor_film.php)

Après ce tableau, le script affiche un second tableau contenant les collections dont le nom contient 'The lord of the Rings'.
Les informations sur les collections sont: le titre de la collection ainsi que son ID.
*/
require_once("tp3-helpers.php");

echo '<html>';

$title = 'The lord of the rings';
$json_brut = tmdbget("search/movie", ['query'=>$title]);
$jsondecode = json_decode($json_brut); // on lit la réponse JSOn du la recherche.

echo "<head><title>$title</title><meta charset=\"UTF-8\"><link rel=\"stylesheet\" type=\"text/css\" href=\"tmdb.css\"/></head><body>";
if ($jsondecode->total_results != 0) {

  echo "<table><tbody>";
  echo "<tr class='info'><td>Titre</td><td>ID</td><td>Date de sortie</td><td>Cast</td></tr>";
  foreach ($jsondecode->results as $res) {
    // on récupère les différentes informations
    $titlef = $res->title;
    $id = $res->id;
    $release_date = $res->release_date;

    // on récupère les crédis du film
    $json_brutVO = tmdbget("movie/$id",['append_to_response' => 'credits']);
    $jsondecodeVO = json_decode($json_brutVO);

    // on affiches les infrmations dans le tableaux.
    echo "<tr><td>$titlef</td><td>$id</td><td>$release_date</td><td>";
    echo "<table>";
    foreach ($jsondecodeVO->credits->cast as $actors) {
      /* ici, l'hyperlien vers la filmographie de l'acteur est créé avec la balise <a>, et on passe en argument, lors de l'appel de
      tmdb_actor_film.php, le nom de l'acteur ainsi que son ID.
      <a href="tmdb_actor_film.php?id=$actors->id&name=$actors->name"?>
      */
      echo "<tr><td><a href=\"tmdb_actor_film.php?id=$actors->id&name=$actors->name\"?>$actors->name</a></td><td>$actors->character</td></tr>";
    }
    echo "</table>";
    echo "</td></tr>";
  }
  echo "</table></tbody>";
}
//on affiche les collections
 echo '<br>';
$json_brut = tmdbget("search/collection", ['query'=>$title]);
$jsondecode = json_decode($json_brut);
if ($jsondecode->total_results != 0) {

  echo "<table><tbody>";
  echo "<tr class='info'><td>Titre collection</td><td>ID collection</td></tr>";
  foreach ($jsondecode->results as $res) {
    $titlec = $res->name;
    $id = $res->id;
    echo "<tr><td>$titlec</td><td>$id</td></tr>";
  }
  echo "</table></tbody>";
}
echo "</body></html>";
?>
