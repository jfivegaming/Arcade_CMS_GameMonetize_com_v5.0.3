<?php
if (!defined('R_PILOT')) {
    exit();
}
if (!empty($_POST['ac_name'])) {
    if (isset($_POST['ac_name'])) {
        $category_name = secureEncode($_POST['ac_name']);
        $category_footer_description = secureEncode($_POST['ac_footer_description']);
        $sql_chk_category = $GameMonetizeConnect->query("SELECT id FROM " . CATEGORIES . " WHERE name='{$category_name}'");
        if ($sql_chk_category->num_rows < 1) {
            if (preg_match("/^[a-zA-Z- 0-9.]+$/", $category_name)) {
                if (strlen($category_name) <= 100) {
                    $seo_name = seo_friendly_url($category_name);

                    if (isset($_FILES['__game_image']['tmp_name'])) {
                        if (isset($_FILES['__game_image']['tmp_name'])) {
                            if ($_FILES['__game_image']['size'] > 1024) {
                                $addgame_media = $_FILES['__game_image'];
                                $addgame['image'] = uploadGameMediaCategory($addgame_media, $seo_name);

                                $addgame_mediaurl = $addgame['image']['url'] . '.' . $addgame['image']['extension'];

                                $GameMonetizeConnect->query("INSERT INTO " . CATEGORIES . " (category_pilot, name,  image, footer_description) VALUES ('{$seo_name}','{$category_name}', '{$addgame_mediaurl}', '{$category_footer_description}')");
                                addCategoryXml($seo_name);
                            } else {
                                $data['error_message'] = $lang['error_image_size'];
                            }
                        } else {
                            $data['error_message'] = $lang['message_select_img_files'];
                        }
                    } else {
                        $GameMonetizeConnect->query("INSERT INTO " . CATEGORIES . " (category_pilot, name, footer_description) VALUES ('{$seo_name}','{$category_name}','{$category_footer_description}')");
                        addCategoryXml($seo_name);
                    }

                    $data['status'] = 200;
                    $data['success_message'] = $lang['category_registered'];
                } else {
                    $data['error_message'] = $lang['category_name_exceed'];
                }
            } else {
                $data['error_message'] = $lang['invalid_characters'];
            }
        } else {
            $data['error_message'] = $lang['category_exists'];
        }
    } else {
        $data['error_message'] = $lang['error_message'];
    }
} else {
    $data['error_message'] = $lang['must_enter_name'];
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
