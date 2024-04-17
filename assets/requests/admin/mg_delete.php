<?php 
    if (!defined('R_PILOT')) { exit(); }

    	if (is_logged() && isset($_POST['gid'])) {
            $manage_game_id = secureEncode($_POST['gid']);
            $sql_manage_dlt = $GameMonetizeConnect->query("SELECT game_id FROM ".GAMES." WHERE game_id='{$manage_game_id}'");

            if ($sql_manage_dlt->num_rows > 0) {
                $GameMonetizeConnect->query("DELETE FROM ".GAMES." WHERE game_id='{$manage_game_id}'");
            }
        }