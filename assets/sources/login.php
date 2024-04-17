<?php
	if ( !is_logged() ) {
		$themeData['is_redirect_login'] = (isset($_GET['redirect_url']) && !empty($_GET['redirect_url'])) ? '<input name="redirect_url" value="'.$_GET['redirect_url'].'" type="hidden">' : '';

		$themeData['page_content'] = \GameMonetize\UI::view('welcome/login');
	}
	else {
		$actual_link = "//". $_SERVER['SERVER_NAME'] . "/admin";
		header('Location: '.$actual_link);
		die();
	}