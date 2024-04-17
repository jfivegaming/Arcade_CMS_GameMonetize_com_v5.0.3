<?php
$themeData['ads_header'] = getADS('728x90');
$themeData['ads_footer'] = getADS('300x250');
$themeData['ads_sidebar'] = getADS('600x300');

$date =  date('Ymdms');
$date = strtotime($date);
$themeData['cms'] = "<script src='https://api.gamemonetize.com/cms.js?" . $date . "'></script>";
# >>
$themeData['new_game_page'] = "played";

if (!isset($_COOKIE['playedgames'])) {
	$themeData['games_played'] = "<div class='category-section-top' style='text-align:center;font-size:20px;margin-bottom:10px;margin-top:20px;'>
		<i class='fa fa-chevron-right'></i></span><strong style='color:#fc0'>
You didn't play any game recently. Games you played will appear here.</strong>
</div>";

	$footer_description = getFooterDescription('played-games');
	$themeData['footer_description'] = isset($footer_description->description) ? htmlspecialchars_decode($footer_description->description): "";
	$themeData['new_games'] = \GameMonetize\UI::view('game/new-games');

	$themeData['page_content'] = \GameMonetize\UI::view('home/content');
} else {
	$fav = explode(',,', $_COOKIE['playedgames']);
	$ngm_r = '';
	// remove empty values from $fav
	if (strlen($_COOKIE['playedgames']) > 0) {
		foreach ($fav as $game_id) {
			$resultset[] = $game_id;
		}
		$string = implode(",", $resultset);
		$str = trim($string, ",");
		$comma_separated = rtrim($str, ',');
		$newGames_query = $GameMonetizeConnect->query("SELECT * FROM " . GAMES . " where `game_id` IN (" . $comma_separated . ") order by date_added DESC LIMIT 100");

		while ($newGames = $newGames_query->fetch_array()) {
			$newGame_data = gameData($newGames);
			$themeData['new_game_url'] = $newGame_data['game_url'];
			$themeData['new_game_image'] = $newGame_data['image_url'];
			$themeData['new_game_name'] = $newGame_data['name'];
			$themeData['new_game_rating'] = $newGames['rating'];
			$themeData['new_game_video_url'] = $newGames['video_url'];

			$ngm_r .= \GameMonetize\UI::view('game/list-each/new-games-list');
		}
	}

	$footer_description = getFooterDescription('played-games');
	$themeData['footer_description'] = isset($footer_description->description) ? htmlspecialchars_decode($footer_description->description): "";

	$themeData['new_games_list'] = $ngm_r;
	$themeData['new_games'] = \GameMonetize\UI::view('game/new-games');

	$themeData['page_content'] = \GameMonetize\UI::view('home/content');
}
