<?php 
	if (!defined('R_PILOT')) exit();

	$p = (!isset($_GET['p'])) ? "" : secureEncode($_GET['p']);

	if ($p == 'played') {
		if (isset($_POST['gid']) && !empty($_POST['gid'])) {
			$get_game_id = secureEncode($_POST['gid']);
			
			$get_games_played_query = $GameMonetizeConnect->query("SELECT game_id, DATE_FORMAT(FROM_UNIXTIME(date_added), '%d %b %Y') AS fecha, count(game_id) cant FROM ".USER_GAME." WHERE type='played' AND game_id={$get_game_id} GROUP BY game_id, DATE_FORMAT(FROM_UNIXTIME(date_added), '%d/%m/%Y') ORDER BY game_id, date_added ASC LIMIT 7");
			

			$labels = array();
			$datasets = array();

			while ($get_games_played = $get_games_played_query->fetch_array()) {
				$labels[] = $get_games_played['fecha'];
				$datasets[] = $get_games_played['cant'];
			}

			$data['label'] = $lang['game_played_analytics'];
			$data['labels'] = $labels;
			$data['datasets'] = $datasets;
		}
	}