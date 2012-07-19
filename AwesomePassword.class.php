<?php

class AwesomePassword
{
	private static $PRE_PEPPER = "f9b63727bde54311b4e4756020135c55";
	private static $POST_PEPPER = "b8741042f290483abe5713c93a63efc0";
	private static $ROUNDS = 123456;

	static function hash($password)
	{
		$settings = '$6$rounds=' . self::$ROUNDS . '$';
		$password = self::pepper($password);
		$hash = crypt($password, $settings . self::salt() . '$');
		$light_hash = str_replace($settings,'',$hash);
		return $light_hash;
	}

	static function check($password, $light_hash)
	{
		$hash = '$6$rounds=' . self::$ROUNDS . '$' . $light_hash;
		$password = self::pepper($password);
		return crypt($password, $hash) == $hash;
	}

	static function uuid()
	{
		// http://www.php.net/manual/en/function.uniqid.php#94959
		return sprintf("%04x%04x%04x%04x%04x%04x%04x%04x",
			mt_rand(0, 0xffff), mt_rand(0, 0xffff),
			mt_rand(0, 0xffff),
			mt_rand(0, 0x0fff) | 0x4000,
			mt_rand(0, 0x3fff) | 0x8000,
			mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
		);
	}

	static function pepper($password)
	{
		return self::$PRE_PEPPER . $password . self::$POST_PEPPER;
	}

	static function salt()
	{
		return substr(base64_encode(self::uuid()),0,16);
	}
}

// $password = "password";
// $hash = AwesomePassword::hash($password);

// "ODdmNDAyYTAzOWU2$/x7uWSqyRZSPKvDEkRqO/Fc/z8ihnxeeMLhHpnxAwY6MEXMcsP11fu3.Dtm/UIYuJyi8fYvTzMVtwEvyvSJzF/";

// $check = AwesomePassword::check($password,$hash);

// if($check)
// {
// 	echo "Hash validated\n";
// }
