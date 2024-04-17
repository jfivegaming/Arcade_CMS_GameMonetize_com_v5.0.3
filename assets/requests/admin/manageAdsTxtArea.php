<?php 
    if (!defined('R_PILOT')) { eit(); }

if ( ! defined( 'ABSPATH' ) ) {
    define( 'ABSPATH', dirname( dirname( __FILE__ ) ) . '/' );
}
$url = ABSPATH . 'ads.txt';

// check if form has been submitted
if (isset($_POST['adstxt']))
{   
    try {
     chmod($url, 0777);
    } catch (Exception $e) {
    }
    // save the text contents
    file_put_contents($url, $_POST['adstxt']);

    $data['status'] = 200;
    $data['success_message'] = "Ads.txt saved successfully";
}