<?php
require_once('vendor/dg/rss-php/src/Feed.php');
$url = "http://radiofrance-podcast.net/podcast09/rss_14312.xml";
$rss = Feed::loadRss($url);
$title = $rss->title;
$des = $rss->description;
$link = $rss->link;

echo '<html>';
echo "<head><title>$title</title><meta charset=\"UTF-8\"><link rel=\"stylesheet\" type=\"text/css\"/ href=\"rss.css\"></head><body>";

echo "<t>$title</t>";
echo "<p>Description : $des<br>Lien : $link <br></p>";
echo "<table><tbody>";
echo "<tr><td>Date</td><td>Nom</td><td>Audio</td><td>Durée</td><td>Lien de téléchargement</td></tr>";
foreach ($rss->item as $item) {
  echo '<tr>';
  echo '<td>', $item->pubDate, '</td>';
  echo '<td>',$item->title, '</td>';
  $url_audio = $item->enclosure->attributes()['url'];
  $audio_type = $item->enclosure->attributes()['type'];
  echo "<td><audio controls=\"controls\"><source src=$url_audio type=$audio_type>Votre navigateur n'est pas compatible.</audio></td>";
  echo '<td>', $item->{"itunes:duration"}, '</td>';
  echo "<td><a href=$url_audio target=\"download\">Download</a></td>";
  echo '</tr>';
}
echo "</table></tbody></body></html>";
 ?>
