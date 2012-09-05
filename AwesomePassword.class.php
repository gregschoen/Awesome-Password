<?php

class AwesomePassword
{
	static $config;

	static function hash($password)
	{
		$settings = '$6$rounds=' . self::config()->rounds . '$';
		$password = self::pepper($password);
		$hash = crypt($password, $settings . self::salt() . '$');
		$light_hash = str_replace($settings,'',$hash);
		return $light_hash;
	}

	static function check($password, $light_hash)
	{
		$hash = '$6$rounds=' . self::config()->rounds . '$' . $light_hash;
		$password = self::pepper($password);
		return crypt($password, $hash) == $hash;
	}

	static function pepper($password)
	{
		return self::config()->pre_pepper . $password . self::config()->post_pepper;
	}

	static function salt()
	{
		return substr(base64_encode(self::uuid()),0,16);
	}

	static function config()
	{
		if(!self::$config)
		{
			if(file_exists("config.json"))
			{
				self::$config = json_decode(file_get_contents("config.json"));
			}
			else
			{
				echo "Saving unique hashing values to config.json\n";
				self::$config = (object) array(
					"pre_pepper" => self::uuid(),
					"post_pepper" => self::uuid(),
					"rounds" => mt_rand(120000,140000)
				);
				file_put_contents("config.json",json_encode(self::$config));
			}
		}

		return self::$config;
	}

	static function uuid()
	{
		// http://www.php.net/manual/en/function.uniqid.php#94959
		return sprintf("%04x%04x%04x%04x%04x%04x%04x%04x",
			mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff),
			mt_rand(0, 0x0fff) | 0x4000, mt_rand(0, 0x3fff) | 0x8000,
			mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
		);
	}
}
