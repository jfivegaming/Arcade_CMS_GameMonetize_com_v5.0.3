<?php

if (is_logged()) {
	$themeData['header_user_avatar'] = getAvatar($userData['avatar_id'], $userData['gender'], 'thumb');
	$themeData['user_panel_xp'] = numberFormat($userData['xp']);
	$themeData['csrf_logout_token'] = \GameMonetize\CSRF::set(3, 3600);
}
$themeData['website_name'] = $_SERVER['HTTP_HOST'];
$date =  date('Ymdms');
$date = strtotime($date);
$themeData['cms'] = "<script src='https://api.gamemonetize.com/cms.js?" . $date . "'></script>";
$themeData['cookie'] = ($config['ads_status']) ? '<script type="text/javascript">
window.cookieconsent_options = { "message":"This website uses cookies to ensure you get the best experience on our website.","dismiss":"Got it!","learnMore":"Learn more","link":"/privacy","target":"_blank","theme":"dark-bottom" };
</script>
<script type="text/javascript" src="' . $config['theme_path'] . '/js/cookieconsent.min.js"></script>' : '';

$themeData['header_class_access_menu'] = (is_logged()) ? '_rP5' : '';

$themeData['header_panel_menu_admin'] = (is_logged() && $userData['admin'] == 1) ? \GameMonetize\UI::view('header/header_panel_menu_admin') : '';


if ($_GET['p'] != 'login') {
	if (
		$userData['admin'] == 0
		|| $_GET['p'] == 'play'
		|| $_GET['p'] == 'new-games'
		|| $_GET['p'] == 'search'
		|| $_GET['p'] == 'terms'
		|| $_GET['p'] == 'privacy'
		|| $_GET['p'] == 'about'
		|| $_GET['p'] == 'categories'
		|| $_GET['p'] == 'best-games'
		|| $_GET['p'] == 'featured-games'
		|| $_GET['p'] == 'played-games'
		|| $_GET['p'] == 'tagspage'
		|| $_GET['p'] == 'contact'
		|| $_GET['p'] == 'blogs'
		|| is_page('home')
	) {

		$json = file_get_contents('https://api.gamemonetize.com/cms.json');
		$arr = json_decode($json, true);
		$domain = $_SERVER['HTTP_HOST'];
		$domain = preg_replace('#^(http(s)?://)?w{3}\.#', '$1', $domain);

		try {
			foreach ($arr['response']['games'] as $game) {
				if ($game['domain'] === $domain) {
					header("Location: https://gamemonetize.com?utm_source=blockedcms&domain=" . $domain);
					break;
				}
			}
		} catch (Exception $e) {
		}

		$sql_cat_query = $GameMonetizeConnect->query("SELECT * FROM " . CATEGORIES);
		$ct_r = '';
		while ($category = $sql_cat_query->fetch_array()) {
			$themeData['category_id'] = $category['id'];
			$themeData['category_name'] = $category['name'];

			$numbergames = $GameMonetizeConnect->query("SELECT COUNT(*) FROM " . GAMES . " where category=" . $category['id']);
			$numbergames = $numbergames->fetch_array()[0];

			$themeData['category_number'] = $numbergames;
			$themeData['category_url'] = siteUrl() . '/category/'	. slugify($category['name']);
			$ct_r .= \GameMonetize\UI::view('category/categories-list-2');
		}

		$themeData['categories_list_2'] = $ct_r;
		$themeData['category_content'] = \GameMonetize\UI::view('category/categories-2');

		$themeData['config_this_year'] =  date("Y");

		$whitelist = array(
			'127.0.0.1',
			'::1'
		);
		$themeData['load_more_url'] = "";
		if (!in_array($_SERVER['REMOTE_ADDR'], $whitelist)) {
			$themeData['load_more_url'] = "";
		} else {
			$themeData['load_more_url'] = siteUrl();
		}

		$themeData['footer_content'] = \GameMonetize\UI::view('footer/content');
		$themeData['header'] = \GameMonetize\UI::view('header/content');
	}
}
if ($_GET['p'] == 'login') {
	$themeData['header_panel_dropdown'] = (is_logged()) ? \GameMonetize\UI::view('header/header_user_panel') : '';
	// $themeData['footer_content'] = \GameMonetize\UI::view('footer/content_admin');
}
