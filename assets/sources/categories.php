<?php
	if ( !empty($_GET['category'])) {
		$get_category_id = secureEncode($_GET['category']);
		$themeData['new_game_page'] = "games";
		$sql_cat_query = $GameMonetizeConnect->query("SELECT * FROM ".CATEGORIES." WHERE category_pilot='".$get_category_id . "'");
		if ($sql_cat_query->num_rows > 0) {
			$get_category = $sql_cat_query->fetch_assoc();

			$sql_c_games_query = $GameMonetizeConnect->query("SELECT * FROM ".GAMES." WHERE category = '{$get_category['id']}' AND published = '1' ORDER BY featured DESC limit 50");
			$themeData['category_name'] = $get_category['name'];
			if ($sql_c_games_query->num_rows > 0) {
				$ctgm_r = '';
				$ids = '';
				while($cat_games = $sql_c_games_query->fetch_array()) {
					$get_game_data = gameData($cat_games);
					$themeData['category_game_name'] = $get_game_data['name'];
					$themeData['category_game_url'] = $get_game_data['game_url'];
					$themeData['category_game_image'] = $get_game_data['image_url'];
					$themeData['category_game_rating'] = $cat_games['rating'];
					$themeData['category_game_video_url'] = $cat_games['video_url'];

					$ctgm_r .= \GameMonetize\UI::view('category/category-games-list');

					$ids .= $cat_games['game_id'] .',';
				}
				$themeData['category_games_list'] = $ctgm_r;

			} else {
				$themeData['category_games_list'] = \GameMonetize\UI::view('category/category-games-notfound');
			}
			$themeData['categoryid'] = $get_category['id'];
			$themeData['footer_description'] = htmlspecialchars_decode($get_category['footer_description']);
			$themeData['new_game_ids'] .= rtrim($ids, ',');
			$themeData['category_content'] = \GameMonetize\UI::view('category/category-games');
		} else {
			$themeData['category_content'] = \GameMonetize\UI::view('category/category-notfound');
		}
	} 

	else {
		$sql_cat_query = $GameMonetizeConnect->query("SELECT * FROM ".CATEGORIES);
		$ct_r = '';
		while($category = $sql_cat_query->fetch_array()) {
			$themeData['category_id'] = $category['id'];
			$themeData['category_name'] = $category['name'];
			$themeData['category_thumb'] = siteUrl() . $category['image'];

			$numbergames = $GameMonetizeConnect->query("SELECT COUNT(*) FROM " . GAMES ." where category=".$category['id']);
			$numbergames = $numbergames->fetch_array()[0];

			$themeData['category_number'] = $numbergames;
			$themeData['category_url'] = siteUrl() . '/category/'	. slugify($category['name']);
			$ct_r .= \GameMonetize\UI::view('category/categories-list');
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

		$footer_description = getFooterDescription('categories');

		$themeData['footer_description'] = isset($footer_description->description) ? htmlspecialchars_decode($footer_description->description): "";

		$themeData['category_content'] = \GameMonetize\UI::view('category/categories');
	}
	$themeData['page_content'] = \GameMonetize\UI::view('category/content');

