<div class="general-box _0e4">
	<div class="header-box">
		<i class="fa fa-pencil color-w icon-middle"></i>
	</div>
	<div class="_5e4">
		<form id="edittags-form" enctype="multipart/form-data" method="POST">
			<div class="vByg5">
				<input type="text" name="ec_name" value="{{EDIT_TAGS_NAME}}">
				<input type="hidden" name="ec_id" value="{{EDIT_TAGS_ID}}">
			</div>
			<div class="" style="margin-top: 10px;">
				<label for="">Footer Description</label>
				<textarea name="ec_footer_description" placeholder="footer description" rows="15" style="min-height: 339px;" class="editor-js _text-input _tr5 tinymce">
				{{EDIT_TAGS_FOOTER_DESCRIPTION}}
				</textarea>
			</div>
			<button type="submit" class="btn-p btn-p1" onclick="tinymce.triggerSave();">
				<i class="fa fa-check icon-middle"></i>
				@save@
			</button>
			<a class="btn-default btn-sm" target="_blank" href="{{EDIT_TAGS_URL}}">
				<i class="fa fa-send icon-middle"></i>
				@open@
			</a>
		</form>
	</div>
</div>