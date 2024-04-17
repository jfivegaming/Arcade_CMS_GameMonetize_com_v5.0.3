<?php

	if ( is_logged() ) 
	{
		if(isset($_GET['token']) && !empty($_GET['token'])) 
		{
			if(\GameMonetize\CSRF::get($_GET['token']))
			{
				/* Delete cookies */
				setcookie('gm_ac_u', 0, time()-60, '/');
				setcookie('gm_ac_p', 0, time()-60, '/');

				/* Remove token session */
				\GameMonetize\CSRF::delete($_GET['token']);

				/* Redirect to home */
				header("Location: ".siteUrl());
			} else 
			{
				header("Location: ".siteUrl()."/error");
			}
		} else 
		{
			header("Location: ".siteUrl()."/error");
		}
	} else 
	{
		header("Location: ".siteUrl()."/error");
	}