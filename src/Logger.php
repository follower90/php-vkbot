<?php

class Logger
{
	public static function logInfo($str)
	{
		echo $str . PHP_EOL;
	}

	public static function logError($str)
	{
		echo '[ERROR]: ' . $str . PHP_EOL;
	}
}
