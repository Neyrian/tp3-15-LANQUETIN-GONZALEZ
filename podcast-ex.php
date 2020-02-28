<?php
require_once('vendor/dg/rss-php/src/Feed.php');
$url = "http://radiofrance-podcast.net/podcast09/rss_14312.xml";
$rss = Feed::loadRss($url);
echo 'Title: ', $rss->title;
echo 'Description: ', $rss->description;
echo 'Link: ', $rss->link;

foreach ($rss->item as $item) {
 print_r($rss->item);
}
 ?>
