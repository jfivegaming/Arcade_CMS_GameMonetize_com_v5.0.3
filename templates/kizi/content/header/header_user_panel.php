				<div class="header-user">
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