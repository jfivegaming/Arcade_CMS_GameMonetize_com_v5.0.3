<?php 
	if ( !defined('R_PILOT') ) exit();

	$publishing_games_query = $GameMonetizeConnect->query("UPDATE ".GAMES." SET published='1' WHERE published='0'");
	
	if ( $publishing_games_query ) {
		$data['status'] = 200;
		$data['success_message'] = $lang['all_games_published'];
	}