<?php 
    if (!defined('R_PILOT')) { exit(); }
    	
	if (isset($_POST['gid'])) {
        $game_id = secureEncode($_POST['gid']);
        $GameMonetizeConnect->query("UPDATE ".GAMES." SET plays=plays+1 WHERE game_id='{$game_id}'");
        $GameMonetizeConnect->query("UPDATE ".SETTING." SET plays=plays+1");
    }

    header("Content-type: application/json");
    echo json_encode($data);
    $GameMonetizeConnect->close();
    exit();