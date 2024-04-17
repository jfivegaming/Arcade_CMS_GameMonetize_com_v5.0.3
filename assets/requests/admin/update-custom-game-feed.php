<?php

if (!defined('R_PILOT')) exit();
$customGameFeed = $_POST['customGameFeed'];
if (strlen($customGameFeed) < 3) {
      $data['error_message'] = 'Url not valid!';
} else {
      $sqlUpdate = "UPDATE `" . SETTING . "` SET `custom_game_feed_url` = '$customGameFeed'";
      $updateStatus = $GameMonetizeConnect->query($sqlUpdate);
      if($updateStatus) {
            $data['status'] = 200;
            $data['message'] = 'Custom game feed url updated!';
      } else {
            $data['error_message'] = 'Something went wrong!';
      }
}
