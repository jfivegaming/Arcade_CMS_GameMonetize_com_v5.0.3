<?php 
    if (!defined('R_PILOT')) { exit(); }

	if ( is_logged() ) {
        $xp_play = $config['xp_play'];
        $GameMonetizeConnect->query("UPDATE ".ACCOUNTS." SET xp = xp+$xp_play WHERE id='{$userData['id']}'");
        $photo_avatar = getAvatar($userData['avatar_id'], $userData['gender'], 'medium');

        $data['access'] = true;
        $data['success_message'] = '
            <div class="_a-c _xp-34f9">
                <img class="_xp-34mn" src="'.$config['theme_path'].'/image/icon-color/star_xp.png">
                <img class="_xp-34mn" src="'.$photo_avatar.'">
            </div>
            <h2>'.$lang['congrats'].'</h2> 
            '.$lang['msg_alert_xp_1'].' <b class="color-c">+'.$xp_play.'</b> '.$lang['msg_alert_xp_2'];
    } else {
        $data['access'] = false;
        $data['success_message'] = '
            <div class="_a-c _xp-34f9">
                <img class="_xp-34mn" src="'.$config['theme_path'].'/image/icon-color/star_xp.png">
                <img class="_xp-34mn" src="'.$config['theme_path'].'/image/icon-color/star_xp.png">
            </div>
            <div class="_xp-sts-0">
                <a class="spf-link" href="'.siteUrl().'/login">'.$lang['sign_in'].'</a> '.$lang['or'].'
                <a class="spf-link" href="'.siteUrl().'/signup">'.$lang['sign_up'].'</a>
            </div> '.$lang['msg_alert_xp_3'];
    }

    header("Content-type: application/json");
    echo json_encode($data);
    $GameMonetizeConnect->close();
    exit();