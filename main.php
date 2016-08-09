<?php

require_once('src/autoload.php');
SqliteDb::setFileLocation('database.db');

class Application
{

	public function run()
	{
		require_once('config.php');

		Api::configure($config);
		$db = SqliteDb::getInstance();

		$ai = new AI($db);
		$api = Api::getInstance();
		$logger = new Console();

		$bot = new Bot($api, $ai, $logger);
		$bot->start();
	}
}

$app = new Application();
$app->run();
