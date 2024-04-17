<?php
if (!defined('R_PILOT')) {
    exit();
}
if (!empty($_POST['title'])) {
    if (isset($_POST['title'])) {
        $blog_title = secureEncode($_POST['title']);
        $sqlCheck = $GameMonetizeConnect->query("SELECT title FROM " . BLOGS . " WHERE title='{$blog_title}'");
        if ($sqlCheck->num_rows < 1) {
            if (preg_match("/^[a-zA-Z- 0-9.]+$/", $blog_title)) {
                if (strlen($blog_title) <= 100) {
                    $seo_name = seo_friendly_url($blog_title);

                    $isSuccess = $GameMonetizeConnect->query("INSERT INTO " . BLOGS . " (title, url) VALUES ('{$blog_title}', '{$seo_name}')");

                    if ($isSuccess) {
                        // TODO add sitemap
                        // addCategoryXml($seo_name);

                        $data['status'] = 200;
                        $data['success_message'] = $lang['blog_added'];
                        $data['redirect_url'] = siteUrl() . "/admin/blogs/edit/" . $GameMonetizeConnect->insert_id;
                    } else {
                        $data['error_message'] = $lang['error_message'];
                    }
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
