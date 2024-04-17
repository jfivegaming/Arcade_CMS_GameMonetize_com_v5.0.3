<?php
	$themeData['ads_300'] = getADS('300x250_main');
	$themeData['ads_top'] = getADS('728x90_main');
	$date =  date('Ymdms');
	$date = strtotime($date);
	$themeData['cms'] = "<script src='https://api.gamemonetize.com/cms.js?". $date . "'></script>";

	$newGames_query = $GameMonetizeConnect->query("SELECT * FROM ".GAMES." WHERE published='1' ORDER BY featured DESC, date_added desc, featured_sorting desc LIMIT 65");
	$ngm_r = '';
	$ids = '';
	while ($newGames = $newGames_query->fetch_array()) {
		$newGame_data = gameData($newGames);
		$themeData['new_game_url'] = $newGame_data['game_url'];
		$themeData['new_game_image'] = $newGame_data['image_url'];
		$themeData['new_game_name'] = $newGame_data['name'];
		$themeData['new_game_video_url'] = $newGames['video_url'];
		
		$themeData['new_game_featured'] = $newGame_data['featured'];

		$ids .= $newGames['game_id'] .',';

		$ngm_r .= \GameMonetize\UI::view('game/list-each/new-games-list');
	}

	 if ($_GET['p'] == 'home') {
        $cat=$_GET["cat"];
            if($cat<>""){
            $cat = str_replace('-', '.', $cat); 
            $cat = ucfirst($cat);
			$themeData['tag_name'] = '<div class="category-section-top" style="text-align:center;font-size:20px;margin-bottom:10px;margin-top:0px;">
	<h1 style="color:#fc0;height: inherit;line-height: inherit;font-size: inherit;text-indent: inherit;font-size:29px;line-height: 25px;">'. $cat .'</h2>
	<h2 style="color:#000;font-size:14px;margin-top:15px;">Play '. $cat .' Free Online at GameFree.Games! We have chosen best '. $cat .' games which you can play online for free. enjoy!</h2>
</div>

';
		}
	}

	$themeData['new_game_ids'] .= rtrim($ids, ',');
	$themeData['new_game_page'] = "games";

	$themeData['new_games_list'] = $ngm_r;

	$footer_description = getFooterDescription('home');

	$themeData['footer_description'] = isset($footer_description->description) ? htmlspecialchars_decode($footer_description->description): "";;
	$themeData['footer_description_has_content'] = isset($footer_description->has_content) ? $footer_description->has_content: "";
	$themeData['footer_description_content_value'] = isset($footer_description->content_value) ? $footer_description->content_value: "";

	$themeData['new_games'] = \GameMonetize\UI::view('game/new-games');

	$themeData['page_content'] = \GameMonetize\UI::view('home/content');