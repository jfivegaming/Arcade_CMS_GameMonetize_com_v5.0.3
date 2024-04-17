<?php
$date =  date('Ymdms');
$date = strtotime($date);
$themeData['cms'] = "<script type='text/javascript' src='https://api.gamemonetize.com/cms.js?" . $date . "'></script>";
$themeData['ima_sdk'] = "<script type='text/javascript'  src='//imasdk.googleapis.com/js/sdkloader/ima3.js'></script>
<script type='text/javascript' src='https://api.gamemonetize.com/imasdk.js?" . $date . "'></script>";
$ads_video_code = getADS('ads_video');

if (getADS('ads_video')) {
    if (!preg_match('/\bdescription_url\b/', $ads_video_code)) {
        $themeData['ads_video'] = getADS('ads_video') . '&description_url=" + encodeURIComponent(descriptionURL) + "&correlator=' . $date;
    }
    if (preg_match('/\bdescription_url\b/', $ads_video_code)) {
        $themeData['ads_video'] = getADS('ads_video') . '" + encodeURIComponent(descriptionURL) + "&videoad_start_delay=0&hl=en&max_ad_duration=30000&correlator=' . $date;
    }
} else {
    $themeData['ads_video'] = getADS('ads_video');
}
if (!empty($_GET['id'])) {
    $get_game_id = $_GET['id'];

    $get_game = getGame2($get_game_id);

    if ($get_game) {
        $get_game_data = gameData($get_game);
        $themeData['ads_header'] = getADS('728x90');
        $themeData['ads_header_display'] = '';
        $themeData['game_col_margin_top'] = 0;
        if(strlen($themeData['ads_header']) < 1){
            $themeData['game_col_margin_top'] = 85;
            $themeData['ads_header_display'] = 'none';
        }
        $themeData['ads_header_hide'] = "";
        if ($themeData['ads_header'] == "") {
            $themeData['ads_header_hide'] = "hide";
        }
        $actual_link = $config['theme_path'];
        if (getADS('300x250') != "") {
            $themeData['ads_footer'] = getADS('300x250');
        } else {
            $themeData['ads_footer'] = '<a class="ad300" href="https://gamemonetize.com/" target="_blank" style="display: inline;"><img src="' . $actual_link . '/image/banner/1450344261.jpg"></a>
                    <a class="ad300" href="https://gamemonetize.com/" target="_blank" style="display: none;"><img src="' . $actual_link . '/image/banner/1448529775.jpg"></a>
                    <a class="ad300" href="https://gamemonetize.com/" target="_blank" style="display: none;"><img src="' . $actual_link . '/image/banner/1453363439.jpg"></a>
                    <a class="ad300" href="https://gamemonetize.com/" target="_blank" style="display: none;"><img src="' . $actual_link . '/image/banner/1449131593.jpg"></a>
                    <a class="ad300" href="https://gamemonetize.com/" target="_blank" style="display: none;"><img src="' . $actual_link . '/image/banner/1455786054.jpg"></a>
                    <a class="ad300" href="https://gamemonetize.com/" target="_blank" style="display: none;"><img src="' . $actual_link . '/image/banner/1456391965.jpg"></a>
                    <a class="ad300" href="https://gamemonetize.com/" target="_blank" style="display: none;"><img src="' . $actual_link . '/image/banner/1450951822.jpg"></a>
                    <a class="ad300" href="https://gamemonetize.com/" target="_blank" style="display: none;"><img src="' . $actual_link . '/image/banner/1449733199.jpg"></a>';
        }
        $sidebar_ads = getADS('600x300');
        if ($sidebar_ads != "") {
            $themeData['ads_sidebar'] = '<div class="ad160 bgs fn-left">
                                                    Advertisement
                                                    ' . $sidebar_ads . '
                                                </div>';
        } else {
            $themeData['ads_sidebar'] = '<div class="fn-left" style="width: 160px;text-align: center;padding: 10px;"></div>';
        }
        $themeData['play_game_embed'] = $get_game_data['embed'];
        $themeData['play_game_embed2'] = $get_game_data['file'];
        $themeData['play_game_name'] = $get_game_data['name'];
        $themeData['play_game_image'] = $get_game_data['image_url'];
        $themeData['play_game_url'] = $get_game_data['game_url'];
        $themeData['play_game_date'] = $get_game_data['date_added'];
        $themeData['play_game_plays'] = $get_game_data['plays'];
        $themeData['play_game_desc'] = $get_game_data['description'];
        $themeData['play_game_inst'] = $get_game_data['instructions'];
        $themeData['play_game_rating'] = $get_game['rating'];
        $themeData['play_game_id'] = $get_game['game_id'];
        $themeData['play_game_ads_counter'] = ($config['ads_status']) ? \GameMonetize\UI::view('game/play-ads-counter') : '';
        $themeData['play_game_display'] = ($config['ads_status']) ? 'display:none;' : '';
        $themeData['play_game_video_url'] = $get_game['video_url'];
        $themeData['play_game_walkthrough'] = "Walkthrough";
        if(strlen($get_game['video_url'])){
            $themeData['play_game_walkthrough'] = "<a href='".$get_game['video_url']."' target='_blank'>Walkthrough</a>";
        }

        $similarGames = getSidebarWidget('similar-name', $get_game_data['name']);
        $themeData['play_sidebar_widgets'] = $similarGames[0];
        $anotherSimilarGames = getSidebarWidget('similar-name', $get_game_data['name'], $similarGames[1]);
        $themeData['play_sidebar_widgets2'] = $anotherSimilarGames[0];

        $themeData['play_sidebar_widgets3'] = getSidebarWidget('random');
        $themeData['play_sidebar_widgets5'] = getSidebarWidget('top-user');
        $themeData['play_game_featured'] = getFeaturedGames();

        $themeData['play_widget_carousel_random_games'] = getCarouselWidget('carousel_random_games', 3);
        $themeData['description_url'] = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        /* Main page content */
        $gameImage = explode("/", $themeData['game_meta_image']);
        $themeData['game_unique_id'] = $gameImage[3];

        // Game tags
        $gameTags = $get_game["tags_ids"];
        $tags_list = "";
        if (!is_null($gameTags) && $gameTags != 'null') {
            $gameTags = str_replace("[", "(", $gameTags);
            $gameTags = str_replace("]", ")", $gameTags);
            $sqlGetTags = "SELECT * FROM " . TAGS . " WHERE id IN{$gameTags} ORDER BY name";
            $sqlQueryTags = $GameMonetizeConnect->query($sqlGetTags);
            if ($sqlQueryTags->num_rows > 0) {
                while ($tags = $sqlQueryTags->fetch_array()) {
                    $themeData['tags_url'] = siteUrl() . "/tag/" . $tags['url'];
                    $themeData['tags_name'] = ucwords($tags['name']);
                    $tags_list .= \GameMonetize\UI::view('game/tags/tags-list');
                }
            } else {
                $tags_list .= "No tags found.";
            }

            $themeData["tags_list"] = $tags_list;
        }

        $themeData["play_game_tags"] = \GameMonetize\UI::view('game/tags/tags-element');
        $themeData['page_content'] = \GameMonetize\UI::view('game/play');
    } else {
        $themeData['page_content'] = \GameMonetize\UI::view('game/error');
    }
} else {
    $themeData['page_content'] = \GameMonetize\UI::view('game/error');
}
