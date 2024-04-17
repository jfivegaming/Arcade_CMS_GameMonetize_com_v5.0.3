<?php 
    if (!defined('R_PILOT')) { exit(); }

        if (!empty($_POST['eu_username']) && !empty($_POST['eu_name']) && !empty($_POST['eu_email'])) {
            if (isset($_POST['eu_username']) && isset($_POST['eu_name']) && isset($_POST['eu_email'])) {
                $eu_ss = array();
                $eu_id['id']         = secureEncode($_POST['eu_id']);
                $eu_ss['username']   = secureEncode($_POST['eu_username']);
                $eu_ss['name']       = secureEncode($_POST['eu_name']);
                $eu_ss['admin']      = secureEncode($_POST['eu_admin']);
                $eu_ss['email']      = secureEncode($_POST['eu_email']);
                $eu_ss['xp']         = secureEncode($_POST['eu_xp']);
                $eu_ss['status']     = (isset($_POST['eu_active'])) ? '1' : '0';
                $eu_ss['lang']       = secureEncode($_POST['eu_lang']);
                $eu_ss['about']      = secureEncode($_POST['eu_about']);
                $eu_ss['gender']     = secureEncode($_POST['eu_gender']);
                $eu_ss['check_user'] = $GameMonetizeConnect->query("SELECT id FROM ".ACCOUNTS." WHERE username='{$eu_ss['username']}' AND id!='{$eu_id['id']}'");
                $eu_ss['check_email'] = $GameMonetizeConnect->query("SELECT id FROM ".ACCOUNTS." WHERE email='{$eu_ss['email']}' AND id!='{$eu_id['id']}'");

                if (preg_match("/^[a-zA-Z0-9_]+$/", $eu_ss['username']) && !ctype_digit($eu_ss['username'])) {
                    if (strlen($eu_ss['username']) >= 4 && strlen($eu_ss['username']) <= 10) {
                        if ($eu_ss['check_user']->num_rows < 1) {
                            if($eu_ss['check_email']->num_rows < 1) {
                                if (filter_var($eu_ss['email'], FILTER_VALIDATE_EMAIL)) {
                                    if ($eu_ss['username'] != NULL && $eu_ss['name'] != NULL) {
                                        if (preg_match("/^[a-zA-Z- ]+$/", $eu_ss['name'])) {
                                            if (strlen($eu_ss['name']) <= 20) {
                                                if (strlen($eu_ss['about']) <= 132) {
                                                    $GameMonetizeConnect->query("UPDATE ".ACCOUNTS." SET name='{$eu_ss['name']}', username='{$eu_ss['username']}', email='{$eu_ss['email']}', admin='{$eu_ss['admin']}', xp='{$eu_ss['xp']}', language='{$eu_ss['lang']}', active='{$eu_ss['status']}' WHERE id='{$eu_id['id']}'") or die();
                                                    $GameMonetizeConnect->query("UPDATE ".USERS." SET gender='{$eu_ss['gender']}', about='{$eu_ss['about']}' WHERE user_id='{$eu_id['id']}'") or die();
                                                    $data['status'] = 200;
                                                    $data['success_message'] = $lang['info_saved'];
                                                } else { $data['error_message'] = $lang['description_long']; }
                                            } else { $data['error_message'] = $lang['name_exceed']; }
                                        } else { $data['error_message'] = $lang['name_char_invalid']; }
                                    } else { $data['error_message'] = $lang['fields_spaces']; }
                                } else { $data['error_message'] = $lang['invalid_email']; }                         
                            } else { $data['error_message'] = $lang['email_used']; }
                        } else { $data['error_message'] = $lang['username_used']; }
                    } else { $data['error_message'] = $lang['user_contain_digits']; }
                } else { $data['error_message'] = $lang['name_char_invalid']; }
            } else { $data['error_message'] = $lang['error_message']; }
        } else { $data['error_message'] = $lang['empty_place']; }