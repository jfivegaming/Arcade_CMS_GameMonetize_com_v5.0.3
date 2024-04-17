<?php
if (!defined('R_PILOT')) {
    exit();
}
// if (!empty($_POST['footer_description'])) {
    // if (isset($_POST['footer_description'])) {
        $footer_description = "";
        if(isset($_POST['footer_description'])){
            $footer_description = $_POST['footer_description'];
        }
        $content_value = "";
        if(isset($_POST['content_value'])){
            $content_value = secureEncode($_POST['content_value']);
        }
        $id   = secureEncode($_POST['id']);
        $seo_name = seo_friendly_url($footer_description);

        $isSuccess = $GameMonetizeConnect->query("UPDATE " . FOOTER_DESCRIPTION . " SET description='{$footer_description}',content_value='{$content_value}' WHERE id='{$id}'");
        if ($isSuccess) {
            $data = array(
                'status' => 200,
                'success_message' => $lang['footerdescription_edited']
            );
        } else {
            $data['error_message'] = $lang['error_message'];
        }
    // } else {
    //     $data['error_message'] = $lang['error_message'];
    // }
// } else {
//     $data['error_message'] = $lang['must_enter_name'];
// }

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
