<?php
$themeData['title_tag'] = title_tag();
$descriptionPixelChar = 135;
$themeData['config_site_description'] = substr($themeData['config_site_description'], 0, $descriptionPixelChar);

$specialPage = ['best-games', 'new-games', 'featured-games', 'played-games'];
if (is_page('play')) {
	$game_data = getGame2($_GET['id']);
	$game_info = gameData($game_data);
	$themeData['game_meta_title'] = $game_info['name'] . " - Play Online Games Free";
	$themeData['game_meta_name'] = $game_info['name'];
	$themeData['game_meta_game_url'] = $game_info['game_url'];
	$themeData['game_meta_image'] = $game_info['image_url'];
	$themeData['game_meta_description'] = substr(strip_tags(htmlspecialchars_decode($game_info['description'])), 0, $descriptionPixelChar);
	$themeData['header_metatags'] .= \GameMonetize\UI::view('global/header/game_metatags');
	$themeData['header_metatags'] .= '<link rel="canonical" href="' . $game_info['game_url'] . '">';
} else {
	if ($_GET['p'] == 'home') {
		$cat = $_GET["cat"];
		if ($cat <> "") {
			$cat = str_replace('-', '.', $cat);
			$cat = ucfirst($cat);
			$themeData['game_meta_description2'] = "Play " . $cat . " Free Online at GameFree.Games! We have chosen top " . $cat . " games which you can play online for free. enjoy! ";
			$themeData['header_title'] = \GameMonetize\UI::view('global/header/title');
			$themeData['header_metatags'] = \GameMonetize\UI::view('global/header/metatags2');
		} else {
			$themeData['header_title'] = \GameMonetize\UI::view('global/header/title');
			$themeData['header_metatags'] = \GameMonetize\UI::view('global/header/metatags');
		}
	} 
	else if ($_GET['p'] == 'tagspage'){
		$tags_data = getTagsByTitle($_GET['tag']);
		$themeData['category_tags_meta_title'] = "Tag ".ucwords($tags_data['name']) . " Games - Play Online Games Free";
		$themeData['category_tags_meta_description'] = substr(strip_tags(htmlspecialchars_decode($tags_data["footer_description"])), 0, $descriptionPixelChar);
		$themeData['header_metatags'] .= \GameMonetize\UI::view('global/header/category_tags_metatags');
		$themeData['header_metatags'] .= '<link rel="canonical" href="' . siteUrl() . "/tag/" . $tags_data['url'] . '">';
	}
	else if ($_GET['p'] == 'blogs'){
		if(!isset($_GET['blog'])){
			$blogs_footer_description = getFooterDescription('blogs');
			$themeData['category_tags_meta_title'] = "Our Blogs - Play Online Games Free";
			$themeData['category_tags_meta_description'] = substr(strip_tags(htmlspecialchars_decode($blogs_footer_description->description)), 0, $descriptionPixelChar);
			$themeData['header_metatags'] .= \GameMonetize\UI::view('global/header/category_tags_metatags');
			$themeData['header_metatags'] .= '<link rel="canonical" href="' . siteUrl() . '/blogs">';
		} else {
			$blog_data = getBlogByUrl($_GET['blog']);
			$themeData['category_tags_meta_title'] = substr(ucwords($blog_data['title']), 0, 20) . " - Play Online Games Free";
			$themeData['category_tags_meta_description'] = substr(strip_tags(htmlspecialchars_decode($blog_data["post"])), 0, $descriptionPixelChar);
			$themeData['header_metatags'] .= \GameMonetize\UI::view('global/header/category_tags_metatags');
			$themeData['header_metatags'] .= '<link rel="canonical" href="' . siteUrl() . "/blog/" . $blog_data['url'] . '">';
		}
	}
	else if ($_GET['p'] == 'categories'){
		if(!isset($_GET['category'])){
			$themeData['category_tags_meta_title'] = "Categories - Play Online Games Free";
			$category_footer_description = getFooterDescription('categories');
			$themeData['category_tags_meta_description'] = substr(strip_tags(htmlspecialchars_decode($category_footer_description->description)), 0, $descriptionPixelChar);
			$themeData['header_metatags'] .= \GameMonetize\UI::view('global/header/category_tags_metatags');
			$themeData['header_metatags'] .= '<link rel="canonical" href="' . siteUrl() . '/categories">';
		}else{
			$category_data = getCategoriesByUrl($_GET['category']);
			$themeData['category_tags_meta_title'] = "Category ".ucwords($category_data['name']) . " - Play Online Games Free";
			$themeData['category_tags_meta_description'] = substr(strip_tags(htmlspecialchars_decode($category_data["footer_description"])), 0, $descriptionPixelChar);
			$themeData['header_metatags'] .= \GameMonetize\UI::view('global/header/category_tags_metatags');
			$themeData['header_metatags'] .= '<link rel="canonical" href="' . siteUrl() . "/category/" . $category_data['category_pilot'] . '">';

		}
	} else if (in_array($_GET['p'], $specialPage)) {
		$themeData['category_tags_meta_title'] = td_title();
		$footer_description = getFooterDescription($_GET['p']);
		$themeData['category_tags_meta_description'] = substr(strip_tags(htmlspecialchars_decode($footer_description->description)), 0, $descriptionPixelChar);
		$themeData['header_metatags'] .= \GameMonetize\UI::view('global/header/category_tags_metatags');
		$themeData['header_metatags'] .= '<link rel="canonical" href="' . siteUrl() . '/'.$_GET['p'].'">';
	}
	else {
		$themeData['header_title'] = \GameMonetize\UI::view('global/header/title');
		$themeData['header_metatags'] = \GameMonetize\UI::view('global/header/metatags');
	}
}

$themeData['header_favicon'] = \GameMonetize\UI::view('global/header/favicon');

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
		$themeData['header_stylesheets'] = \GameMonetize\UI::view('global/header/stylesheets');
	} else {
		$themeData['header_stylesheets'] .= \GameMonetize\UI::view('global/header/admin-stylesheets');
	}
}
if ($_GET['p'] == 'login') {
	$themeData['header_stylesheets'] .= \GameMonetize\UI::view('global/header/admin-stylesheets');
}

$whitelist = array(
	'127.0.0.1',
	'::1'
);

if (!in_array($_SERVER['REMOTE_ADDR'], $whitelist)) {
	$themeData['header_url'] = "//" . $_SERVER['HTTP_HOST'];
} else {
	$themeData['header_url'] = siteUrl();
}

$themeData['header_scripts'] = \GameMonetize\UI::view('global/header/scripts');

$themeData['header_tags'] = \GameMonetize\UI::view('global/header/all');

function cleanText($text)
{
	$text = str_replace('"', ";", $text);
	return $text;
}
