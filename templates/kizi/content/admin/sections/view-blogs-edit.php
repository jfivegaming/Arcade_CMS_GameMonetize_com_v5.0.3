<div class="general-box _0e4">
	<div class="header-box">
		<i class="fa fa-pencil color-w icon-middle"></i>
	</div>
	<div class="_5e4">
		<form id="editblog-form" enctype="multipart/form-data" method="POST">
			<div class="vByg5">
				<input type="text" name="title" value="{{EDIT_BLOG_TITLE}}">
				<input type="hidden" name="blog_id" value="{{EDIT_BLOG_ID}}">
			</div>
			<div style="display:block;" id="game_import1" class="game_import-filepanel r-r3 _10e4 _a0">
				<div>
					<label>
						<img src="{{CONFIG_THEME_PATH}}/image/icon-color/admin/image.png" width="20">
						<span class="_tr5">Blog image (optional)</span>
						<input type="file" name="__game_image">
					</label>
				</div>
				<div class="addblog_progress progress _a0">
					<div class="addblog_bar progress-bar progress-bar-success"></div>
				</div>
			</div>
			<div class="" style="margin-top: 10px;">
				<label for="">Post Content</label>
				<textarea name="post" placeholder="post" rows="15" style="min-height: 339px;" class="editor-js _text-input _tr5 tinymce">
				{{EDIT_BLOG_POST}}
				</textarea>
			</div>
			<button type="submit" class="btn-p btn-p1" onclick="tinymce.triggerSave();">
				<i class="fa fa-check icon-middle"></i>
				@save@
			</button>
			<a class="btn-default btn-sm" target="_blank" href="{{EDIT_BLOG_URL}}">
				<i class="fa fa-send icon-middle"></i>
				@open@
			</a>
		</form>
	</div>
</div>