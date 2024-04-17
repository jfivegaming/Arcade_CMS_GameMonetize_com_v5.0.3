<?php
$page_language = 'en-us';
$creator_email = '';

header("Content-Type: application/rss+xml");

$rss = "<?xml version='1.0' encoding='utf-8'?>\n";
$rss .= "<rss version='2.0'
            xmlns:dc='http://purl.org/dc/elements/1.1/'
            xmlns:sy='http://purl.org/rss/1.0/modules/syndication/'
            xmlns:admin='http://webns.net/mvcb/'
            xmlns:rdf='http://www.w3.org/1999/02/22-rdf-syntax-ns#'
            xmlns:content='http://purl.org/rss/1.0/modules/content/'
            xmlns:image='http://www.google.com/schemas/sitemap-image/1.1'
            xmlns:atom='http://www.w3.org/2005/Atom'
        >";

$rss .= "<channel>

            <title>".$config['site_name']."</title>
        
            <link>".$config['site_url']."</link>
            <description>".$config['site_description']."</description>
            <dc:language>$page_language</dc:language>
            <dc:creator>$creator_email</dc:creator>";

$rss .= "<dc:rights>Copyright " . (gmdate("Y", time())) . "</dc:rights>";
$rss .= "<admin:generatorAgent rdf:resource='http://www.codeigniter.com/' />";
$rss .= "<atom:link href='{{CONFIG_SITE_URL}}' rel='self' type='application/rss+xml' />";

// $newGames_query = $GameMonetizeConnect->query("SELECT * FROM ".GAMES." ORDER BY game_id DESC LIMIT 20");
// var_dump($GameMonetizeConnect);
// var_dump($newGames_query);
// die;
// while($newGames = $newGames_query->fetch_array()) {
//     $newGame_data = gameData($newGames);
//     $rss .= "<item>
//             <title>" . ($newGame_data['name']) . "</title>
//             <link>" . siteUrl() . $newGame_data['game_name'] . "</link>
//             <guid>" . siteUrl() . $newGame_data['game_name'] . "</guid>
//                 <image:image>
//                     <image:loc>".$newGame_data['image_url']."</image:loc>
//                 </image:image>
//                 <description><![CDATA[ <img src='".$newGame_data['image_url']."'>" . strip_tags($newGame_data['description']) . " ]]></description>
//                 <pubDate>";
//     // var_dump($newGames);die;
//     $rss .= date('Y-m-d H:i:s', strtotime($newGames['date_added']));
//     // $rss .= date_format($date, 'r');
//     // var_dump($rss);die;
//     $rss .= "</pubDate>
//             </item>";
// }
$rss .= "
            </channel>
        </rss>";
echo $rss;
// die;
