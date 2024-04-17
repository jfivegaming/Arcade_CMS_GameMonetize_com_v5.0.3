<?php 
    if (!defined('R_PILOT')) { exit(); }

        if ( !empty($_POST['ss_sitename']) && !empty($_POST['ss_siteurl']) && !empty($_POST['ss_sitetheme'])) {
            if ( isset($_POST['ss_sitename']) && isset($_POST['ss_siteurl']) && isset($_POST['ss_sitetheme'])) {
                $adm_ss = array();
                $adm_ss['site_name']        = secureEncode($_POST['ss_sitename']);
                $adm_ss['site_url']         = secureEncode($_POST['ss_siteurl']);
                $adm_ss['site_theme']       = secureEncode($_POST['ss_sitetheme']);
                $adm_ss['site_description'] = secureEncode($_POST['ss_sitedescription']);
                $adm_ss['site_keywords']    = secureEncode($_POST['ss_sitekeywords']);
                $adm_ss['site_ads']         = (isset($_POST['ss_ads'])) ? '1' : '0';
                $adm_ss['xp_play']          = secureEncode($_POST['ss_xp_play']);
                $adm_ss['xp_report']        = secureEncode($_POST['ss_xp_report']);
                $adm_ss['xp_register']      = secureEncode($_POST['ss_xp_register']);
                $adm_ss['featured_game_limit'] = secureEncode($_POST['ss_featured_game_limit']);
                $adm_ss['mp_game_limit']    = secureEncode($_POST['ss_mp_game_limit']);

                if (empty($adm_ss['xp_play']) && $adm_ss['xp_play'] == NULL && is_numeric($adm_ss['xp_play'])) {
                    $adm_ss['xp_play'] = '0';
                } if (empty($adm_ss['xp_report']) && $adm_ss['xp_report'] == NULL && is_numeric($adm_ss['xp_report'])) {
                    $adm_ss['xp_report'] = '0';
                } if (empty($adm_ss['xp_register']) && $adm_ss['xp_register'] == NULL && is_numeric($adm_ss['xp_register'])) {
                    $adm_ss['xp_register'] = '0';
                } if (empty($adm_ss['featured_game_limit']) && $adm_ss['featured_game_limit'] == NULL && is_numeric($adm_ss['featured_game_limit'])) {
                    $adm_ss['featured_game_limit'] = '0';
                } if (empty($adm_ss['mp_game_limit']) && $adm_ss['mp_game_limit'] == NULL && is_numeric($adm_ss['mp_game_limit'])) {
                    $adm_ss['mp_game_limit'] = '0';
                }
                
                $GameMonetizeConnect->query("UPDATE ".SETTING." SET site_name='{$adm_ss['site_name']}', site_url='{$adm_ss['site_url']}', site_theme='{$adm_ss['site_theme']}', site_description='{$adm_ss['site_description']}', site_keywords='{$adm_ss['site_keywords']}', language='english', ads_status='{$adm_ss['site_ads']}', xp_play='{$adm_ss['xp_play']}', xp_report='{$adm_ss['xp_report']}', xp_register='{$adm_ss['xp_register']}', featured_game_limit='{$adm_ss['featured_game_limit']}', mp_game_limit='{$adm_ss['mp_game_limit']}' WHERE id='1'");

                $data['status'] = 200;
                $data['success_message'] = $lang['setting_saved'];
            } else { $data['error_message'] = $lang['error_message']; }
        } else { $data['error_message'] = $lang['empty_place']; }