<div class="general-box _0e4">
	<div class="header-box">
		<i class="fa fa-pencil color-w icon-middle"></i>
	</div>
	<div class="_5e4">
		<form id="editfooterdescription-form" enctype="multipart/form-data" method="POST">
			<div class="vByg5">
				<div style="margin-bottom: 10px;">
					{{EDIT_FOOTER_DESCRIPTION_NAME}} page
				</div>
				<hr style="margin: 10px 0;">
				{{EDIT_FOOTER_DESCRIPTION_CONTENT}}
				<input type="hidden" name="id" value="{{EDIT_FOOTER_DESCRIPTION_ID}}">
			</div>
			{{EDIT_FOOTER_DESCRIPTION_DESCRIPTION}}
			<button type="submit" class="btn-p btn-p1" onclick="tinymce.triggerSave();">
				<i class="fa fa-check icon-middle"></i>
				@save@
			</button>
		</form>
	</div>
</div>