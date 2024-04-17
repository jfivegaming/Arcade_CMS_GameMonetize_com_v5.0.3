<?php 
    if (!defined('R_PILOT')) { exit(); }
    
        if (!empty($_POST['uid'])) {
            if (isset($_POST['uid'])) {
                $s_uid = secureEncode($_POST['uid']);
                if ($s_uid != NULL) {
                    if (is_numeric($s_uid)) {
                        $s_userType_part = "id = " . $s_uid;
                    } elseif (preg_match('/[A-Za-z0-9_]/', $s_uid)) {
                        $s_userType_part = "username = '{$s_uid}'";
                    }
                    $s_check_user = $GameMonetizeConnect->query("SELECT id FROM ".ACCOUNTS." WHERE $s_userType_part");
                    if ($s_check_user->num_rows == 1) {
                        $data['status'] = 200;
                        $data['redirect_url'] = siteUrl().'/admin/users/edit/' . $s_uid;
                    } else { $data['error_message'] = $lang['user_not_exists']; }
                } else { $data['error_message'] = $lang['fields_spaces']; }
            } else { $data['error_message'] = $lang['error_message']; }
        } else { $data['error_message'] = $lang['empty_place']; }