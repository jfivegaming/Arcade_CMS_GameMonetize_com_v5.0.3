<?php 
    if (!defined('R_PILOT')) { exit(); }
    
        $ads_area = array();
        $ads_area['728x90']     = '';
        $ads_area['300x250']    = '';
        $ads_area['600x300']    = '';
        $ads_area['728x90_main']    = '';
        $ads_area['300x250_main'] = '';
        $ads_area['ads_video']   = '';
        if (!empty($_POST['ad_728x90'])) {
            $ads_area['728x90'] = $_POST['ad_728x90'];
            $ads_area['728x90'] = str_replace("'", '"', $ads_area['728x90']);
        }
        if (!empty($_POST['ad_300x250'])) {
            $ads_area['300x250'] = $_POST['ad_300x250'];
            $ads_area['300x250'] = str_replace("'", '"', $ads_area['300x250']);
        }
        if (!empty($_POST['ad_600x300'])) {
            $ads_area['600x300'] = $_POST['ad_600x300'];
            $ads_area['600x300'] = str_replace("'", '"', $ads_area['600x300']);
        }
        if (!empty($_POST['ad_728x90_main'])) {
            $ads_area['728x90_main'] = $_POST['ad_728x90_main'];
            $ads_area['728x90_main'] = str_replace("'", '"', $ads_area['728x90_main']);
        }
        if (!empty($_POST['ad_300x250_main'])) {
            $ads_area['300x250_main'] = $_POST['ad_300x250_main'];
            $ads_area['300x250_main'] = str_replace("'", '"', $ads_area['300x250_main']);
        }
        if (!empty($_POST['ads_video'])) {
            $ads_area['ads_video'] = $_POST['ads_video'];
            $ads_area['ads_video'] = str_replace("'", '"', $ads_area['ads_video']);
        }

        $GameMonetizeConnect->query("UPDATE ".ADS." SET 728x90='{$ads_area['728x90']}', 300x250='{$ads_area['300x250']}', 600x300='{$ads_area['600x300']}', 728x90_main='{$ads_area['728x90_main']}', 300x250_main='{$ads_area['300x250_main']}', ads_video='{$ads_area['ads_video']}'") or die();
        $data['status'] = 200;
        $data['success_message'] = $lang['ads_saved'];