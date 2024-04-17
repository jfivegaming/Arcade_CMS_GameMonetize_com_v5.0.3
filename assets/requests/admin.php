<?php
if (!defined('R_PILOT')) exit();
accessOnly();
function checkAllowedUrlFromJson($sourceUrl)
{
	// $allowedUrls = json_decode(file_get_contents('https://www.bestcrazygames.com/lock.json'));
	$allowedUrls = json_decode(file_get_contents('https://gamemonetize.com/lockcms.json'));
	$allowed = false;
	foreach ($allowedUrls as $url) {
		if (strpos($sourceUrl, $url->domain) !== false) {
			$allowed = true;
			break;
		}
	}
	return $allowed;
}
if ($userData['admin']) {

	include(ABSPATH . 'assets/requests/admin/' . $a . '.php');

	header("Content-type: application/json");
	echo json_encode($data);
	$GameMonetizeConnect->close();
	exit();
}
