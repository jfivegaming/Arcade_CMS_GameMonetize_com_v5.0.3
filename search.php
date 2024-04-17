<?php
require_once 'assets/includes/core.php';

if($_POST)
{
	$q=$_POST['search'];

	$newGames_query = $GameMonetizeConnect->query("SELECT * FROM ".GAMES." WHERE name like '%$q%' order by game_id desc");

		if($newGames_query->num_rows > 0) { 
			while ($newGames = $newGames_query->fetch_array()) {

						$published = ($newGames['published'] == 1) ? 'pub-active' : '';
						$featured = ($newGames['featured'] == 1) ? 'feat-active' : '';

				echo '<li id="manage--game" class="__mg-'.$newGames['game_id'].' __game-actions _pr _a-c">
	<img src="'.$newGames['image'].'" class="img-circle" style="width: 100%;height: 81px;">
	<div class="_cR3-p ellipsis" style="margin-top:10px;">'.$newGames['name'].'</div>
	<div class="manage--p _p">
		<div>
			<i id="mg--published" class="mg_p-'.$newGames['game_id'].' fa fa-globe icon-18 '.$published.'" data-game="'.$newGames['game_id'].'" data-pb="'.$newGames['published'].'"></i>
			<i id="mg--featured" class="mg_f-'.$newGames['game_id'].' fa fa-heart icon-18 '.$featured.'" data-game="'.$newGames['game_id'].'" data-ft="'.$newGames['featured'].'"></i>
		</div>
		<div>
			<a href="'.$config['site_url'].'/admin/games/edit/'.$newGames['game_id'].'"><i class="fa fa-pencil icon-18 _mg-edit-ic" title="Edit"></i></a>
			<i id="mg--delete" class="mg_d-'.$newGames['game_id'].' fa fa-trash icon-18" data-game="'.$newGames['game_id'].'" title="Delete"></i>
		</div>
	</div>
</li>';
			}
		}
		else {
			echo '<div style="text-align:center;width:200px;margin:0 auto;font-size: 15px;margin-top: 9px;">No search results...</div>'; exit;
		}
}