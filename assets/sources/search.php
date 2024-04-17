<?php
$themeData['ads_top'] = getADS('728x90_main');

	if(isset($_GET['q']) && !empty($_GET['q'])) {
		$themeData['search_parameter'] = secureEncode($_GET['q']);
		$search_query = searchGames($themeData['search_parameter']);
		$srchgm_r = '';
		foreach ($search_query as $game_search) {
			$get_game_data_search = gameData($game_search);
			$themeData['search_game_url'] = $get_game_data_search['game_url'];
			$themeData['search_game_image'] = $get_game_data_search['image_url'];
			$themeData['search_game_name'] = $get_game_data_search['name'];
			$themeData['search_game_rating'] = $game_search['rating'];
			$themeData['search_game_plays'] = numberFormat($game_search['plays']);
			$themeData['search_game_video_url'] = $game_search['video_url'];
			
			$themeData['search_game_featured'] = $get_game_data_search['featured'];

			$srchgm_r .= \GameMonetize\UI::view('search/search-games-list');
		}

		$themeData['search_games_list'] = $srchgm_r;
		$themeData['search_result'] = ( $search_query ) ? \GameMonetize\UI::view('search/search-result') : \GameMonetize\UI::view('search/search-notfound');

		$footer_description = getFooterDescription('search');
		$themeData['footer_description'] = isset($footer_description->description) ? htmlspecialchars_decode($footer_description->description): "";
		$themeData['search_content'] = \GameMonetize\UI::view('search/search');
	} else {
		$themeData['search_content'] = \GameMonetize\UI::view('search/error');
	}


    $themeData['page_content'] = \GameMonetize\UI::view('search/content');