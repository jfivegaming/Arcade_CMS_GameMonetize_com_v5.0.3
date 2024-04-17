<?php

	if ( is_logged() ) {

		$navigation_menu_data = ( isset($_GET['section']) ) ? $_GET['section'] : 'info';
		$themeData['nav_menu_info'] = listMenu($navigation_menu_data, 'info');
		$themeData['nav_menu_avatar'] = listMenu($navigation_menu_data, 'avatar');
		$themeData['nav_menu_theme'] = listMenu($navigation_menu_data, 'theme');
		$themeData['nav_menu_password'] = listMenu($navigation_menu_data, 'password');
		$themeData['setting_navigation_menu'] = \GameMonetize\UI::view('user/nav-menu');
		# >>

		if (!isset($_GET['section']) or $_GET['section'] == "info") {
			$themeData['gender_male_selected'] = '';
			$themeData['gender_female_selected'] = '';
			if ($userData['gender'] == 1) {
				$themeData['gender_male_selected'] = 'selected';
			} elseif ($userData['gender'] == 2) {
				$themeData['gender_female_selected'] = 'selected';
			}

			$themeData['setting_page_content'] = \GameMonetize\UI::view('user/info');
		} 
		elseif (isset($_GET['section']) && $_GET['section'] == "avatar") {
			$themeData['setting_user_avatar'] = getAvatar($userData['avatar_id'], $userData['gender'], 'medium');
			$themeData['setting_page_content'] = \GameMonetize\UI::view('user/avatar');
		} 
		elseif (isset($_GET['section']) && $_GET['section'] == "theme") {
			$sql_query_theme = $GameMonetizeConnect->query("SELECT * FROM ".THEMES) or die();
			$i = 1;
			$thm_r = '';
			while ( $sql_theme_view = $sql_query_theme->fetch_array() ) {
				$themeData['setting_theme_number'] = $i++;
				$themeData['setting_theme_active_class'] = ($userData['profile_theme'] == $sql_theme_view['theme_class']) ? 'theme_active':'';
				$themeData['setting_theme_id'] = $sql_theme_view['theme_id'];
				$themeData['setting_theme_class'] = $sql_theme_view['theme_class'];
				$themeData['setting_theme_checked'] = ($userData['profile_theme'] == $sql_theme_view['theme_class']) ? 'checked' : '';

				$thm_r .= \GameMonetize\UI::view('user/theme-list');
			}
			$themeData['theme_list'] = $thm_r;
			$themeData['setting_page_content'] = \GameMonetize\UI::view('user/theme');
		}
		elseif (isset($_GET['section']) && $_GET['section'] == "password") {
			$themeData['setting_page_content'] = \GameMonetize\UI::view('user/password');
		} 
		else {
			$themeData['setting_page_content'] = \GameMonetize\UI::view('welcome/error-section');
		}

		$themeData['page_content'] = \GameMonetize\UI::view('user/setting');
	} else {
		$themeData['page_content'] = \GameMonetize\UI::view('welcome/error');
	}