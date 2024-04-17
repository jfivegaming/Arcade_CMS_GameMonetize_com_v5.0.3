<?php
if (!defined('R_PILOT')) {
    exit();
}

if (!empty($_POST['title'])) {
    if (isset($_POST['title'])) {
        $title = secureEncode($_POST['title']);
        $blog_id   = secureEncode($_POST['blog_id']);
        $post   = $_POST['post'];
        $sql_chk_category = $GameMonetizeConnect->query("SELECT id FROM " . BLOGS . " WHERE title='{$title}'");
        if (true) {
            if (preg_match("/^[a-zA-Z- .]+$/", $title)) {
                if (strlen($title) <= 100) {
                    $seo_name = seo_friendly_url($title);

                    if (isset($_FILES['__game_image']['tmp_name'])) {
                        if (isset($_FILES['__game_image']['tmp_name'])) {
                            if ($_FILES['__game_image']['size'] > 1024) {
                                $addgame_media = $_FILES['__game_image'];
                                $addgame['image'] = uploadBlogImage($addgame_media, $seo_name);

                                $addgame_mediaurl = $addgame['image']['url'] . '.' . $addgame['image']['extension'];

                                $GameMonetizeConnect->query("UPDATE " . BLOGS . " SET url='{$seo_name}',title='{$title}',image_url='{$addgame_mediaurl}',post='{$post}' WHERE id='{$blog_id}'");
                            } else {
                                $data['error_message'] = $lang['error_image_size'];
                            }
                        } else {
                            $data['error_message'] = $lang['message_select_img_files'];
                        }
                    } else {
                        $GameMonetizeConnect->query("UPDATE " . BLOGS . " SET url='{$seo_name}',title='{$title}',post='{$post}' WHERE id='{$blog_id}'");
                    }

                    $data = array(
                        'status' => 200,
                        'success_message' => $lang['blog_edited']
                    );
                } else {
                    $data['error_message'] = $lang['blog_name_exceed'];
                }
            } else {
                $data['error_message'] = $lang['invalid_characters'];
            }
        } else {
            $data['error_message'] = $lang['blog_exists'];
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
