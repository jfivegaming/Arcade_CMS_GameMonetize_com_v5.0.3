<?php 
    if (!defined('R_PILOT')) { exit(); }

	if (isset($_POST['search_parameter'])) {
        $data['status'] = 200;
        $data['redirect_url'] = siteUrl().'/search/'.$_POST['search_parameter'];
    }

    header("Content-type: application/json");
    echo json_encode($data);
    $GameMonetizeConnect->close();
    exit();