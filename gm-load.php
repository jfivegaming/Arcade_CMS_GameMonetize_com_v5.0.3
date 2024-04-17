<?php

/**
 * @package GameMonetize.com CMS - Modern Arcade Script
 */

if (!defined('ABSPATH'))
	define('ABSPATH', dirname(__FILE__) . '/');

error_reporting(0);

require_once ABSPATH . 'assets/includes/core.php';

if (!td_installing() && false === strpos($_SERVER['REQUEST_URI'], 'setup-config') && false === strpos($_SERVER['REQUEST_URI'], 'install')) {
	header('Location: assets/setup-config.php');
	exit;
}
