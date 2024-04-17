<?php
	if ( !is_logged() ) {
		$themeData['page_content'] = \GameMonetize\UI::view('welcome/register');
	} else { 
		$themeData['page_content'] = \GameMonetize\UI::view('welcome/error');
	}