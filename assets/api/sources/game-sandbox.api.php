<?php 

    if ( ! defined('API_PILOT') ) exit();

    	if ( !isset($_GET['gid']) && ( !empty($_GET['gid']) ) ) exit();
    	
	    $get_game_data = getGame($_GET['gid']);

	    if ( !$get_game_data ) exit();

	    $date =  date('Ymdms');
		$date = strtotime($date);

		$urlgame = $get_game_data['file'];
		if (strpos($urlgame,'gamedistribution') !== false) {
		   	$urlgame = "//gamesgames.io/game.php?game=1&url=".basename($urlgame);
		} else {
			$urlgame = $get_game_data['file'];
		}

	    $iframe = '<iframe src="' .$urlgame . '" id="api_game_embed" frameborder="0" scrolling="no" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
	<script src="https://api.gamemonetize.com/cms_iframe.js?' . $date . '"></script>';

	    $get_game_type_container = ABSPATH . 'assets/api/sources/src.game-sandbox.api/iframe.game.php';

	    include( ABSPATH . 'assets/api/sources/src.game-sandbox.api/template.html.php' );