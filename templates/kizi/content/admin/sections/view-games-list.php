<li id="manage--game" class="__mg-{{VIEW_GAME_ID}} __game-actions _pr _a-c">
	<img src="{{VIEW_GAME_IMAGE}}" class="img-circle" style="width: 100%;height: 81px;">
	<div class="_cR3-p ellipsis" style="margin-top:10px;">{{VIEW_GAME_NAME}}</div>
	<div class="manage--p _p">
		<div>
			<i id="mg--published" class="mg_p-{{VIEW_GAME_ID}} fa fa-globe icon-18 {{VIEW_PUBLISHED_CLASS_STATUS}}" data-game="{{VIEW_GAME_ID}}" data-pb="{{VIEW_GAME_PUBLISHED}}"></i>
			<i id="mg--featured" class="mg_f-{{VIEW_GAME_ID}} fa fa-heart icon-18 {{VIEW_FEATURED_CLASS_STATUS}}" data-game="{{VIEW_GAME_ID}}" data-ft="{{VIEW_GAME_FEATURED}}"></i>
		</div>
		<div>
			<a href="{{CONFIG_SITE_URL}}/admin/games/edit/{{VIEW_GAME_ID}}"><i class="fa fa-pencil icon-18 _mg-edit-ic" title="@edit@"></i></a>
			<i id="mg--delete" class="mg_d-{{VIEW_GAME_ID}} fa fa-trash icon-18" data-game="{{VIEW_GAME_ID}}" title="@delete@"></i>
		</div>
	</div>
</li>