<?php
if (!defined('R_PILOT')) {
    exit();
}

// Url checking
$isUrlAllowed = checkAllowedUrlFromJson($_POST['eg_file']);
if ($isUrlAllowed){
    if (!empty($_POST['eg_name']) && !empty($_POST['eg_width']) && !empty($_POST['eg_height']) && !empty($_POST['eg_category'])) {
        if (isset($_POST['eg_name']) && isset($_POST['eg_width']) && isset($_POST['eg_height']) && isset($_POST['eg_category'])) {
            $editgame = array();
            $editgame['name']         = secureEncode($_POST['eg_name']);
            // $editgame['description']  = $_POST['eg_description'];
            $editgame['description']  = htmlspecialchars_decode($_POST['eg_description']);
            $editgame['instructions'] = $_POST['eg_instructions'];
            $editgame['width']        = secureEncode($_POST['eg_width']);
            $editgame['height']       = secureEncode($_POST['eg_height']);
            $editgame['category']     = secureEncode($_POST['eg_category']);
            $editgame['import']       = secureEncode($_POST['eg_import']);
            $editgame['type']         = secureEncode($_POST['eg_file_type']);
            $editgame['id']           = secureEncode($_POST['eg_id']);
            // $editgame['rating']       = secureEncode($_POST['eg_rating']);
            $editgame['rating']       = 0;
            $editgame['sorting']      = secureEncode($_POST['eg_sorting']);
            $editgame['game_tags']      = json_encode($_POST['eg_tags']);
            $editgame['video_url']      = $_POST['eg_video_url'];

            $gamename = $_POST['eg_name'];
            $gamename = seo_friendly_url($gamename);
            $editgame['game_name']    = secureEncode($gamename);
    
            if ($editgame['import'] == 0) {
                if (!empty($_POST['eg_image'])) {
                    if (!empty($_POST['eg_file'])) {
                        $editgame_mediaurl = secureEncode($_POST['eg_image']);
                        $editgame['file'] = secureEncode($_POST['eg_file']);
                    //     print_r("UPDATE " . GAMES . " SET 
                    //     name='{$editgame['name']}',
                    //     game_name='{$editgame['game_name']}',
                    //     image='{$editgame_mediaurl}',
                    //     import='0',
                    //     category='{$editgame['category']}',
                    //     description='{$editgame['description']}',
                    //     instructions='{$editgame['instructions']}',
                    //     file='{$editgame['file']}',
                    //     game_type='{$editgame['type']}',
                    //     w='{$editgame['width']}',
                    //     h='{$editgame['height']}',
                    //     rating='{$editgame['rating']}',
                    //     featured_sorting='{$editgame['sorting']}', 
                    //     tags_ids='{$editgame['game_tags']}', 
                    //     video_url='{$editgame['video_url']}' 
                    //     WHERE game_id='{$editgame['id']}'
                    // ");
                        // print_r($editgame['description']);
                        // print_r(htmlspecialchars($editgame['description']));
                        // print_r(htmlspecialchars_decode($editgame['description']));
                        // die;
    
                        $isSuccess = $GameMonetizeConnect->query("UPDATE " . GAMES . " SET 
                                    name='{$editgame['name']}',
                                    game_name='{$editgame['game_name']}',
                                    image='{$editgame_mediaurl}',
                                    import='0',
                                    category='{$editgame['category']}',
                                    description='{$editgame['description']}',
                                    instructions='{$editgame['instructions']}',
                                    file='{$editgame['file']}',
                                    game_type='{$editgame['type']}',
                                    w='{$editgame['width']}',
                                    h='{$editgame['height']}',
                                    rating='{$editgame['rating']}',
                                    featured_sorting='{$editgame['sorting']}', 
                                    tags_ids='{$editgame['game_tags']}', 
                                    video_url='{$editgame['video_url']}' 
                                    WHERE game_id='{$editgame['id']}'
                                ");
    
                        $data = array(
                            'status' => 200,
                            'success_message' => $lang['game_saved'],
                            'game_name' => $editgame['name'],
                            'game_img' => $editgame_mediaurl
                        );
                    } else {
                        $data['error_message'] = $lang['fileurl_empty'];
                    }
                } else {
                    $data['error_message'] = $lang['imageurl_empty'];
                }
            } else if ($editgame['import'] == 1) {
                if (isset($_FILES['__eg_image']['tmp_name'])) {
                    if ($_FILES['__eg_image']['size'] > 1024) {
                        $editgame_media = $_FILES['__eg_image'];
                        $editgame['image'] = uploadGameMedia($editgame_media, $gamename);
                        $editgame_mediaurl = $editgame['image']['url'] . '.' . $editgame['image']['extension'];
    
    
                        $editgame['file'] = secureEncode($_POST['eg_file']);
    
                        $game_target_path = "data-photo/data-game/games/";
                        if (true) {
                            if (true) {
    
                                $isSuccess = $GameMonetizeConnect->query("UPDATE " . GAMES . " SET 
                                            name='{$editgame['name']}',
                                            game_name='{$editgame['game_name']}',
                                            image='{$editgame_mediaurl}',
                                            import='0',
                                            category='{$editgame['category']}',
                                            description='{$editgame['description']}',
                                            instructions='{$editgame['instructions']}',
                                            file='{$editgame['file']}',
                                            game_type='{$editgame['type']}',
                                            w='{$editgame['width']}',
                                            h='{$editgame['height']}',
                                            rating='{$editgame['rating']}',
                                            featured_sorting='{$editgame['sorting']}', 
                                            tags_ids='{$editgame['game_tags']}',
                                            video_url='{$editgame['video_url']}' 
                                            WHERE game_id='{$editgame['id']}'
                                        ");
    
                                $data = array(
                                    'status' => 200,
                                    'success_message' => $lang['game_saved'],
                                    'game_name' => $editgame['name'],
                                    'game_img' => $editgame_mediaurl
                                );
                            } else {
                                $data['error_message'] = $lang['error_file_upload'];
                            }
                        } else {
                            $data['error_message'] = $lang['error_file_extension'];
                        }
                    } else {
                        $data['error_message'] = $lang['error_image_size'];
                    }
                } else {
                    $data['error_message'] = $lang['message_select_img_files'];
                }
            } else {
                $data['error_message'] = $lang['error_message'];
            }
        } else {
            $data['error_message'] = $lang['error_message'];
        }
    } else {
        $data['error_message'] = $lang['empty_place'];
    }
}else{
    $data['error_message'] = $lang['url_not_allowed'];
}

function seo_friendly_url($string)
{
    $string = str_replace(array('[\', \']'), '', $string);
    $string = preg_replace('/\[.*\]/U', '', $string);
    $string = preg_replace('/&(amp;)?#?[a-z0-9]+;/i', '-', $string);
    $string = htmlentities($string, ENT_COMPAT, 'utf-8');
    $string = preg_replace('/&([a-z])(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig|quot|rsquo);/i', '\\1', $string);
    $string = preg_replace(array('/[^a-z0-9]/i', '/[-]+/'), '-', $string);
    return strtolower(trim($string, '-'));
}
