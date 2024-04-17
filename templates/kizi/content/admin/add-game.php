<div class="gamemonetize-main-headself">
	<i class="fa fa-plus"></i>
</div>
<div class="general-box _yt10 _yb10 _0e4">
	<form id="addgame-form" enctype="multipart/form-data">
		<div class="g-d5 addgame-dashboard">
			<div class="r05-t _5e4">
				<div class="_input-box">
					<img src="{{CONFIG_THEME_PATH}}/image/icon-color/admin/name.png">
					<input placeholder="@game_name@" class="_text-input _tr5" type="text" name="game_name">
				</div>
				<div>
					<textarea rows="15" style="height:337px;" placeholder="@game_description@" class="_text-input _tr5" name="game_description"></textarea>
				</div>
				<div style="display:none;">
					<textarea placeholder="@game_instructions@" class="_text-input _tr5" name="game_instructions"></textarea>
				</div>
				<div>
					<img src="{{CONFIG_THEME_PATH}}/image/icon-color/admin/category.png" width="20">
					<span class="_tr5">@game_category@</span>
					<select name="game_category" class="_p4s8">
						{{GET_CATEGORIES}}
					</select>
				</div>
				<div style="margin-top: 5px;">
					<img src="{{CONFIG_THEME_PATH}}/image/icon-color/admin/category.png" width="20">
					<span class="_tr5">@game_tags@</span>
					<select name="game_tags[]" class="_p4s8 select2" multiple style="width: 500px;">
						{{GET_TAGS}}
					</select>
				</div>
			</div>
			<div class="r05-t _5e4">
				<div>
					<div id="game_import0">
						<div class="_input-box" style="display:none;">
							<img src="{{CONFIG_THEME_PATH}}/image/icon-color/admin/image.png">
							<input placeholder="Image URL" class="_text-input _tr5" type="text" name="game_image">
						</div>
						<div class="_input-box">
							<img src="{{CONFIG_THEME_PATH}}/image/icon-color/admin/file.png">
							<input placeholder="Enter URL game" class="_text-input _tr5" type="text" name="game_file">
						</div>

						<div style="margin-top: 13px;background: #383e4d;padding: 7px;margin-bottom: 15px;">
							<label>
								<img src="{{CONFIG_THEME_PATH}}/image/icon-color/admin/image.png" width="20">
								<span class="_tr5">Upload image</span>
								<input style="width:100%;background:white;margin-top: 7px;margin-bottom: 10px;" type="file" name="__game_image">
							</label>
						</div>
						<div style="display:none;">
							<label>
								<img src="{{CONFIG_THEME_PATH}}/image/icon-color/admin/file.png" width="20">
								<span class="_tr5">@game_file@</span>
								<input type="file" name="__game_file">
							</label>
						</div>
						<div class="addgame_progress progress _a0">
        					<div class="addgame_bar progress-bar progress-bar-success"></div>
    					</div>

					</div>
    				<div class="_tr5 _bold">@game_size@</div>
    				<div class="_cE3-xf">
    					<div class="_cE3-x7">
    						<div class="_input-box">
    							<img src="{{CONFIG_THEME_PATH}}/image/icon-color/admin/width.png">
								<input placeholder="@game_width@" value="800" class="_text-input _tr5" type="number" name="game_width">
							</div>
						</div>
						<div class="_cE3-x7">
							<div class="_input-box">
								<img src="{{CONFIG_THEME_PATH}}/image/icon-color/admin/height.png">
								<input placeholder="@game_height@" value="600" class="_text-input _tr5" type="number" name="game_height">
							</div>
						</div>
					</div>
					<div class="_tr5 _bold" style="padding-top:5px;">Featured Games - Sorting on Homepage</div>
    				<div class="_cE3-xf">
    					<div class="_cE3-x7" style="flex:1">
    						<div class="_input-box">
    							<img src="{{CONFIG_THEME_PATH}}/image/icon-color/admin/crown.png" width="20">
    							<input type="number" class="_text-input _tr5" name="game_sorting" placeholder="">
    						</div>
						</div>
					</div>
    				<div style="display:none;">
    					<img src="{{CONFIG_THEME_PATH}}/image/icon-color/admin/file_type.png" width="20">
    					<select name="game_file_type" class="_p4s8">
							<option value="other">@game_type_html@</option>
						</select>
    				</div>
				</div>
				<input type="hidden" class="game_published--val" name="game_published" value="1">
				<input type="hidden" class="game_featured--val" name="game_featured" value="0">
				<input type="hidden" class="game_type-import--val" name="game_import" value="1">
			</div>
		</div>
		<div class="_a-r _5e4">
			<label class="_p4s8 lb-cstm"><input type="checkbox" id="_-f" class="game_state-E s-t-F">Set @game_featured@</label>
			<button type="submit" id="addgame-btn" class="btn-p btn-p1">
				<i class="fa fa-plus icon-18 icon-middle"></i>
				@game_add@
			</button>
		</div>
	</form>
</div>