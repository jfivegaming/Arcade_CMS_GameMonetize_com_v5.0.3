<?php
$data = addon(array('addon_add_ajax', 'array'), $data);

header("Content-type: application/json");
echo json_encode($data);
$GameMonetizeConnect->close();
exit();