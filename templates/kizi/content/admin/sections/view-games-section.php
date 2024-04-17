<div class="gamemonetize-main-headself">
	<i class="fa fa-gamepad"></i>
	<div style="margin-left:20px;display:inline-block;position:relative;top:-10px;float:right;">

		<div class="_input-box" style="float: right;height: 37px;width:720px;margin-top: 2px;margin-bottom: 0px;">
			<img src="{{CONFIG_THEME_PATH}}/image/icon-color/controller.png" style="left: 8px;top: 4px;">
			<input style="padding-left: 43px !important;border:none;width:100%;outline:none;" class="searchbox" type="search" class="_text-input _tr5" name="keyword" id="searchBox" placeholder="Search game.." autocomplete="off">
		</div>
	</div>
</div>
<style>
	input[type=number]::-webkit-inner-spin-button,
	input[type=number]::-webkit-outer-spin-button {
		opacity: 1;
	}
</style>
<div class="general-box">
	<!-- <button id="publish-all-games" class="btn-p btn-p4"><i class="fa fa-globe"></i> Publish all games</button> -->
	<!-- <button id="install-games" style="margin-left:5px;" class="btn-p btn-premium"><i class="fa fa-star"></i> Install Games</button> -->
	<button id="install-games-100" style="margin-left:5px;" class="btn-p btn-premium"><i class="fa fa-star"></i> Install Last 100 Games</button>
	<button id="install-games-1000" style="margin-left:5px;" class="btn-p btn-premium"><i class="fa fa-star"></i> Install Last 1000 Games</button>
	<hr>
	<input type="number" id="install-games-custom-value" min="0" value="1">
	<button id="install-games-custom" style="margin-left:5px;" class="btn-p btn-premium"><i class="fa fa-star"></i> Install Games Custom Number</button>
	<input id="custom_game_feed_url" type="text" name="custom_game_feed_url" value="{{CUSTOM_GAME_FEED_URL}}" style="width: 300px;">
	<button id="save-custom-feed" class="btn-p btn-premium">Save</button>
	<a href="https://gamemonetize.com/rss-builder" target="_blank">RSS Builder</a>
	<hr>
	<div class="installing-message"></div>
</div>
{{GAMES_CONTAINER}}