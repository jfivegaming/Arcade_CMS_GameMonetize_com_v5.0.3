<?php
if (!defined('R_PILOT')) {
    exit();
}

deleteAllExistingXml();

// Games data
$allGames = "SELECT * FROM `" . GAMES . "`";
$allGames = $GameMonetizeConnect->query($allGames);
$allGamesCount = $allGames->num_rows;

$gamePages = floor($allGamesCount / 1000);
$isThereMod = $allGamesCount % 1000;
if ($isThereMod > 0) {
    $gamePages++;
}

$xmlGames = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?>' . '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"></urlset>');
$i = 1;
$currentGamePageCount = 1;
while ($game = $allGames->fetch_assoc()) {
    if ($i % 1000 == 0) {
        $isSuccessGames = $xmlGames->asXML('./' . $currentGamePageCount . '000games.xml');
        $currentGamePageCount++;
        $xmlGames = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?>' . '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"></urlset>');
    }
    $gameData = (object)gameData($game);

    $name = $gameData->name;
    $url = $gameData->game_url;

    // Create a new URL element
    $urlElement = $xmlGames->addChild('url');
    $urlElement->addChild('loc', $url);
    $i++;
}
$isSuccessGames = $xmlGames->asXML('./' . $currentGamePageCount . '000games.xml');

// Main sitemap
$xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?>' . '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"></sitemapindex>');
for ($i = 1; $i <= $gamePages; $i++) {
    $urlElement = $xml->addChild('sitemap');
    $urlElement->addChild('loc', siteUrl() . '/' . $i . '000games.xml');
    $urlElement->addChild('lastmod', date('Y-m-d\TH:i:sP', time()));
}

$xmlTypes = ['tags', 'categories', 'blogs'];
foreach ($xmlTypes as $type) {
    $urlElement = $xml->addChild('sitemap');
    $urlElement->addChild('loc', siteUrl() . "/$type.xml");
    $urlElement->addChild('lastmod', date('Y-m-d\TH:i:sP', time()));
}

$isSuccess = $xml->asXML('./sitemap.xml');

// Sitemap for categories
$xmlCategory = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?>' . '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"></urlset>');

$fixedCategories = ['featured-games', 'best-games', 'new-games', 'played-games'];
foreach ($fixedCategories as $cat) {
    $urlElement = $xmlCategory->addChild('url');
    $urlElement->addChild('loc', siteUrl() . '/' . $cat);
}

// Dynamic categories
$allCategories = "SELECT * FROM `" . CATEGORIES . "`";
$allCategories = $GameMonetizeConnect->query($allCategories);
while ($category = $allCategories->fetch_assoc()) {
    $urlElement = $xmlCategory->addChild('url');
    $urlElement->addChild('loc', siteUrl() . '/category/' . seo_friendly_url($category['name']));
}
$xmlCategory->asXML('./categories.xml');

// Dynamic tags
$xmlTags = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?>' . '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"></urlset>');

$allTags = "SELECT * FROM `" . TAGS . "`";
$allTags = $GameMonetizeConnect->query($allTags);
while ($category = $allTags->fetch_assoc()) {
    $urlElement = $xmlTags->addChild('url');
    $urlElement->addChild('loc', siteUrl() . '/tag/' . seo_friendly_url($category['name']));
}
$xmlTags->asXML('./tags.xml');

// Dynamic blogs
$xmlBlog = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?>' . '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"></urlset>');

$allBlogs = "SELECT * FROM `" . BLOGS . "`";
$allBlogs = $GameMonetizeConnect->query($allBlogs);
while ($blog = $allBlogs->fetch_assoc()) {
    $urlElement = $xmlBlog->addChild('url');
    $urlElement->addChild('loc', siteUrl() . '/blog/' . seo_friendly_url($blog['title']));
}
$xmlBlog->asXML('./blogs.xml');

if ($isSuccess) {
    $data['success_message'] = 'Sitemap generated successfully';
    $data['status'] = 200;
} else {
    $data['error_message'] = 'Sitemap generation failed';
}

function seo_friendly_url($string)
{
    $string = str_replace(array('[\', \']'), '', $string);
    $string = preg_replace('/\[.*\]/U', '', $string);
    $string = preg_replace('/&(amp;)?#?[a-z0-9]+;/i', '-', $string);
    $string = htmlentities($string, ENT_COMPAT, 'utf-8');
    $string = preg_replace('/&([a-z])(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig|quot|rsquo);/i', '\\1', $string);
    $string = preg_replace(array('/[^a-z0-9]/i', '/[-]+/'), '-', $string);
    return strtolower(trim($string, '-'));
}

function deleteAllExistingXml()
{
    // Target directory
    // $directory = "../../".__DIR__; // This sets the directory to the current directory of the script
    $directory = __DIR__ . '/../../..';

    // Open the directory
    if ($handle = opendir($directory)) {

        // Loop through the directory
        while (false !== ($file = readdir($handle))) {
            // Check if the file is an XML file
            if (pathinfo($file, PATHINFO_EXTENSION) == 'xml') {
                // Construct the full path to the file
                $filePath = $directory . '/' . $file;

                // Attempt to delete the file
                if (unlink($filePath)) {
                    // echo "Deleted $file\n";
                } else {
                    // echo "Failed to delete $file\n";
                }
            }
        }

        // Close the directory handle
        closedir($handle);
    } else {
        // echo "Could not open the directory.";
    }
}
