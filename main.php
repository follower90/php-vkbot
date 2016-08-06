<?php

require_once('src/autoload.php');
Db::setFileLocation('database.db');

class Application
{

	public function run()
	{
		require_once('config.php');

		Api::configure($config);
		$bot = new Bot();
		$bot->start();
		pcntl_wait($status);
	}
}

$app = new Application();
$app->run();
