<?php 
    if (!defined('R_PILOT')) { exit(); }
    
    if ($a == "new" && !empty($_POST['user_id']) && is_numeric($_POST['user_id']) && $_POST['user_id'] > 0) {
        $continue = false;
        
        if ($_POST['user_id'] == $userData['id']) {
            $continue = true;
        }
        
        if (isset($_FILES['image']['tmp_name']) && $continue == true) {
            if (!$_FILES['image']['size'] > 1048576 || $_FILES['image']['size'] != 0) {
                if ( in_array($_FILES["image"]["type"], array('image/jpeg', 'image/jpg', 'image/png')) && is_uploaded_file($_FILES['image']['tmp_name'])) {
                    if ($_FILES['image']['size'] > 1024) {
                        $image = $_FILES['image'];
                        $avatar = uploadMedia($image);
                
                	    if (isset($avatar['id'])) {
                            $sql_query_one = $GameMonetizeConnect->query("UPDATE " . ACCOUNTS . " SET avatar_id={$avatar['id']} WHERE id=" . $userData['id']);
                    
                	        if ($sql_query_one) {
                                $data = array(
                           	        'status' => 200,
                           	        'success_message' => $lang['upload_image_success'],
                                	'avatar_url' => $config['site_url'].'/' . $avatar['url'] . '_100x100.' . $avatar['extension']
                           	    );

                	   	    } else { $data['error_message'] = $lang['error_message']; }
                        } else { $data['error_message'] = $lang['error_message']; }
                    } else { $data['error_message'] = $lang['image_small']; }
                } else { $data['error_message'] = $lang['no_support_file']; }
            } else { $data['error_message'] = $lang['max_avatar_size_exceeded']; }
        } else { $data['error_message'] = $lang['message_select_image']; }
        
        header("Content-type: application/json");
        echo json_encode($data);
        $GameMonetizeConnect->close();
        exit();
    }