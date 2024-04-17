<?php
include dirname( __FILE__ ) . '/gm-load.php';

$rssItem = "";
$newGames_query = $GameMonetizeConnect->query("SELECT * FROM ".GAMES." ORDER BY game_id DESC LIMIT 20");
while($newGames = $newGames_query->fetch_array()) {
    $newGame_data = gameData($newGames);
    $rssItem .= "<item>
                <title>" . ($newGame_data['name']) . "</title>
                <link>" . siteUrl() . $newGame_data['game_name'] . "</link>
                <guid>" . siteUrl() . $newGame_data['game_name'] . "</guid>
                <image:image>
                    <image:loc>".$newGame_data['image_url']."</image:loc>
                </image:image>
                <description><![CDATA[ <img src='".$newGame_data['image_url']."'>" . strip_tags($newGame_data['description']) . " ]]></description>
                <pubDate>".date('D, d M Y H:i:s O', $newGames['date_added'])."</pubDate> 
            </item>";
}
$rss = "<?xml version='1.0' encoding='utf-8'?>
            <rss version='2.0'
                xmlns:dc='http://purl.org/dc/elements/1.1/'
                xmlns:sy='http://purl.org/rss/1.0/modules/syndication/'
                xmlns:admin='http://webns.net/mvcb/'
                xmlns:rdf='http://www.w3.org/1999/02/22-rdf-syntax-ns#'
                xmlns:content='http://purl.org/rss/1.0/modules/content/'
                xmlns:image='http://www.google.com/schemas/sitemap-image/1.1'
                xmlns:atom='http://www.w3.org/2005/Atom'>
            <channel>
                <title>".$config['site_name']."</title>
            
                <link>".$config['site_url']."/feed</link>
                <description>".$config['site_description']."</description>
                <dc:language>en-us</dc:language>
                <dc:creator>$creator_email</dc:creator>
                <dc:rights>Copyright " . (gmdate("Y", time())) . "</dc:rights>
                <atom:link href='".$config['site_url']."/feed' rel='self' type='application/rss+xml' />
                $rssItem
                </channel>
            </rss> ";
header("Content-Type: application/rss+xml; charset=UTF-8");
echo $rss;
