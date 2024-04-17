<?php
if (!defined('R_PILOT')) {
    exit();
}
// Url checking
$isUrlAllowed = checkAllowedUrlFromJson($_POST['game_file']);

if ($isUrlAllowed) {
    if (!empty($_POST['game_name']) && !empty($_POST['game_width']) && !empty($_POST['game_height']) && !empty($_POST['game_category'])) {
        if (isset($_POST['game_name']) && isset($_POST['game_width']) && isset($_POST['game_height']) && isset($_POST['game_category']) && isset($_POST['game_published']) && isset($_POST['game_featured'])) {
            $addgame = array();
            $addgame['name']         = secureEncode($_POST['game_name']);
            $addgame['description']  = $_POST['game_description'];
            $addgame['instructions'] = $_POST['game_instructions'];
            $addgame['width']        = secureEncode($_POST['game_width']);
            $addgame['height']       = secureEncode($_POST['game_height']);
            $addgame['category']     = secureEncode($_POST['game_category']);
            $addgame['published']    = secureEncode($_POST['game_published']);
            $addgame['featured']     = secureEncode($_POST['game_featured']);
            $addgame['import']       = secureEncode($_POST['game_import']);
            $addgame['game_type']    = secureEncode($_POST['game_file_type']);
            $addgame['rating']       = 0;
            $addgame['sorting']      = secureEncode($_POST['game_sorting']);

            $addgame['game_tags'] = '';
            if (isset($_POST['game_tags']) && !is_null($_POST['game_tags'])) {
                $addgame['game_tags'] = json_encode($_POST['game_tags']);
            }

            $gamename = $_POST['game_name'];
            $gamename = seo_friendly_url($gamename);
            $addgame['game_name']    = secureEncode($gamename);
            if ($addgame['import'] == 0) {
                if (!empty($_POST['game_image'])) {
                    if (!empty($_POST['game_file'])) {
                        $addgame_mediaurl = secureEncode($_POST['game_image']);
                        $addgame['file']  = secureEncode($_POST['game_file']);

                        $isSuccess = $GameMonetizeConnect->query("INSERT INTO " . GAMES . " (
                                name, game_name, image, import, 
                                category, description, instructions, file, 
                                game_type, w, h, date_added, 
                                published, featured, rating, featured_sorting,
                                tags_ids
                            ) VALUES (
                                '{$addgame['name']}', '{$addgame['game_name']}', '{$addgame_mediaurl}', '0', 
                                '{$addgame['category']}', '{$addgame['description']}', '{$addgame['instructions']}', '{$addgame['file']}', 
                                '{$addgame['game_type']}', '{$addgame['width']}', '{$addgame['height']}', '{$time}', 
                                '{$addgame['published']}', '{$addgame['featured']}', '{$addgame['rating']}', '{$addgame['sorting']}',
                                '{$addgame['game_tags']}'
                            )");

                        $data['status'] = 200;
                        $data['success_message'] = $lang['game_saved'];
                        if ($isSuccess) {
                            addGameXml(siteUrl() . '/game/' . $addgame['game_name']);
                        }
                    } else {
                        $data['error_message'] = $lang['fileurl_empty'];
                    }
                } else {
                    $data['error_message'] = $lang['imageurl_empty'];
                }
            } else if ($addgame['import'] == 1) {
                if (isset($_FILES['__game_image']['tmp_name'])) {
                    if ($_FILES['__game_image']['size'] > 1024) {
                        $addgame_media = $_FILES['__game_image'];
                        $addgame['image'] = uploadGameMedia($addgame_media, $gamename);
                        $addgame_mediaurl = $addgame['image']['url'] . '.' . $addgame['image']['extension'];

                        //$addgame_mediaurl = secureEncode($_POST['game_image']);
                        $addgame['file']  = secureEncode($_POST['game_file']);

                        if (true) {
                            if (true) {
                                if ($addgame['game_tags'] == '') {
                                    $addgame['game_tags'] = 'NULL';
                                } else {
                                    $addgame['game_tags'] = "'{$addgame['game_tags']}'";
                                }

                                $isSuccess = $GameMonetizeConnect->query("INSERT INTO " . GAMES . " (
                                        name, game_name , image, import, 
                                        category, description, instructions, file, 
                                        game_type, w, h, date_added, 
                                        published, featured, rating, featured_sorting,
                                        tags_ids
                                    ) VALUES (
                                        '{$addgame['name']}', '{$addgame['game_name']}' , '{$addgame_mediaurl}', '1', 
                                        '{$addgame['category']}', '{$addgame['description']}', '{$addgame['instructions']}', '{$addgame['file']}',
                                        '{$addgame['game_type']}', '{$addgame['width']}', '{$addgame['height']}', '{$time}',
                                        '{$addgame['published']}', '{$addgame['featured']}', '{$addgame['rating']}', '{$addgame['sorting']}',
                                        {$addgame['game_tags']}
                                    )");

                                $data['status'] = 200;
                                $data['success_message'] = $lang['game_saved'];

                                if($isSuccess){
                                    addGameXml(siteUrl() . '/game/' . $addgame['game_name']);
                                }
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
} else {
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
