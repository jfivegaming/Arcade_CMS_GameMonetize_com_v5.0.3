<?php
	$themeData['ads_header'] = getADS('728x90');
	$themeData['ads_footer'] = getADS('300x250');
	$themeData['ads_sidebar'] = getADS('600x300');
	$themeData['ads_top'] = getADS('728x90_main');
	
	$date =  date('Ymdms');
	$date = strtotime($date);
	$themeData['cms'] = "<script src='https://api.gamemonetize.com/cms.js?". $date . "'></script>";
	# >>

	$newGames_query = $GameMonetizeConnect->query("SELECT * FROM ".GAMES." WHERE published='1' AND featured='1' ORDER BY date_added DESC");
	$ngm_r = '';
	while ($newGames = $newGames_query->fetch_array()) {
		$newGame_data = gameData($newGames);
		$themeData['new_game_url'] = $newGame_data['game_url'];
		$themeData['new_game_image'] = $newGame_data['image_url'];
		$themeData['new_game_name'] = $newGame_data['name'];
		$themeData['new_game_video_url'] = $newGame_data['video_url'];
	
		$themeData['new_game_featured'] = $newGame_data['featured'];

		$ngm_r .= \GameMonetize\UI::view('game/list-each/new-games-list');
	}

	$footer_description = getFooterDescription('featured-games');
	$themeData['footer_description'] = isset($footer_description->description) ? htmlspecialchars_decode($footer_description->description): "";

	$themeData['new_games_list'] = $ngm_r;
	$themeData['new_games'] = \GameMonetize\UI::view('game/new-games');

	$themeData['page_content'] = \GameMonetize\UI::view('home/content');