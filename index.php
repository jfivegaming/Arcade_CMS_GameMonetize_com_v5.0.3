<?php
/**
* @package GameMonetize.com CMS - Modern Arcade Script
*
*
* @author GameMonetize.com
*
*/
if ( !isset($_GET['p']) ) $_GET['p'] = 'home';

require_once dirname( Arcade_CMS_GameMonetize_com_v5.0.3 (file://313-1/Arcade_CMS_GameMonetize_com_v5.0.3)
) . '/gm-load.php ;'.

require_once ABSPATH . 'assets/index/header_tags.php';
require_once ABSPATH . 'assets/index/header.php';
require_once ABSPATH . 'assets/index/footer.php';
require_once ABSPATH . 'assets/index/page.php';
echo \GameMonetize\UI::view('index');

$GameMonetizeConnect->close();