<div class="general-box _0e4">
	<div class="header-box">
		<i class="fa fa-pencil color-w icon-middle"></i>
	</div>
	<div class="_5e4">
		<form id="editcategory-form" enctype="multipart/form-data" method="POST">
			<div class="vByg5">
				<input type="text" name="ec_name" value="{{EDIT_CATEGORY_NAME}}">
				<input type="hidden" name="ec_id" value="{{EDIT_CATEGORY_ID}}">
			</div>
			<div style="display:block;" id="game_import1" class="game_import-filepanel r-r3 _10e4 _a0">
				<div>
					<label>
						<img src="{{CONFIG_THEME_PATH}}/image/icon-color/admin/image.png" width="20">
						<span class="_tr5">Category image (optional)</span>
						<input type="file" name="__game_image">
					</label>
				</div>
				<div class="addcategory_progress progress _a0">
					<div class="addcategory_bar progress-bar progress-bar-success"></div>
				</div>
			</div>
			<div class="" style="margin-top: 10px;">
				<label for="">Footer Description</label>
				<textarea name="ec_footer_description" placeholder="footer description" rows="15" style="min-height: 339px;" class="editor-js _text-input _tr5 tinymce">
				{{EDIT_CATEGORY_FOOTER_DESCRIPTION}}
				</textarea>
			</div>
			<button type="submit" class="btn-p btn-p1">
				<i class="fa fa-check icon-middle"></i>
				@save@
			</button>
			<a class="btn-default btn-sm" target="_blank" href="{{EDIT_CATEGORY_URL}}">
				<i class="fa fa-send icon-middle"></i>
				@open@
			</a>
		</form>
	</div>
</div>