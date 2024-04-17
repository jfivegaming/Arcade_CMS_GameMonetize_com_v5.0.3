	<div class="gamemonetize-setting _a-r">
		<form class="avatar-form" method="post" enctype="multipart/form-data">
			<div class="avatar-header">
                <span class="_content-title">
                    @avatar@
                </span>  
            </div>
			<div class="_13n5 gamemonetize-box-load">
				<img class="gamemonetize-loader" src="{{CONFIG_SITE_URL}}/static/libs/images/ajax-spinner.svg">
				<img class="gamemonetize-avatar" src="{{SETTING_USER_AVATAR}}">
            </div>
			<input class="avatar-upload-door" type="file" name="image">
			<input name="user_id" value="{{USER_ID}}" type="hidden">
			<button type="submit" id="avatar-btn" class="btn-p btn-p1">
                <i class="fa fa-check icon-middle"></i> 
               	@save_image@
            </button>
		</form>
	</div>