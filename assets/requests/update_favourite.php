<?php 
    if (!defined('R_PILOT')) { exit(); }

    accessOnly();

    if (isset($_POST['id'])) {

        $game_id = secureEncode($_POST['id']);
        $userid  = secureEncode($userData['id']);
        $photo_avatar = getAvatar($userData['avatar_id'], $userData['gender'], 'medium');

        if ( is_logged() ) {
            $user_fav_game = $GameMonetizeConnect->query("SELECT * FROM ".USER_GAME." WHERE user_id='{$userid}' AND game_id='{$game_id}' AND type='favorite'");
    
            if ($user_fav_game->num_rows > 0) {
                // Remove favourite
                $GameMonetizeConnect->query("DELETE FROM ".USER_GAME." WHERE user_id='{$userid}' AND game_id='{$game_id}' AND type='favorite'");
            }
            else {
                // Add favourite
                $GameMonetizeConnect->query("INSERT INTO ".USER_GAME." (user_id, game_id, type) VALUES ('{$userid}', '{$game_id}', 'favorite')");

                $data['success_message'] = '
                    <div class="_a-c _xp-34f9">
                        <img class="_xp-34mn" src="'.$config['theme_path'].'/image/icon-color/star.png">
                        <img class="_xp-34mn" src="'.$photo_avatar.'">
                    </div>
                    <h2 class="color-d">'.$lang['favorited'].'</h2>
                    '.$lang['msg_alert_fv_1'];
            }
        }
        header("Content-type: application/json");
        echo json_encode($data);
        $GameMonetizeConnect->close();
        exit();
    }