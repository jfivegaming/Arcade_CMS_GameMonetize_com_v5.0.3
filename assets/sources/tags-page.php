<?php
if (!empty($_GET['tag'])) {
	$get_tags_id = secureEncode($_GET['tag']);
	$themeData['new_game_page'] = "games";
	$sql_tag_query = $GameMonetizeConnect->query("SELECT * FROM " . TAGS . " WHERE url='" . $get_tags_id . "'");
	if ($sql_tag_query->num_rows > 0) {
		$get_tags = $sql_tag_query->fetch_array();
		$sql_c_games_query = $GameMonetizeConnect->query("SELECT * FROM " . GAMES . " WHERE tags_ids LIKE '%\"{$get_tags['id']}\"%' AND published = '1' ORDER BY featured DESC limit 50");
		$themeData['tags_name'] = ucwords($get_tags['name']);
		if ($sql_c_games_query->num_rows > 0) {
			$ctgm_r = '';
			$ids = '';
			while ($tag_games = $sql_c_games_query->fetch_array()) {
				$get_game_data = gameData($tag_games);
				$themeData['tags_game_name'] = $get_game_data['name'];
				$themeData['tags_game_url'] = $get_game_data['game_url'];
				$themeData['tags_game_image'] = $get_game_data['image_url'];
				$themeData['tags_game_rating'] = $tag_games['rating'];
				$themeData['tags_game_video_url'] = $tag_games['video_url'];

				$ctgm_r .= \GameMonetize\UI::view('category/tags-games-list');

				$ids .= $tag_games['game_id'] . ',';
			}
			$themeData['tags_games_list'] = $ctgm_r;
		} else {
			$themeData['tags_games_list'] = \GameMonetize\UI::view('category/category-games-notfound');
		}
		$themeData['tagsid'] = $get_tags['id'];

		$themeData['new_game_ids'] .= rtrim($ids, ',');
		$themeData['footer_description'] = htmlspecialchars_decode($get_tags['footer_description']);

		$themeData['tags_content'] = \GameMonetize\UI::view('category/tags-games');
	} else {
		$themeData['tags_content'] = \GameMonetize\UI::view('category/category-notfound');
	}
} else {
	$sql_tag_query = $GameMonetizeConnect->query("SELECT * FROM " . TAGS);
	$ct_r = '';
	while ($tags = $sql_tag_query->fetch_array()) {
		$themeData['tags_id'] = $tags['id'];
		$themeData['tags_name'] = $tags['name'];
		$themeData['tags_thumb'] = siteUrl() . $tags['image'];

		$numbergames = $GameMonetizeConnect->query("SELECT COUNT(*) FROM " . GAMES . " where tags_ids LIKE '%\"{$get_tags['id']}\"%'");
		$numbergames = $numbergames->fetch_array()[0];

		$themeData['tags_number'] = $numbergames;
		$themeData['tags_url'] = siteUrl() . '/tag/' . slugify($tags['name']);
		$ct_r .= \GameMonetize\UI::view('category/tags-list');
	}

	/*
		$countactiongames = $GameMonetizeConnect->query("SELECT COUNT(*) FROM " . GAMES ." where category=1");
		$countactiongames = $countactiongames->fetch_array()[0];

		$countracinggames = $GameMonetizeConnect->query("SELECT COUNT(*) FROM " . GAMES ." where category=2");
		$countracinggames = $countracinggames->fetch_array()[0];

		$countshootinggames = $GameMonetizeConnect->query("SELECT COUNT(*) FROM " . GAMES ." where category=3");
		$countshootinggames = $countshootinggames->fetch_array()[0];

		$countarcadegames = $GameMonetizeConnect->query("SELECT COUNT(*) FROM " . GAMES ." where category=4");
		$countarcadegames = $countarcadegames->fetch_array()[0];

		$countpuzzlegames = $GameMonetizeConnect->query("SELECT COUNT(*) FROM " . GAMES ." where category=5");
		$countpuzzlegames = $countpuzzlegames->fetch_array()[0];

		$countmultiplayergames = $GameMonetizeConnect->query("SELECT COUNT(*) FROM " . GAMES ." where category=7");
		$countmultiplayergames = $countmultiplayergames->fetch_array()[0];

		$countsportsgames = $GameMonetizeConnect->query("SELECT COUNT(*) FROM " . GAMES ." where category=8");
		$countsportsgames = $countsportsgames->fetch_array()[0];

		$countfightinggames = $GameMonetizeConnect->query("SELECT COUNT(*) FROM " . GAMES ." where category=9");
		$countfightinggames = $countfightinggames->fetch_array()[0];

		$themeData['categories_list'] = $ct_r;

		$themeData['count_action_games'] = $countactiongames;
		$themeData['count_racing_games'] = $countracinggames;
		$themeData['count_shooting_games'] = $countshootinggames;
		$themeData['count_arcade_games'] = $countarcadegames;
		$themeData['count_puzzle_games'] = $countpuzzlegames;
		$themeData['count_multiplayer_games'] = $countmultiplayergames;
		$themeData['count_sports_games'] = $countsportsgames;
		$themeData['count_fighting_games'] = $countfightinggames;
		*/
	$themeData['categories_list'] = $ct_r;
	$themeData['tags_content'] = \GameMonetize\UI::view('category/categories');
}
$themeData['page_content'] = \GameMonetize\UI::view('category/tags-content');
