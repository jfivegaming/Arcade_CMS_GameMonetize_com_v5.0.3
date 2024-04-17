<?php 
    if (!defined('R_PILOT')) { exit(); }
    
		if (is_logged() && isset($_POST['cid'])) {
            $tags_id = secureEncode($_POST['cid']);
            $sql_tags_dlt = $GameMonetizeConnect->query("SELECT id FROM ".TAGS." WHERE id='{$tags_id}'");

            if ($sql_tags_dlt->num_rows > 0) {
                $GameMonetizeConnect->query("DELETE FROM ".TAGS." WHERE id='{$tags_id}'");
            }
        }