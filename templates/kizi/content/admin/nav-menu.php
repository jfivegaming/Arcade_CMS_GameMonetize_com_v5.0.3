				<div class="header-user" style="position:absolute;right:19px;top:10px;">
					<a href="#" class="overlay-toggle" data-target="#userDropdown">
						<img class="img-circle header-user-image" src="{{HEADER_USER_AVATAR}}" width="35">
					</a>
				</div>
				<div class="overlay-wrapper" id="userDropdown" data-status="closed">
					<nav class="overlay" data-direction="right">
						<div class="subnav">
							<div class="nav-wrapper">
								<a href="#" class="overlay-toggle" data-target="#userDropdown">
									<i class="fa fa-close overlay-close"></i>
								</a>
								<div class="user-overlay-header {{USER_PROFILE_THEME}}">
									<img class="img-circle overlay-user-picture" src="{{HEADER_USER_AVATAR}}">
									<ul class="user-overlay-caption">
										<li>
											<span class="oui-txt-name">
												{{USER_USERNAME}}
											</span>
										</li>
									</ul>
								</div>
								<ul class="overlay-user-menu">
									<li>
										<a class="spf-link" href="{{CONFIG_SITE_URL}}/setting">
										<i class="fa fa-wrench icon-middle"></i>
										@settings@
										</a>
									</li>
									{{HEADER_PANEL_MENU_ADMIN}}
									<li>
										<a href="{{CONFIG_SITE_URL}}/logout/{{CSRF_LOGOUT_TOKEN}}">
										<i class="fa fa-sign-out icon-middle"></i>
										@logout@
										</a>
									</li>
								</ul>
								{{FOOTER_CONTENT}}
								<div>
							</div>
						</div>
					</nav>
				</div>

				<ul>
	<li class="_4lf {{NAV_MENU_GLOBAL}}">
		<a href="{{CONFIG_SITE_URL}}/admin" class="spf-link _p"></a>
		<i class="fa fa-globe nav-icon icon-middle"></i> @menu_global@
	</li>
	<li class="_4lf {{NAV_MENU_GAMES}}">
		<a href="{{CONFIG_SITE_URL}}/admin/games" class="spf-link _p"></a>
		<i class="fa fa-gamepad nav-icon icon-middle"></i> @menu_games@
	</li>
	<li class="_4lf {{NAV_MENU_ADDGAME}}">
		<a href="{{CONFIG_SITE_URL}}/admin/addgame" class="spf-link _p"></a>
		<i class="fa fa-plus nav-icon icon-middle"></i> @menu_addgame@
	</li>
	<li class="_4lf {{NAV_MENU_CATEGORIES}}">
		<a href="{{CONFIG_SITE_URL}}/admin/categories" class="spf-link _p"></a>
		<i class="fa fa-bookmark nav-icon icon-middle"></i> @menu_categories@
	</li>
	<li class="_4lf {{NAV_MENU_TAGS}}">
		<a href="{{CONFIG_SITE_URL}}/admin/tags" class="spf-link _p"></a>
		<i class="fa fa-bookmark nav-icon icon-middle"></i> @menu_tags@
	</li>
	<li class="_4lf {{NAV_MENU_FOOTER_DESCRIPTION}}">
		<a href="{{CONFIG_SITE_URL}}/admin/footerdescription" class="spf-link _p"></a>
		<i class="fa fa-bookmark nav-icon icon-middle"></i> @menu_footer_description@
	</li>
	<li class="_4lf {{NAV_MENU_BLOGS}}">
		<a href="{{CONFIG_SITE_URL}}/admin/blogs" class="spf-link _p"></a>
		<i class="fa fa-bookmark nav-icon icon-middle"></i> @menu_blogs@
	</li>
	<li class="_4lf">
		<a href="{{CONFIG_SITE_URL}}" target="_blank" class="spf-link _p"></a>
		<i class="fa fa-gamepad nav-icon icon-middle"></i> Visit Website
	</li>
	<li class="_4lf">
		<a href="https://gamemonetize.com/games" target="_blank" class="spf-link _p"></a>
		<i class="fa fa-globe nav-icon icon-middle"></i> Games Catalog
	</li>
	<li class="_4lf {{NAV_MENU_SETTING}}">
		<a href="{{CONFIG_SITE_URL}}/admin/setting" class="spf-link _p"></a>
		<i class="fa fa-cog nav-icon icon-middle"></i> @menu_setting@
	</li>
	<li class="_4lf {{NAV_MENU_ADS}}">
		<a href="{{CONFIG_SITE_URL}}/admin/ads" class="spf-link _p"></a>
		<i class="fa fa-flag-o nav-icon icon-middle"></i> @menu_ads@
	</li>
	<li class="_4lf">
		<a href="{{CONFIG_SITE_URL}}/logout/{{CSRF_LOGOUT_TOKEN}}" class="spf-link _p"></a>
		<i class="fa fa-sign-out nav-icon icon-middle"></i>@logout@
	</li>
</ul>