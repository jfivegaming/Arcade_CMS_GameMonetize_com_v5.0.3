<div class="general-box _0e4">
	<form id="edituser-form" type="POST">
		<div class="_top-edituser">
			<div class="_a-c _top-userpic">
				<img class="img-circle" src="{{USER_PROFILE_AVATAR}}" width="100" height="100">
			</div>
		</div>
		<div class="_5e4">
			<span class="_f12 color-grey">@user@</span>
			<input class="b-input" name="eu_username" value="{{USER_PROFILE_USERNAME}}">

			<span class="_f12 color-grey">@name@</span>
			<input class="b-input" name="eu_name" value="{{USER_PROFILE_NAME}}">

			<span class="_f12 color-grey">@ip_address@</span>
			<input class="b-input" value="{{USER_PROFILE_IP}}" disabled>

			<div>
				<span class="_f12 color-grey">@user_rank@</span>
				<select class="_p4s8 _yb5" name="eu_admin">
					<option value="0" {{USER_PROFILE_RANK_STATUS_0}}>@status_user@</option>
					<option value="1" {{USER_PROFILE_RANK_STATUS_1}}>@status_admin@</option>
				</select>
			</div>

			<span class="_f12 color-grey">@email@</span>
			<input class="b-input" name="eu_email" value="{{USER_PROFILE_EMAIL}}">

			<span class="_f12 color-grey">@xp_points@</span>
			<input class="b-input" name="eu_xp" type="number" value="{{USER_PROFILE_XP}}">

			<div>
				<span class="_f12 color-grey">@lang@</span>
				<select class="_p4s8 _yb5" name="eu_lang">
					{{USER_PROFILE_LANGUAGE_OPTION}}
				</select>
			</div>

			<span class="_f12 color-grey">@user_about@</span>
			<div><textarea class="b-input" name="eu_about">{{USER_PROFILE_ABOUT}}</textarea></div>
			
			<div>
				<span class="_f12 color-grey">@user_gender@</span>
				<select class="_p4s8 _yb5" name="eu_gender">
					<option value="1" {{USER_PROFILE_GENDER_STATUS_1}}>@male@</option>
					<option value="2" {{USER_PROFILE_GENDER_STATUS_2}}>@female@</option>
				</select>
			</div>

			<div>
				<label>
					<input type="checkbox" name="eu_active" {{USER_PROFILE_ACTIVE_STATUS}}>
					@user_active@
				</label>
			</div>

			<input name="eu_id" type="hidden" value="{{USER_PROFILE_ID}}">
			
			<div class="_a-r">
				<button type="submit" class="btn-p btn-p1">
					<i class="fa fa-check icon-middle"></i>
					@save@
				</button>
			</div>
		</div>
	</form>
</div>