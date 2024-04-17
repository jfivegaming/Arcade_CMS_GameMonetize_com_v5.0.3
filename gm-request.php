<?php 
/**
* GameMonetize.com - Copyright © 2021
*
*
* @author GameMonetize.com
*
*/

require_once( dirname( __FILE__ ) . '/gm-load.php');

define('R_PILOT', true);

function accessOnly()
{
    if ( !is_logged() )
    {
        global $GameMonetizeConnect;
        $GameMonetizeConnect->close();
        exit("Log in to continue, please");
    }
}

$t = (!isset($_GET['t'])) ? "" : secureEncode($_GET['t']);
$a = (!isset($_GET['a'])) ? "" : secureEncode($_GET['a']);

$data = array(
    'status' => 417
);

if (empty($t))
{
    exit('a');
}

include(ABSPATH . 'assets/requests/' . $t . '.php');