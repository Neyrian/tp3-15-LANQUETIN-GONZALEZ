
<?php
require_once("tp3-helpers.php");

echo '<html>';
if (isset($_GET["code"])) {

  $code_film = $_GET["code"];
  $json_brut = tmdbget("movie/$code_film");
  $jsondecode = json_decode($json_brut);

  if (isset($jsondecode->title)) {
    $title = $jsondecode->title;
    $original_title = $jsondecode->original_title;
    $description = $jsondecode->overview;
    $tagline = $jsondecode->tagline;

    echo "<head><title>$title</title><meta charset=\"UTF-8\"><link rel=\"stylesheet\" type=\"text/css\"/></head><body>";
    echo "<p>Title : $title<br>Original Title : $original_title<br>Description : $description<br>Tagline : $tagline<br></p>";

    $url_title = str_replace(" ", "-", $title);
    $url = "https://www.themoviedb.org/movie/$code_film-$url_title";
    echo "<a href=$url >$url</a>" ;
  } else {
    echo "<head><title>Code Invalide</title><meta charset=\"UTF-8\"><link rel=\"stylesheet\" type=\"text/css\"/></head><body>";
    echo '<p>Le code ne correspond a aucun film, veuiller rentrer un code valide<br></p>';
  }

} else {
  echo "<head><title>Entrer code film</title><meta charset=\"UTF-8\"><link rel=\"stylesheet\" type=\"text/css\"/></head><body>";
  echo "<p> Veuillez entrer dans l'url le code du film</p>";
}
echo "</body></html>";
?>
