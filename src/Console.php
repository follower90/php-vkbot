<?php

class Console implements ILogger
{
	public function logInfo($str)
	{
		echo $str . PHP_EOL;
	}

	public function logError($str)
	{
		echo '[ERROR]: ' . $str . PHP_EOL;
	}
}
