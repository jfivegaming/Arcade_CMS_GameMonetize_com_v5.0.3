<?php

namespace GameMonetize;

class CSRF 
{
	/**
	* Contains the hours till the token expires.
	* @var int
	*/
	private static $_time = 3;

	/**
	* Cleans the expired tokens and creates the CSRF session if it doesn't exist.
	* @return void
	*/
	function __construct() 
	{
		self::deleteExpiredTokens();
		if (!isset($_SESSION['security']['csrf'])) {
			$_SESSION['security']['csrf'] = [];
		}
	}

	/**
	* Prints the json string with all the sessions.
	* @return void
	*/
	public static function debug() 
	{
		echo json_encode($_SESSION['security']['csrf'], JSON_PRETTY_PRINT);
	}

	/**
	* Sets the time in hours till the token expires.
	* @param string $time
	* @return boolean
	*/
	public static function set_time($time) 
	{
		if (is_int($time) && is_numeric($time)) 
		{
			self::$_time = $time;
			return true;
		}
		return false;
	}

	/**
	* Removes the session if it exists and returns true or false.
	* @return boolean
	*/
	public static function delete($token) 
	{
		self::deleteExpiredTokens();
		if (self::get($token)) 
		{
			unset($_SESSION['security']['csrf'][$token]);
			return true;
		}
		return false;
	}

	/**
	* Walks through all the sessions to check if they are expired.
	* @return void
	*/
	public static function deleteExpiredTokens() 
	{
		foreach ($_SESSION['security']['csrf'] as $token => $time) 
		{
			if (time() >= $time) 
			{
				unset($_SESSION['security']['csrf'][$token]);
			}
		}
	}

	/**
	* Creates the session token.
	* @return string
	*/
	public static function set($time = true, $multiplier = 3600, $len = 100) 
	{

		if (function_exists('openssl_random_pseudo_bytes')) 
		{
			$key = substr(bin2hex( openssl_random_pseudo_bytes($len) . uniqid() ), 0, $len);
		} else 
		{
			$key = substr(sha1( mt_rand() . uniqid() ), 0, $len);
		}

		$value = ( time() + ( ($time ? self::$_time : $time) * $multiplier ) );

		$_SESSION['security']['csrf'][$key] = $value;

		return $key;
	}

	/**
	* Checks if a session exists and returns true or false.
	* @return boolean
	*/
	public static function get($token) 
	{
		self::deleteExpiredTokens();
		return isset($_SESSION['security']['csrf'][$token]);
	}

	/**
	* returns the last key in the session array.
	* @return string
	*/
	public static function last() 
	{
		return end($_SESSION['security']['csrf']);
	}
}