<?php

if (!defined('R_PILOT')) exit();

$catalog = file_get_contents('https://gamemonetize.com/feed.php?format=0&num=1000');

if (!!$catalog) {
      $games = json_decode($catalog, true);

      $i = 0;
      foreach ($games as $game) {

            $title = seo_friendly_url($game['title']);
            $user_info = "SELECT * FROM `" . GAMES . "` WHERE `game_name` = '$title'";
            $user_info_query = $GameMonetizeConnect->query($user_info);

            if ($user_info_query->num_rows == 0) {

                  $game_data = array();
                  $game_data['catalog_id'] = secureEncode($game['id']);
                  $game_data['game_name'] = secureEncode($title);
                  $game_data['name'] = secureEncode($game['title']);
                  $game_data['description'] = !empty($game['description']) ? secureEncode($game['description']) : '';
                  $game_data['instructions'] = !empty($game['instructions']) ? secureEncode($game['instructions']) : '';
                  $game_data['file'] = secureEncode($game['url']);
                  $game_data['width'] = $game['width'];
                  $game_data['height'] = $game['height'];
                  $game_data['image'] = $game['thumb'];

                  // Get category from database
                  $category_data = getCategoriesLikeName($game['category']);
                  if($category_data !== null){
                        $category = $category_data['id'];                        
                  }

                  // Get tags from database
                  $allTags = explode(",", $game['tags']);
                  $allTagsId = [];
                  foreach($allTags as $tag){
                        $tag_data = getTagsLikeName(trim($tag));
                        $allTagsId[] = "\"{$tag_data["id"]}\"";
                  }
                  if(count($allTagsId) > 0){
                        $tags = "[".implode(",", $allTagsId)."]";
                  }

                  // $category = $game['category'];

                  // if ($category == "Arcade") {
                  //       $category = "4";
                  // }
                  // if ($category == "Action") {
                  //       $category = "1";
                  // }
                  // if ($category == "Puzzles") {
                  //       $category = "5";
                  // }
                  // if ($category == "Multiplayer") {
                  //       $category = "7";
                  // }
                  // if ($category == "Shooting") {
                  //       $category = "3";
                  // }
                  // if ($category == "Driving") {
                  //       $category = "2";
                  // }
                  // if ($category == "Sports") {
                  //       $category = "8";
                  // }
                  // if ($category == "Fighting") {
                  //       $category = "9";
                  // }

                  $isSuccess = $GameMonetizeConnect->query("INSERT INTO " . GAMES . " (
                        catalog_id, 
                        game_name, 
                        name, 
                        image, 
                        description, 
                        instructions, 
                        category, 
                        file, 
                        game_type, 
                        w, 
                        h, 
                        date_added, 
                        tags_ids,
                        published
                  ) VALUES (
                        'gamemonetize-{$game_data['catalog_id']}',
                        '{$game_data['game_name']}',
                        '{$game_data['name']}',
                        '{$game_data['image']}',
                        '{$game_data['description']}',
                        '{$array_item['instruction']}',
                        '{$category}',
                        '{$game_data['file']}',
                        'html5',
                        '{$game_data['width']}',
                        '{$game_data['height']}',
                        '{$time}', 
                        '{$tags}',
                        '1'
                  )");
                  if ($isSuccess) {
                        addGameXml(siteUrl() . '/game/' . $game_data['game_name']);
                  }
                  $i++;
            }
      }

      sleep(0.7);

      $data['message'] = $i . ' ' . $lang['admin_premium_games_installed'];
} else {
      $data['error_message'] = 'Something went wrong!';
}

function seo_friendly_url($string)
{
      $string = str_replace(array('[\', \']'), '', $string);
      $string = preg_replace('/\[.*\]/U', '', $string);
      $string = preg_replace('/&(amp;)?#?[a-z0-9]+;/i', '-', $string);
      $string = htmlentities($string, ENT_COMPAT, 'utf-8');
      $string = preg_replace('/&([a-z])(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig|quot|rsquo);/i', '\\1', $string);
      $string = preg_replace(array('/[^a-z0-9]/i', '/[-]+/'), '-', $string);
      return strtolower(trim($string, '-'));
}
