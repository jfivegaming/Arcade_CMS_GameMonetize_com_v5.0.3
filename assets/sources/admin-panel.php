<?php

	$date =  date('Ymdms');
	$date = strtotime($date);
	$themeData['cms'] = "<script src='https://api.gamemonetize.com/cms.js?". $date . "'></script>";

	if ( is_logged() && $userData['admin'] ) {

		$json = file_get_contents( 'https://api.gamemonetize.com/cms_admin.json?'. $date );
		$arr = json_decode($json, true);
		$domain = $_SERVER['HTTP_HOST'];
		$domain = preg_replace('#^(http(s)?://)?w{3}\.#', '$1', $domain);

		foreach($arr['response']['games'] as $game) {
			    if($game['domain'] === $domain) {
			         header("Location: https://gamemonetize.com?utm_source=blockedcms&domain=". $domain);
			        break;
			    }
		}

		$date =  date('Ymdms');
		$date = strtotime($date);

		$themeData['news'] = '<div class="stats-box" style="width:100%;padding:10px;">
				<iframe style="min-height: 198px;" src="https://api.gamemonetize.com/cms.html?'. $date. '" width="100%" height="100%" scrolling="none" frameborder="0"></iframe>
				</div>';

		$navigation_menu_data = ( isset($_GET['section']) ) ? $_GET['section'] : 'global';
		$themeData['nav_menu_global'] = listMenu($navigation_menu_data, 'global');
		$themeData['nav_menu_addgame'] = listMenu($navigation_menu_data, 'addgame');
		$themeData['nav_menu_setting'] = listMenu($navigation_menu_data, 'setting');
		$themeData['nav_menu_games'] = listMenu($navigation_menu_data, 'games');
		$themeData['nav_menu_categories'] = listMenu($navigation_menu_data, 'categories');
		$themeData['nav_menu_users'] = listMenu($navigation_menu_data, 'users');
		$themeData['nav_menu_ads'] = listMenu($navigation_menu_data, 'ads');
		$themeData['nav_menu_tags'] = listMenu($navigation_menu_data, 'tags');
		$themeData['nav_menu_footer_description'] = listMenu($navigation_menu_data, 'footerdescription');
		$themeData['nav_menu_blogs'] = listMenu($navigation_menu_data, 'blogs');
		$themeData['admin_navigation_menu'] = \GameMonetize\UI::view('admin/nav-menu');
		$themeData['sitemap_xml_link'] = siteUrl() . '/sitemap.xml';
		$themeData['rss_feed_link'] = siteUrl() . '/feed';
		if (!isset($_GET['section']) || $_GET['section'] == "global") {

			$gameplay = $GameMonetizeConnect->query("SELECT * FROM ".SETTING." WHERE id='1'");
			$gameplay = $gameplay->fetch_array()[14];
			$themeData['admin_stats_games'] = getStats('games');
			$themeData['admin_stats_users'] = getStats('users');
			$themeData['admin_stats_categories'] = $gameplay;

			$getLastUser_registered = lastUser('registered', 4);
			$lsturgtd_r = '';
			foreach ($getLastUser_registered as $last_user) {
				$getInfo = getInfo($last_user['id']);
				$themeData['stats_user_avatar'] = getAvatar($last_user['avatar_id'], $getInfo['gender'], 'thumb');
				$themeData['stats_user_name'] = $last_user['name'];
				$themeData['stats_user_username'] = $last_user['username'];

				$lsturgtd_r .= \GameMonetize\UI::view('admin/stats-list-user');
			}
			$themeData['stats_last_user_registered_list'] = $lsturgtd_r;
			# >>

			$getLastUser_registered = lastUser('logged', 4);
			$lstulggd_r = '';
			foreach ($getLastUser_registered as $last_user) {
				$getInfo = getInfo($last_user['id']);
				$themeData['stats_user_avatar'] = getAvatar($last_user['avatar_id'], $getInfo['gender'], 'thumb');
				$themeData['stats_user_name'] = $last_user['name'];
				$themeData['stats_user_username'] = $last_user['username'];

				$lstulggd_r .= \GameMonetize\UI::view('admin/stats-list-user');
			}
			$themeData['stats_last_user_logged_list'] = $lstulggd_r;
			# >>

			$themeData['page_admin_content'] = \GameMonetize\UI::view('admin/stats');
		} 

		elseif (isset($_GET['section']) && $_GET['section'] == "addgame") {
			$addgame_category = $GameMonetizeConnect->query("SELECT * FROM ".CATEGORIES." WHERE id!=0");
			$ctop_r = '';
			while ( $select_category = $addgame_category->fetch_array() ) {
				$ctop_r .='<option value="'.$select_category['id'].'">'.$select_category['name'].'</option>';
			}
			$themeData['get_categories'] = $ctop_r;

			$addgame_tags = $GameMonetizeConnect->query("SELECT * FROM ".TAGS." WHERE id!=0 ORDER BY name");
			$game_tags = '';
			while ( $select_tags = $addgame_tags->fetch_array() ) {
				$game_tags .='<option value="'.$select_tags['id'].'">'.$select_tags['name'].'</option>';
			}
			$themeData['get_tags'] = $game_tags;

			$themeData['page_admin_content'] = \GameMonetize\UI::view('admin/add-game');
		}

		elseif (isset($_GET['section']) && $_GET['section'] == "setting") {
			$THEME_dir = opendir('templates/');
			$THEME_dr_array = array();
			while (false !== ($file = readdir($THEME_dir))) {
				$THEME_dr_array[] = $file;
			}
			closedir($THEME_dir);
			$thm_r = '';
			foreach($THEME_dr_array as $file) {
				if ($file != "." && $file != ".." && $file != "Thumbs.db" && $file != ".DS_Store" && $file != "images") {
					if ($config['site_theme'] == $file) {
						$thm_r .= '<option value="'.$file.'" selected>'.$file.'</option>';
					} else {
						$thm_r .= '<option value="'.$file.'">'.$file.'</option>';
					}
				}
			}
			$themeData['setting_get_themes'] = $thm_r;
			# >>

			$LANG_dir = opendir('assets/language/');
			$LANG_dr_array = array();
			while (false !== ($file = readdir($LANG_dir))) {
				$LANG_dr_array[] = $file;
			}
			closedir($LANG_dir);
			$lng_r = '';
			foreach($LANG_dr_array as $file) {
				if ($file != "." && $file != ".." && $file != "Thumbs.db" && $file != ".DS_Store" && $file != "images") {
					$val_file = str_replace('.php', '', $file);
					if ($config['language'] == $val_file) {
						$lng_r .= '<option value="'.$val_file.'" selected>'.$val_file.'</option>';
					} else {
						$lng_r .= '<option value="'.$val_file.'">'.$val_file.'</option>';
					}
				}
			}
			$themeData['setting_get_languages'] = $lng_r;
			# >>

			$themeData['setting_ads_checked'] = ( $config['ads_status'] ) ? 'checked' : '';

			$themeData['page_admin_content'] = \GameMonetize\UI::view('admin/setting');
		}

		elseif (isset($_GET['section']) && $_GET['section'] == "games") {
			if (!isset($_GET['action']) || $_GET['action'] == "view") {
				// Check game feed url
				$settings = $GameMonetizeConnect->query("SELECT * FROM ".SETTING." WHERE id='1'");
				$settings = $settings->fetch_assoc();
				if (is_null($settings['custom_game_feed_url'])) {
					$themeData['custom_game_feed_url'] = 'https://gamemonetize.com/feed.php?format=0&num=30';
				} else {
					$themeData['custom_game_feed_url'] = $settings['custom_game_feed_url'];
				}

				$pageno = isset($_GET['page']) ? (int) $_GET['page'] : 1;
		        $no_of_records_per_page = 102;
		        $offset = ($pageno-1) * $no_of_records_per_page;

		        $result = $GameMonetizeConnect->query("SELECT COUNT(*) FROM " . GAMES);
		        $total_pages = ceil($result->fetch_array()[0] / $no_of_records_per_page);

				$sql_global_games = $GameMonetizeConnect->query("SELECT * FROM ".GAMES." WHERE game_id!=0 ORDER BY date_added DESC LIMIT $offset, $no_of_records_per_page");

				if ( $sql_global_games->num_rows > 0 ) {
					$vgmsgbl_r = '';
					while ( $global_games = $sql_global_games->fetch_array() ) {
						$themeData['view_game_id'] = $global_games['game_id'];
						$themeData['view_game_name'] = $global_games['name'];
						if(strpos($global_games['image'], "http://") !== false || strpos($global_games['image'], "https://") !== false)  {
							$themeData['view_game_image'] =   $global_games['image'];
						} else  {
							$themeData['view_game_image'] = siteUrl() . $global_games['image'];
						}
						$themeData['view_game_featured'] = $global_games['featured'];
						$themeData['view_game_published'] = $global_games['published'];
						$themeData['view_published_class_status'] = ($global_games['published'] == 1) ? 'pub-active' : '';
						$themeData['view_featured_class_status'] = ($global_games['featured'] == 1) ? 'feat-active' : '';

						$vgmsgbl_r .= \GameMonetize\UI::view('admin/sections/view-games-list');
					}
					$themeData['view_games_list'] = $vgmsgbl_r;

					$themeData['view_games_pagination'] = '
					<ul class="pagination">
						<li><a href="'. siteUrl() .'/admin/games/1">First</a></li>
						<li class="' . ( ($pageno <= 1) ? 'disabled' : '' ) .'">
							<a href="' . siteUrl() .'/admin/games'. ( ($pageno <= 1) ? '#' : '/'.($pageno - 1) ) .'">Prev</a>
						</li>
						<li class="' . ( ($pageno >= $total_pages) ? 'disabled' : '' ) .'">
							<a href="' . siteUrl() .'/admin/games'. ( ($pageno >= $total_pages) ? '#' : '/'.($pageno + 1) ) .'">Next</a>
						</li>
						<li><a href="'. siteUrl() .'/admin/games/'. $total_pages .'">Last</a></li>
					</ul>
					';



					$themeData['games_container'] = \GameMonetize\UI::view('admin/sections/view-games-container');
				} else {
					$themeData['games_container'] = \GameMonetize\UI::view('admin/sections/view-games-notfound');
				}

				$themeData['games_section_content'] = \GameMonetize\UI::view('admin/sections/view-games-section');
			}
			elseif (isset($_GET['action']) && $_GET['action'] == "edit" && !empty($_GET['gid'])) {
				$get_game_id = secureEncode($_GET['gid']);
				$get_game = getGame($get_game_id);
				if ( $get_game ) {
					$themeData['edit_game_id'] = $get_game['game_id'];
					$themeData['edit_game_name_url'] = $get_game['game_name'];
					$themeData['edit_game_name'] = $get_game['name'];
					$themeData['edit_game_image'] = $get_game['image'];
					$themeData['edit_game_description'] = $get_game['description'];
					$themeData['edit_game_instructions'] = $get_game['instructions'];
					$themeData['edit_game_file'] = $get_game['file'];
					$themeData['edit_game_width'] = $get_game['w'];
					$themeData['edit_game_height'] = $get_game['h'];
					$themeData['edit_game_sorting'] = $get_game['featured_sorting'];
					$themeData['edit_game_type_swf_status'] = ($get_game['game_type'] == 'swf') ? 'selected' : '';
					$themeData['edit_game_type_other_status'] = ($get_game['game_type'] !== 'swf') ? 'selected' : '';

					$themeData['edit_game_rating_0'] = ($get_game['rating']==0) ? 'selected' : '';
					$themeData['edit_game_rating_0_5'] = ($get_game['rating']==0.5) ? 'selected' : '';
					$themeData['edit_game_rating_1'] = ($get_game['rating']==1) ? 'selected' : '';
					$themeData['edit_game_rating_1_5'] = ($get_game['rating']==1.5) ? 'selected' : '';
					$themeData['edit_game_rating_2'] = ($get_game['rating']==2) ? 'selected' : '';
					$themeData['edit_game_rating_2_5'] = ($get_game['rating']==2.5) ? 'selected' : '';
					$themeData['edit_game_rating_3'] = ($get_game['rating']==3) ? 'selected' : '';
					$themeData['edit_game_rating_3_5'] = ($get_game['rating']==3.5) ? 'selected' : '';
					$themeData['edit_game_rating_4'] = ($get_game['rating']==4) ? 'selected' : '';
					$themeData['edit_game_rating_4_5'] = ($get_game['rating']==4.5) ? 'selected' : '';
					$themeData['edit_game_rating_5'] = ($get_game['rating']==5) ? 'selected' : '';
					$themeData['edit_game_video_url'] = $get_game['video_url'];

					$addgame_category = $GameMonetizeConnect->query("SELECT * FROM ".CATEGORIES." WHERE id!=0");
					$gcts_r = '';
					while ( $select_category = $addgame_category->fetch_array() ) {
						if ($get_game['category'] == $select_category['id']) {
							$gcts_r .= '<option value="'.$select_category['id'].'" selected>'.$select_category['name'].'</option>';
						} else {
							$gcts_r .= '<option value="'.$select_category['id'].'">'.$select_category['name'].'</option>';
						}
					}
					$themeData['edit_game_categories'] = $gcts_r;

					$game_tags = [];
					if ($get_game['tags_ids'] != 'null' && !is_null($get_game['tags_ids'])) {
						$game_tags = json_decode($get_game['tags_ids']);
					}
					$addgame_tags = $GameMonetizeConnect->query("SELECT * FROM ".TAGS." WHERE id!=0");
					$tags_option = '';
					$tags_click_copy = '';
					while ( $select_tags = $addgame_tags->fetch_array() ) {
						if (in_array("{$select_tags['id']}", $game_tags)) {
							$tags_option .= '<option value="'.$select_tags['id'].'" selected>'.$select_tags['name'].'</option>';

							// Tags click copy
							$themeData['tags_url_copy'] = siteUrl() . "/tag/" . $select_tags['url'];
							$themeData['tags_name_copy'] = $select_tags['name'];
							$tags_click_copy .= \GameMonetize\UI::view('admin/sections/tags-click-copy');
						} else {
							$tags_option .= '<option value="'.$select_tags['id'].'">'.$select_tags['name'].'</option>';
						}
					}
					$themeData['edit_game_tags'] = $tags_option;
					$themeData['tags_click_to_copy'] = $tags_click_copy;

					$gameNameExplode = explode(' ', $get_game['name']);
					$firstName = substr($gameNameExplode[0], 0, 4);
					$secondName = substr($gameNameExplode[1], 0, 4);

					// First word similar
					$first_name_click_copy = '';
					$sqlQuerySimilar = $GameMonetizeConnect->query("SELECT * FROM ".GAMES." WHERE name LIKE '%{$firstName}%' AND published='1' AND name != '{$get_game['name']}' ORDER BY name ASC LIMIT 10");
					if ($sqlQuerySimilar->num_rows > 0) {
						while($similarGames = $sqlQuerySimilar->fetch_array()){
							// var_dump($similarGames);die;
							$themeData['tags_url_copy'] = siteUrl() . "/game/" . $similarGames['game_name'];
							$themeData['tags_name_copy'] = $similarGames['name'];
							$first_name_click_copy .= \GameMonetize\UI::view('admin/sections/tags-click-copy');
						}
					}

					$themeData['first_word_click_to_copy'] = $first_name_click_copy;

					// Second word similar
					$second_name_click_copy = '';
					$sqlQuerySimilar = $GameMonetizeConnect->query("SELECT * FROM ".GAMES." WHERE name LIKE '%{$secondName}%' AND published='1' AND name != '{$get_game['name']}' ORDER BY name ASC LIMIT 10");
					if ($sqlQuerySimilar->num_rows > 0) {
						while($similarGames = $sqlQuerySimilar->fetch_array()){
							// var_dump($similarGames);die;
							$themeData['tags_url_copy'] = siteUrl() . "/game/" . $similarGames['game_name'];
							$themeData['tags_name_copy'] = $similarGames['name'];
							$second_name_click_copy .= \GameMonetize\UI::view('admin/sections/tags-click-copy');
						}
					}

					$themeData['second_word_click_to_copy'] = $second_name_click_copy;

					// Random word similar
					$random_name_click_copy = '';
					$sqlQuerySimilar = $GameMonetizeConnect->query("SELECT * FROM ".GAMES." WHERE  published='1' AND name != '{$get_game['name']}' ORDER BY RAND() LIMIT 10");
					if ($sqlQuerySimilar->num_rows > 0) {
						while($similarGames = $sqlQuerySimilar->fetch_array()){
							$themeData['tags_url_copy'] = siteUrl() . "/game/" . $similarGames['game_name'];
							$themeData['tags_name_copy'] = $similarGames['name'];
							$random_name_click_copy .= \GameMonetize\UI::view('admin/sections/tags-click-copy');
						}
					}

					$themeData['random_word_click_to_copy'] = $random_name_click_copy;
					$themeData['games_section_content'] = \GameMonetize\UI::view('admin/sections/edit-games-section');
				} else {
					$themeData['games_section_content'] = \GameMonetize\UI::view('welcome/error-section');
				}
			}
			else {
				$themeData['games_section_content'] = \GameMonetize\UI::view('welcome/error-section');
			}

			$themeData['page_admin_content'] = \GameMonetize\UI::view('admin/games');
		}

		elseif (isset($_GET['section']) && $_GET['section'] == "categories") {
			if (!isset($_GET['action']) || $_GET['action'] == "view") {
				$sql_global_categories = $GameMonetizeConnect->query("SELECT * FROM ".CATEGORIES." WHERE id!=0");
				$gcts_r = '';
				while ($global_categories = $sql_global_categories->fetch_array() ) {
					$themeData['view_category_id'] = $global_categories['id'];
					$themeData['view_category_name'] = $global_categories['name'];
					$themeData['view_category_image'] = $global_categories['image'];
					$themeData['view_category_button_delete'] = ($global_categories['id'] != 1) ? \GameMonetize\UI::view('admin/sections/view-categories-button-delete') : '';

					$gcts_r .= \GameMonetize\UI::view('admin/sections/view-categories-list');
				}
				$themeData['view_categories_list'] = $gcts_r;

				$themeData['categories_section_content'] = \GameMonetize\UI::view('admin/sections/view-categories-section');
			}
			elseif (isset($_GET['action']) && $_GET['action'] == "add") {
				$themeData['categories_section_content'] = \GameMonetize\UI::view('admin/sections/view-categories-add');
			}
			elseif (isset($_GET['action']) && $_GET['action'] == "edit" && !empty($_GET['cid'])) {
				$category_id = secureEncode($_GET['cid']);
				$sql_select_editcategory = $GameMonetizeConnect->query("SELECT * FROM ".CATEGORIES." WHERE id='{$category_id}'");
				if ($sql_select_editcategory->num_rows == 1) {
					$edit_category = $sql_select_editcategory->fetch_array();
					$themeData['edit_category_id'] = $edit_category['id'];
					$themeData['edit_category_name'] = $edit_category['name'];
					$themeData['edit_category_footer_description'] = $edit_category['footer_description'];
					$themeData['edit_category_url'] = siteUrl() . '/category/' . $edit_category['category_pilot'];

					$themeData['categories_section_content'] = \GameMonetize\UI::view('admin/sections/view-categories-edit');
				} else {
					$themeData['categories_section_content'] = \GameMonetize\UI::view('welcome/error-section');
				}
			}
			else {
				$themeData['categories_section_content'] = \GameMonetize\UI::view('welcome/error-section');
			}

			$themeData['page_admin_content'] = \GameMonetize\UI::view('admin/categories');
		}

		elseif (isset($_GET['section']) && $_GET['section'] == "tags") {
			if (!isset($_GET['action']) || $_GET['action'] == "view") {
				$sql_global_tags = $GameMonetizeConnect->query("SELECT * FROM ".TAGS." WHERE id!=0");
				$gcts_r = '';
				while ($global_tags = $sql_global_tags->fetch_array() ) {
					$updateStatus = "";
					if(strlen($global_tags['footer_description'])){
						$updateStatus = " (description updated)";
					}
					$themeData['view_tags_id'] = $global_tags['id'];
					$themeData['view_tags_name'] = $global_tags['name'] . $updateStatus;
					$themeData['view_tags_url_open'] = siteUrl() . "/tag/" . $global_tags['url'];
					$themeData['view_tags_button_delete'] = \GameMonetize\UI::view('admin/sections/view-tags-button-delete');

					$gcts_r .= \GameMonetize\UI::view('admin/sections/view-tags-list');
				}
				$themeData['view_tags_list'] = $gcts_r;

				$themeData['tags_section_content'] = \GameMonetize\UI::view('admin/sections/view-tags-section');
			}
			elseif (isset($_GET['action']) && $_GET['action'] == "add") {
				$themeData['tags_section_content'] = \GameMonetize\UI::view('admin/sections/view-tags-add');
			}
			elseif (isset($_GET['action']) && $_GET['action'] == "edit" && !empty($_GET['cid'])) {
				$tags_id = secureEncode($_GET['cid']);
				$sql_select_edittags = $GameMonetizeConnect->query("SELECT * FROM ".TAGS." WHERE id='{$tags_id}'");
				if ($sql_select_edittags->num_rows == 1) {
					$edit_tags = $sql_select_edittags->fetch_array();
					$themeData['edit_tags_id'] = $edit_tags['id'];
					$themeData['edit_tags_name'] = $edit_tags['name'];
					$themeData['edit_tags_footer_description'] = $edit_tags['footer_description'];
					$themeData['edit_tags_url'] = siteUrl() . '/tag/' . $edit_tags['url'];
					$themeData['tags_section_content'] = \GameMonetize\UI::view('admin/sections/view-tags-edit');
				} else {
					$themeData['tags_section_content'] = \GameMonetize\UI::view('welcome/error-section');
				}
			}
			else {
				$themeData['categories_section_content'] = \GameMonetize\UI::view('welcome/error-section');
			}

			$themeData['page_admin_content'] = \GameMonetize\UI::view('admin/tags');
		}

		elseif (isset($_GET['section']) && $_GET['section'] == "footerdescription"){
			if (!isset($_GET['action']) || $_GET['action'] == "view") {
				$sqlQuery = $GameMonetizeConnect->query("SELECT * FROM ".FOOTER_DESCRIPTION);
				$footerList = '';
				while ($footer = $sqlQuery->fetch_array() ) {
					$themeData['view_footer_description_id'] = $footer['id'];
					$themeData['view_footer_description_name'] = $footer['page_name'];
					// $themeData['view_footer_url_open'] = siteUrl() . "/tag/" . $footer['url'];
					// $themeData['view_footer_button_delete'] = \GameMonetize\UI::view('admin/sections/view-tags-button-delete');

					$footerList .= \GameMonetize\UI::view('admin/sections/view-footer-description-list');
				}
				$themeData['view_footer_description_list'] = $footerList;

				$themeData['footer_description_section_content'] = \GameMonetize\UI::view('admin/sections/view-footer-description-section');
			}
			elseif (isset($_GET['action']) && $_GET['action'] == "edit" && !empty($_GET['cid'])) {
				$footer_description_id = secureEncode($_GET['cid']);
				$sqlQuery = $GameMonetizeConnect->query("SELECT * FROM ".FOOTER_DESCRIPTION." WHERE id='{$footer_description_id}'");
				if ($sqlQuery->num_rows == 1) {
					$edit_footer_description = $sqlQuery->fetch_array();
					$themeData['edit_footer_description_id'] = $edit_footer_description['id'];
					$themeData['edit_footer_description_name'] = ucwords($edit_footer_description['page_name']);
					$themeData['edit_footer_description_value'] = $edit_footer_description['description'];
					if($edit_footer_description['has_content'] == '1'){
						$themeData['edit_footer_description_value_content_value'] = $edit_footer_description['content_value'];
						$themeData['edit_footer_description_content'] = \GameMonetize\UI::view('admin/sections/view-footer-description-edit-content');
					}

					// $notShowDescriptionPage = ['terms','contact','privacy'];
					// if(!in_array($edit_footer_description['page_name'], $notShowDescriptionPage)){
					// }
					$themeData['edit_footer_description_description'] = \GameMonetize\UI::view('admin/sections/view-footer-description-edit-description');
					
					$themeData['footer_description_section_content'] = \GameMonetize\UI::view('admin/sections/view-footer-description-edit');
				} else {
					$themeData['footer_description_section_content'] = \GameMonetize\UI::view('welcome/error-section');
				}
			}

			$themeData['page_admin_content'] = \GameMonetize\UI::view('admin/footerdescription');
		}

		elseif (isset($_GET['section']) && $_GET['section'] == "blogs") {
			if (!isset($_GET['action']) || $_GET['action'] == "view") {
				$sql_global = $GameMonetizeConnect->query("SELECT * FROM ".BLOGS." ORDER BY id DESC");
				$gcts_r = '';
				while ($global = $sql_global->fetch_array() ) {
					$themeData['view_blog_id'] = $global['id'];
					$themeData['view_blog_name'] = $global['title'];
					$themeData['view_blog_image'] = $global['image_url'];
					$themeData['view_blog_post'] = $global['post'];
					$themeData['view_blog_button_delete'] = \GameMonetize\UI::view('admin/sections/view-blogs-button-delete');

					$gcts_r .= \GameMonetize\UI::view('admin/sections/view-blogs-list');
				}
				$themeData['view_blogs_list'] = $gcts_r;
				$themeData['blogs_section_content'] = \GameMonetize\UI::view('admin/sections/view-blogs-section');
			}
			elseif (isset($_GET['action']) && $_GET['action'] == "add") {
				$themeData['blogs_section_content'] = \GameMonetize\UI::view('admin/sections/view-blogs-add');
			}
			elseif (isset($_GET['action']) && $_GET['action'] == "edit" && !empty($_GET['cid'])) {
				$blog_id = secureEncode($_GET['cid']);
				$sql_select_editblog = $GameMonetizeConnect->query("SELECT * FROM ".BLOGS." WHERE id='{$blog_id}'");
				if ($sql_select_editblog->num_rows == 1) {
					$edit_blog = $sql_select_editblog->fetch_array();
					$themeData['edit_blog_id'] = $edit_blog['id'];
					$themeData['edit_blog_title'] = $edit_blog['title'];
					$themeData['edit_blog_image_url'] = $edit_blog['image_url'];
					$themeData['edit_blog_post'] = $edit_blog['post'];
					$themeData['edit_blog_url'] = siteUrl() . '/blog/' . $edit_blog['url'];

					$themeData['blogs_section_content'] = \GameMonetize\UI::view('admin/sections/view-blogs-edit');
				} else {
					$themeData['blogs_section_content'] = \GameMonetize\UI::view('welcome/error-section');
				}
			}
			else {
				$themeData['blogs_section_content'] = \GameMonetize\UI::view('welcome/error-section');
			}

			$themeData['page_admin_content'] = \GameMonetize\UI::view('admin/blogs');
		}

		elseif (isset($_GET['section']) && $_GET['section'] == "users") {
			if (isset($_GET['action']) && $_GET['action'] == "edit" && !empty($_GET['uid'])) {
				$get_user_uid = secureEncode($_GET['uid']);
				if (is_numeric($get_user_uid)) {
		        	$user_uid_type = "id = " . $get_user_uid;
		    	} elseif (preg_match('/[A-Za-z0-9_]/', $get_user_uid)) {
		        	$user_uid_type = "username = '{$get_user_uid}'";
		    	}
		    	$get_user_query = $GameMonetizeConnect->query("SELECT * FROM ".ACCOUNTS." WHERE " . $user_uid_type);

		    	if ($get_user_query->num_rows > 0) {
		    		$get_user_account = $get_user_query->fetch_array();
		    		$get_user_info = getInfo($get_user_account['id']);
		    		$themeData['user_profile_avatar'] = getAvatar($get_user_account['avatar_id'], $get_user_info['gender']);
		    		$themeData['user_profile_id'] = $get_user_account['id'];
		    		$themeData['user_profile_username'] = $get_user_account['username'];
		    		$themeData['user_profile_name'] = $get_user_account['name'];
		    		$themeData['user_profile_ip'] = $get_user_account['ip'];
		    		$themeData['user_profile_email'] = $get_user_account['email'];
		    		$themeData['user_profile_xp'] = $get_user_account['xp'];
		    		$themeData['user_profile_about'] = $get_user_info['about'];
		    		$themeData['user_profile_rank_status_0'] = ($get_user_account['admin'] == 0) ? 'selected' : '';
		    		$themeData['user_profile_rank_status_1'] = ($get_user_account['admin'] == 1) ? 'selected' : '';
		    		$themeData['user_profile_gender_status_1'] = ($get_user_info['gender'] == 1) ? 'selected' : '';
		    		$themeData['user_profile_gender_status_2'] = ($get_user_info['gender'] == 2) ? 'selected' : '';
		    		$themeData['user_profile_active_status'] = ( $get_user_account['active'] ) ? 'checked' : '';
		    		$ueLANG_dir = opendir('assets/language/');
					$ueLANG_dr_array = array();
					while (false !== ($file = readdir($ueLANG_dir))) {
						$ueLANG_dr_array[] = $file;
					}
					closedir($ueLANG_dir);
					$gusrlng_r = '';
					foreach($ueLANG_dr_array as $file) {
						if ($file != "." && $file != ".." && $file != "Thumbs.db" && $file != ".DS_Store" && $file != "images") {
							$val_file = str_replace('.php', '', $file);
							$gusrlng_r .= ($get_user_account['language'] == $val_file) ? 
								'<option value="'.$val_file.'" selected>'.$val_file.'</option>' : 
								'<option value="'.$val_file.'">'.$val_file.'</option>';
						}
					}
					$themeData['user_profile_language_option'] = $gusrlng_r;

					$themeData['user_section_content'] = \GameMonetize\UI::view('admin/sections/view-user-edit');
				} 
				else {
					$themeData['user_section_content'] = \GameMonetize\UI::view('welcome/error');
				}
			}
			else {
				$themeData['user_section_content'] = \GameMonetize\UI::view('admin/sections/view-user-search');
			}

			$themeData['page_admin_content'] = \GameMonetize\UI::view('admin/users');
		}

		elseif (isset($_GET['section']) && $_GET['section'] == "ads") {
			$get_ads_data = $GameMonetizeConnect->query("SELECT * FROM ".ADS.""); 
			$get_ads = $get_ads_data->fetch_array();
			$themeData['ads_area_header'] = $get_ads['728x90'];
			$themeData['ads_area_footer'] = $get_ads['300x250'];
			$themeData['ads_area_column_one'] = $get_ads['600x300'];
			$themeData['ads_area_gametop'] = $get_ads['728x90_main'];
			$themeData['ads_area_gamebottom'] = $get_ads['300x250_main'];
			$themeData['ads_area_gameinfo'] = $get_ads['ads_video'];

			$themeData['page_admin_content'] = \GameMonetize\UI::view('admin/ads');
		}

		elseif (isset($_GET['section']) && $_GET['section'] == "adstxt") {

			if ( ! defined( 'ABSPATH' ) ) {
				define( 'ABSPATH', dirname( dirname( __FILE__ ) ) . '/' );
			}
			$url = ABSPATH . 'ads.txt';

			$text = file_get_contents($url);

			$themeData['ads_txt'] = $text;

			$themeData['page_admin_content'] = \GameMonetize\UI::view('admin/adstxt');
		}
		else {
			$themeData['page_admin_content'] = \GameMonetize\UI::view('welcome/error-section');
		}

		$themeData['page_content'] = \GameMonetize\UI::view('admin/content');
	}