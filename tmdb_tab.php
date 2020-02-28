

<?php
/*
Script qui affiche dans un tableau les informations du film passé en argument dans l'url:
use : tmdb_tab.php?code=XX; avec XX le code du films
Les informations sont organisées dans un tableau.
On y retrouve le Titre, la Tagline, la description, le lien vers la page tmdb, en VO,  VF, et VEN.
On y trouve aussi l'affiche du film et tout les trailers disponibles.
*/
require_once("tp3-helpers.php");

echo '<html>';
if (isset($_GET["code"])) {

  $code_film = $_GET["code"]; //on récupère le code du film

  $json_brutVF = tmdbget("movie/$code_film", ['language' => 'fr']);
  $jsondecodeVF = json_decode($json_brutVF); // on lit la réponse JSON du film en VF
  $json_brutVEN = tmdbget("movie/$code_film", ['language' => 'en']);
  $jsondecodeVEN = json_decode($json_brutVEN);// on lit la réponse JSON du film en VEN
  if (isset($jsondecodeVEN->original_language)) {
    $json_brutVO = tmdbget("movie/$code_film", ['language' => $jsondecodeVEN->original_language]);
    $jsondecodeVO = json_decode($json_brutVO); // on lit la réponse JSON du film en VEN
  }

  //on verifie si le film existe, donc qu'on a saisi un code valide
  if (isset($jsondecodeVO->title) && isset($jsondecodeVF->title) && isset($jsondecodeVEN->title)) {
    // on récupère les informations en VO
    $titleVO = $jsondecodeVO->title;
    $descriptionVO = $jsondecodeVO->overview;
    $taglineVO = $jsondecodeVO->tagline;

    // on récupère les informations en VF
    $titleVF = $jsondecodeVF->title;
    $descriptionVF = $jsondecodeVF->overview;
    $taglineVF = $jsondecodeVF->tagline;

    // on récupère les informations en VEN
    $titleVEN = $jsondecodeVEN->title;
    $descriptionVEN = $jsondecodeVEN->overview;
    $taglineVEN = $jsondecodeVEN->tagline;


    echo "<head><title>$titleVO</title><meta charset=\"UTF-8\"><link rel=\"stylesheet\" type=\"text/css\" href=\"tmdb.css\"/></head><body>";

    echo "<table><tbody>";

    echo "<tr class='info'><td></td><td>VO</td><td>VF</td><td>VEN</td></tr>";
    // Affichage de la ligne des titres
    echo "<tr><td class='info'>Titre</td> <td>$titleVO</td><td>$titleVF</td><td>$titleVEN</td></tr>";
    // Affichage de la ligne des tagline
    echo "<tr><td class='info'>Tagline</td> <td>$taglineVO</td><td>$taglineVF</td><td>$taglineVEN</td></tr>";
    // Affichage de la ligne des description
    echo "<tr><td class='info'>Description</td> <td>$descriptionVO</td><td>$descriptionVF</td><td>$descriptionVEN</td></tr>";

    // on cre les urls correspondans aux differntes pages du film dans les langages correspondant.
    $url_title = str_replace(" ", "-", $titleVO);
    $urlVO = "https://www.themoviedb.org/movie/$code_film-$url_title?language=$jsondecodeVO->original_language";
    $urlVF = "https://www.themoviedb.org/movie/$code_film-$url_title?language=fr";
    $urlVEN = "https://www.themoviedb.org/movie/$code_film-$url_title?language=en";
    // Affichage de la ligne des liens
    echo "<tr><td class='info'>Lien</td><td><a href=$urlVO>$urlVO</a></td><td><a href=$urlVF>$urlVF</a></td><td><a href=$urlVEN>$urlVEN</a></td>";

    // on recupère l'image de l'affiche du film et on l'affihce
    $url_base = "http://image.tmdb.org/t/p/";
    $size = "w500";
    $poster = $jsondecodeVO->poster_path;
    echo "<tr><td class='info'>Affiche</td><td colspan = 3><img src = $url_base$size$poster></img></td></tr> ";

    //on recupère l'ensemble des trailers disponnibles, et on les affiches dans le tableau.
    $json_brutVideo = tmdbget("movie/$code_film/videos");
    $jsondecodeVideo = json_decode($json_brutVideo);
    $i = 1;
    foreach ($jsondecodeVideo->results as $video) {
      $urlV = "https://www.youtube.com/embed/$video->key";
      echo "<tr><td class='info'>Trailer $i</td><td colspan = 3><iframe width=\"540\" height=\"360\" src=$urlV frameborder=\"0\" allow=\"accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe></td></tr>";
      $i = $i +1;
    }
    echo "</table></tbody>";

  } else {
    // si le code est invalide, alors on affiche ce message
    echo "<head><title>Code Invalide</title><meta charset=\"UTF-8\"><link rel=\"stylesheet\" type=\"text/css\"/></head><body>";
    echo '<p>Le code ne correspond a aucun film, veuiller rentrer un code valide<br></p>';
  }

} else {
  echo "<head><title>Entrer code film</title><meta charset=\"UTF-8\"><link rel=\"stylesheet\" type=\"text/css\"/></head><body>";
  echo "<p> Veuillez entrer dans l'url le code du film</p>";
}
echo "</body></html>";
?>
