<?php
if (!defined('R_PILOT')) {
    exit();
}
if (!empty($_POST['ac_name'])) {
    if (isset($_POST['ac_name'])) {
        $tags_name = secureEncode($_POST['ac_name']);
        $footer_description   = $_POST['ac_footer_description'];

        $sql_chk_tags = $GameMonetizeConnect->query("SELECT id FROM " . TAGS . " WHERE name='{$tags_name}'");
        if ($sql_chk_tags->num_rows < 1) {
            // if (preg_match("/^[a-zA-Z- ]+$/", $tags_name)) {
            if (preg_match("/^[a-zA-Z\d\- ]+$/", $tags_name)) {
                if (strlen($tags_name) <= 100) {
                    $seo_name = seo_friendly_url($tags_name);

                    $isSuccess = $GameMonetizeConnect->query("INSERT INTO " . TAGS . " (url, name, footer_description) VALUES ('{$seo_name}','{$tags_name}','{$footer_description}')");

                    addTagsXml($seo_name);

                    if($isSuccess){
                        $data['status'] = 200;
                        $data['success_message'] = $lang['tags_registered'];
                    }else{
                        $data['error_message'] = $lang['error_message'];
                    }
                } else {
                    $data['error_message'] = $lang['tags_name_exceed'];
                }
            } else {
                $data['error_message'] = $lang['invalid_characters'];
            }
        } else {
            $data['error_message'] = $lang['tags_exists'];
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
