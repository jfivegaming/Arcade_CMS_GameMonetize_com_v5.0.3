<?php 
    if (!defined('R_PILOT')) { exit(); }

	if (!empty($_POST["name"]) && !empty($_POST["username"]) && !empty($_POST["password"]) && !empty($_POST["email"])) {
		if (isset($_POST["name"]) && isset($_POST["username"]) && isset($_POST["password"]) && isset($_POST["email"])) {
	
			$user_ip = $_SERVER["REMOTE_ADDR"];
			$name                 = secureEncode($_POST["name"]);
			$user_name            = secureEncode($_POST["username"]);
			$user_password        = secureEncode($_POST["password"]);
			$password_encryption  = sha1(str_rot13($user_password . $encryption));
			$user_email           = secureEncode($_POST["email"]);
			$check_user  = $GameMonetizeConnect->query("SELECT id FROM ".ACCOUNTS." WHERE username = '{$user_name}'");
			$check_email = $GameMonetizeConnect->query("SELECT id FROM ".ACCOUNTS." WHERE email = '{$user_email}'");

			if (preg_match("/^[a-zA-Z0-9_]+$/", $user_name) && !ctype_digit($user_name)) {
				if(strlen($user_name) >= 4 && strlen($user_name) <= 10) {
					if(strlen($user_password) >= 6) {
						if ($check_user->num_rows < 1) {
							if($check_email->num_rows < 1) {
								if (filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
									if ($name != NULL && $user_name != NULL && $user_password != NULL) {
										if (preg_match("/^[a-zA-Z- ]+$/", $name)) {
											if (strlen($name) <= 20) {
												$GameMonetizeConnect->query("INSERT INTO ".ACCOUNTS." (name, username, password, email, ip, registration_date, xp) VALUES ('{$name}', '{$user_name}', '{$password_encryption}', '{$user_email}', '{$user_ip}', '{$time}', '{$config['xp_register']}')") or die();
												$ins_user_id = $GameMonetizeConnect->insert_id;
												$GameMonetizeConnect->query("INSERT INTO ".USERS." (user_id, gender) VALUES ({$ins_user_id},'1')");

												setcookie("gm_ac_u", $ins_user_id, time() + (60 * 60 * 24 * 1), '/');
												setcookie("gm_ac_p", $password_encryption, time() + (60 * 60 * 24 * 1), '/');
												sleep(1);
												$data['status'] = 200;
												$data['redirect_url'] = siteUrl().'/home';
											} else { $data['error_message'] = $lang['name_exceed']; }
										} else { $data['error_message'] = $lang['name_char_invalid']; }
									} else { $data['error_message'] = $lang['fields_spaces']; }
								} else { $data['error_message'] = $lang['invalid_email']; }
							} else { $data['error_message'] = $lang['email_used']; }
						} else { $data['error_message'] = $lang['username_used']; }
					} else { $data['error_message'] = $lang['password_contain_digits']; }
				} else { $data['error_message'] = $lang['user_contain_digits']; }
			} else { $data['error_message'] = $lang['user_char_invalid']; }
		} else{ $data['error_message'] = $lang['error_message']; }
	} else { $data['error_message'] = $lang['empty_place']; }

	header("Content-type: application/json");
    echo json_encode($data);
    $GameMonetizeConnect->close();
    exit();