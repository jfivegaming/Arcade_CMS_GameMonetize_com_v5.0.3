<ul class="card">
<?php if ( defined("PILOT_GLOBAL") != true ) { die(); }
	$gpilot_id = $GM['game']['data']['game_id'];
	$sql_query_random_game = $GameMonetizeConnect->query("SELECT * FROM `".GAMES."` WHERE `published` = '1' AND `game_id` != '{$gpilot_id}' ORDER BY rand() LIMIT 4");
	while($row = mysqli_fetch_array($sql_query_random_game)) {
		$rand_game = gameData($row);	
?>
	<li class="card-item">
		<figure class="card-game">
			<?php if($row['featured'] == true) { ?>
			<span class="card-icon-corner"></span>
			<i class="fa fa-heart icon-18 icon-corner"></i>
			<?php } ?>
			<a class="g-media" data-href="<?=$rand_game['game_url']?>" href="<?=$rand_game['game_url']?>">
				<img src="<?=$rand_game['image_url']?>" width="140px" height="96px">
				<span class="name ellipsis"><?=$rand_game['name']?></span>
				<figcaption class="caption">
					<div class="rating <?=($row['rating'] <= 3) ? 'emp':''?>" title="<?=$row['rating']?> <?=$lang['of_5_stars']?>" value="<?=$row['rating']?>">
						<span class="fa fa-star"></span>
						<span class="rating-num"><?=$row['rating']?></span>
					</div>
				</figcaption>
			</a>
			<span class="cb-pro"></span>
		</figure>
	</li>
<?php } ?>
</ul>