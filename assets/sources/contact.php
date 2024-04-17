<?php
	$themeData['ads_header'] = getADS('header');
	$themeData['ads_footer'] = getADS('footer');
	$themeData['ads_sidebar'] = getADS('column_one');
	# >>

	$themeData['new_game_page'] = "";
	$footer_description = getFooterDescription('contact');
	// $footer_description = getFooterDescription('about');

	$themeData['footer_description'] = isset($footer_description->description) ? htmlspecialchars_decode($footer_description->description): "";;
	$themeData['footer_description_has_content'] = isset($footer_description->has_content) ? $footer_description->has_content: "";
	$themeData['footer_description_content_value'] = isset($footer_description->content_value) ? htmlspecialchars_decode($footer_description->content_value): "";
	$themeData['new_games'] = \GameMonetize\UI::view('game/contact');

	$themeData['page_content'] = \GameMonetize\UI::view('home/content');