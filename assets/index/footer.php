<?php
$get_game_id = ( is_page('play') ) ? getGame($_GET['id']) : 0;

$themeData['get_game_id'] = $get_game_id['game_id'];
$themeData['config_this_year'] =  date("Y");

if($_GET['p'] != 'login') {
	if(
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
		|| $_GET['p'] == 'tagspage' 
		|| $_GET['p'] == 'played-games' 
		|| $_GET['p'] == 'contact' 
		|| $_GET['p'] == 'blogs' 
		|| is_page('home')
	) {
		$themeData['footer'] = \GameMonetize\UI::view('global/footer/all');
	}
}
if (is_logged() || $_GET['p'] == 'login') {
	$themeData['cp'] ="<div class='copyright'>© Copyright ". $themeData['config_this_year'] ." - <a href='https://gamemonetize.com' target='_blank'>GameMonetize.com</a></div>";	
}
if($_GET['p'] == 'login' ||  $_GET['p'] == 'admin'  ||  $_GET['p'] == 'setting' ) {
	$themeData['footer'] = \GameMonetize\UI::view('global/footer/all2');
}

// $themeData['footer'] .= ( is_logged() ) ? \GameMonetize\UI::view('global/footer/logged-scripts') : \GameMonetize\UI::view('global/footer/unlogged-scripts');
// $themeData['footer'] .= ( is_page('play') ) ? \GameMonetize\UI::view('global/footer/game-scripts') : '';
$themeData['footer'] .= ( is_admin() && is_page('admin') ) ? \GameMonetize\UI::view('global/footer/admin-panel-scripts') : '';
// $themeData['footer'] .= ( is_admin() && is_page('play') ) ? \GameMonetize\UI::view('global/footer/admin-game-scripts') : \GameMonetize\UI::view('global/footer/admin-game-scripts');
$themeData['footer'] .= addon(array('footer_tags_add_content', 'string'));