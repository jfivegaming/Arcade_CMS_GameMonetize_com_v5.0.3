<?php
require_once 'assets/includes/core.php';

if (isset($_GET["LoadedGamesNum"]) && isset($_GET["num"]) && isset($_GET["ids"])) {

	$from = $_GET["LoadedGamesNum"];
	$num = $_GET["num"];
	$ids = $_GET["ids"];
	if ($ids == "") exit;

	if (!is_numeric($from) || !is_numeric($num)) exit;
	if (isset($_GET["cat"])) {
		$cat = $_GET["cat"];
		$newGames_query = $GameMonetizeConnect->query("SELECT * FROM " . GAMES . " WHERE published='1' and category=$cat and `game_id` not in(" . $ids . ") order by `game_id` asc,  featured desc  limit " . $from . "," . $num);
	} else if (isset($_GET["pagetype"])) {
		if ($_GET["pagetype"] == "best") {
			$newGames_query = $GameMonetizeConnect->query("SELECT * FROM " . GAMES . " WHERE published='1' and `game_id` not in(" . $ids . ") order by `plays` desc  limit " . $from . "," . $num);
		} else if ($_GET["pagetype"] == "tags") {
			$from += 50;
			$newGames_query = $GameMonetizeConnect->query("SELECT * FROM " . GAMES . " WHERE published='1' and tags_ids LIKE '%\"{$ids}\"%' order by `plays` desc  limit " . $from . "," . $num);
		} else {
			$newGames_query = $GameMonetizeConnect->query("SELECT * FROM " . GAMES . " WHERE published='1' and `game_id` not in(" . $ids . ") ORDER BY featured DESC, date_added desc, featured_sorting desc limit " . $from . "," . $num);
		}
	} else {
		$newGames_query = $GameMonetizeConnect->query("SELECT * FROM " . GAMES . " WHERE published='1' and `game_id` not in(" . $ids . ") order by `game_id` asc  limit " . $from . "," . $num);
	}
	// var_dump("SELECT * FROM " . GAMES . " WHERE published='1' and tags_ids LIKE '%\"{$ids}\"% order by `plays` desc  limit " . $from . "," . $num);die;
	if ($newGames_query->num_rows > 0) {
		while ($newGames = $newGames_query->fetch_array()) {
			echo "<div class='post'>
				    <a href='" . $config['site_url'] . "/game/" . $newGames['game_name'] . "' class='game-item'>
				        <img src='" . $newGames['image'] . "' alt='" . $newGames['name'] . "'>
				        <p class='post-name' data-url='" . $newGames['video_url'] . "' data-scale='1.2' data-translate='-23px,-25px'>" . $newGames['name'] . "</p>
				        <div class='rank'></div>";

			if ($newGames['featured'] == "1") {
				echo "<span class='featured_icon'></span>";
			}
			echo "</a>
				</div>";
		}
	} else {
		echo "NoData";
		exit;
	}
} else {
	header("Location : /");
}
