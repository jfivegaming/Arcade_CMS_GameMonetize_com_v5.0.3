<?php
/**
* @package GameMonetize CMS - Awesome Arcade CMS
*
*
* @author GameMonetize.com
*
*/

if ( ! defined( 'ABSPATH' ) ) {
    define( 'ABSPATH', dirname(dirname( __FILE__ )) . '/' );
}

function include_addons_load($GameMonetizeConnect) {
	$addon_main_file_name = 'main.php';

	if (isset($_SESSION['load_addons']) && is_array($_SESSION['load_addons'])) {
		foreach ($_SESSION['load_addons'] as $init_addon) {
			$main_file_root = $init_addon . '/' . $addon_main_file_name;
			if (file_exists($main_file_root)) {
				require $main_file_root;
			}
		}
		return true;
	}

	if ( !isset ($_SESSION['addons']) ) {
		$_SESSION['addons'] = array();
	}

	$_SESSION['load_addons'] = array();
	$addons = glob(ABSPATH . 'gm-content/addons/*', GLOB_ONLYDIR);
	
	usort($addons, function($a, $b) {
		return filectime($a) - filectime($b);
	});
	foreach ($addons as $addOn) {
		$main_file_root = $addOn . '/' . $addon_main_file_name;
		if (file_exists($main_file_root)) {
			require $main_file_root;
		}
		$_SESSION['load_addons'][] = $addOn;
	}
}

include_addons_load($GameMonetizeConnect);