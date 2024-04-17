<?php 
    if (!defined('R_PILOT')) { exit(); }

    	if (is_logged() && isset($_POST['gid'])) {
            $manage_game_id = secureEncode($_POST['gid']);
            $sql_manage_ft = $GameMonetizeConnect->query("SELECT featured FROM ".GAMES." WHERE game_id='{$manage_game_id}'");
            $manage_ft = $sql_manage_ft->fetch_array();

            if ($manage_ft['featured'] == 1) {
                $GameMonetizeConnect->query("UPDATE ".GAMES." SET featured='0' WHERE game_id='{$manage_game_id}'");
            } else {
                # Featured game
                $GameMonetizeConnect->query("UPDATE ".GAMES." SET featured='1' WHERE game_id='{$manage_game_id}'");
            }
        }