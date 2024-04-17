<?php 
    if (!defined('R_PILOT')) { exit(); }

        if (!empty($_POST['ec_name'])) {
            if (isset($_POST['ec_name'])) {
                $ec_name = secureEncode($_POST['ec_name']);
                $ec_id   = secureEncode($_POST['ec_id']);
                $ec_footer_description   = $_POST['ec_footer_description'];
                $sql_chk_category = $GameMonetizeConnect->query("SELECT id FROM ".CATEGORIES." WHERE name='{$ec_name}'");
                if (true) {
                    if (preg_match("/^[a-zA-Z- .0-9]+$/", $ec_name)) {
                        if (strlen($ec_name) <= 100) {
                            $seo_name = seo_friendly_url($ec_name);

                             if (isset($_FILES['__game_image']['tmp_name'])) {
                                  if (isset($_FILES['__game_image']['tmp_name'])) {
                                  if ($_FILES['__game_image']['size'] > 1024) {
                                        $addgame_media = $_FILES['__game_image'];
                                        $addgame['image'] = uploadGameMediaCategory($addgame_media,$seo_name);
                                        
                                        $addgame_mediaurl = $addgame['image']['url'].'.'.$addgame['image']['extension'];
                                       
                                        $GameMonetizeConnect->query("UPDATE ".CATEGORIES." SET category_pilot='{$seo_name}',name='{$ec_name}',image='{$addgame_mediaurl}',footer_description='{$ec_footer_description}' WHERE id='{$ec_id}'");
                                                
                                    } else { $data['error_message'] = $lang['error_image_size']; }
                                    } else { $data['error_message'] = $lang['message_select_img_files']; }
                            }
                            else {
                               $GameMonetizeConnect->query("UPDATE ".CATEGORIES." SET category_pilot='{$seo_name}',name='{$ec_name}',footer_description='{$ec_footer_description}' WHERE id='{$ec_id}'");
                            }

                            $data = array(
                                'status' => 200,
                                'success_message' => $lang['category_edited']
                            );
                        } else { $data['error_message'] = $lang['category_name_exceed']; }
                    } else { $data['error_message'] = $lang['invalid_characters']; }
                } else { $data['error_message'] = $lang['category_exists']; }
            } else { $data['error_message'] = $lang['error_message']; }
        } else { $data['error_message'] = $lang['must_enter_name']; }

function seo_friendly_url($string){
    $string = str_replace(array('[\', \']'), '', $string);
    $string = preg_replace('/\[.*\]/U', '', $string);
    $string = preg_replace('/&(amp;)?#?[a-z0-9]+;/i', '-', $string);
    $string = htmlentities($string, ENT_COMPAT, 'utf-8');
    $string = preg_replace('/&([a-z])(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig|quot|rsquo);/i', '\\1', $string );
    $string = preg_replace(array('/[^a-z0-9]/i', '/[-]+/') , '-', $string);
    return strtolower(trim($string, '-'));
}