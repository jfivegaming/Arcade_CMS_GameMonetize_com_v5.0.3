<?php

	if (!empty($_GET['id'])) {
       	$get_profile_id = secureEncode($_GET['id']);
        $get_profile_data = getData($get_profile_id, 'id,name,username,avatar_id,last_logged,last_update_info,profile_theme,active,xp');

		if ( $get_profile_data == true ) {
			$get_profile_info = getInfo($get_profile_data['id']);

			$themeData['profile_avatar'] = getAvatar($get_profile_data['avatar_id'], $get_profile_info['gender'], 'medium');
			$themeData['profile_gender'] = ($get_profile_info['gender'] == 1) ? 
				'<img class="img-20" src="'.$config['theme_path'].'/image/icon-color/male.png"> '.$lang['male']: 
				'<img class="img-20" src="'.$config['theme_path'].'/image/icon-color/female.png"> '.$lang['female'];
			$themeData['profile_theme'] = $get_profile_data['profile_theme'];
			$themeData['profile_name'] = $get_profile_data['name'];
			$themeData['profile_about'] = (!empty($get_profile_info['about'])) ? $get_profile_info['about'] : $get_profile_data['name'].' '.$lang['not_description'].'...';
			# >>

			$get_user_games_played = $GameMonetizeConnect->query("SELECT DISTINCT game_id FROM ".USER_GAME." WHERE user_id='{$get_profile_data['id']}' AND type='played' AND game_id!='0' ORDER BY date_added DESC LIMIT 10");
			if ($get_user_games_played->num_rows > 0) {
				$gmplyd_r = '';
				while ( $games_played_row = $get_user_games_played->fetch_array() ) {
					$get_games_played = $GameMonetizeConnect->query("SELECT * FROM ".GAMES." WHERE game_id='{$games_played_row['game_id']}' AND published='1'");
					while( $games_played = $get_games_played->fetch_array() ){
						$get_game_data = gameData($games_played);
						$themeData['profile_game_played_name'] = $get_game_data['name'];
						$themeData['profile_game_played_image'] = $get_game_data['image_url'];
						$themeData['profile_game_played_url'] = $get_game_data['game_url'];

						$gmplyd_r .= \GameMonetize\UI::view('profile/game-played-list');
					}
				}
				$themeData['profile_game_played_list'] = $gmplyd_r;
			} else {
				$themeData['profile_game_played_list'] = \GameMonetize\UI::view('profile/game-played-notfound');
			}
			# >>

			$get_user_favorite_games = $GameMonetizeConnect->query("SELECT game_id FROM ".USER_GAME." WHERE user_id='{$get_profile_data['id']}' AND type='favorite' AND game_id!='0'");
			if ($get_user_favorite_games->num_rows > 0) {
				$gmfvt_r = '';
				while ( $games_favorite_row = $get_user_favorite_games->fetch_array() ) {
					$get_game_favorite = $GameMonetizeConnect->query("SELECT * FROM ".GAMES." WHERE game_id='{$games_favorite_row['game_id']}' AND published='1'");
					while( $games_favorite = $get_game_favorite->fetch_array() ){
						$get_game_data = gameData($games_favorite);
						$themeData['profile_game_favorite_name'] = $get_game_data['name'];
						$themeData['profile_game_favorite_image'] = $get_game_data['image_url'];
						$themeData['profile_game_favorite_url'] = $get_game_data['game_url'];

						$gmfvt_r .= \GameMonetize\UI::view('profile/game-favorite-list');
					}
				}
				$themeData['profile_game_favorite_list'] = $gmfvt_r;
			} else {
				$themeData['profile_game_favorite_list'] = \GameMonetize\UI::view('profile/game-favorite-notfound');
			}

			$themeData['ads_sidebar'] = getADS('column_one');

			$themeData['page_content'] = \GameMonetize\UI::view('profile/content');

		} else { $themeData['page_content'] = \GameMonetize\UI::view('profile/error'); }
    } else { $themeData['page_content'] = \GameMonetize\UI::view('profile/error'); }