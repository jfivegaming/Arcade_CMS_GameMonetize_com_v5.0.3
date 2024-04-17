	<div class="gamemonetize-setting">
		<form class="update-user-info _a-l" method="post">
			<div class="form-header _a-c">
				<span class="_content-title">
                    @general_config@
                </span> 
			</div>
            <span class="_f12 color-grey">@user_username@</span>
			<div class="gamemonetize-info-input">
				<input type="text" value="{{USER_USERNAME}}" disabled>
			</div>
            <span style="display:none;" class="_f12 color-grey">@name@</span>
			<div style="display:none;" class="gamemonetize-info-input">
				<input type="text" name="name" value="{{USER_NAME}}">
			</div>
            <span class="_f12 color-grey">@email@</span>
			<div class="gamemonetize-info-input">
				<input type="email" name="email" value="{{USER_EMAIL}}">
			</div>
            <div class="_a-r">
                <button type="submit" class="btn-p btn-p1">
                    <i class="fa fa-check icon-middle"></i>
                    @save@
                </button>
            </div>
		</form>
	</div>