<?php

require_once('src/autoload.php');

class Application {

	public function run()
	{
		$pid = pcntl_fork();

		if ($pid == -1) {
			die('Fatal error');
		} else if ($pid) {
			$this->runBot();
		} else {
			$this->runWebUI();
		}
	}

	private function runWebUI()
	{
		shell_exec('cd setup && php -S localhost:1200');
	}

	private function runBot()
	{
		require_once('config.php');

		Api::configure($config);
		$bot = new Bot();
		$bot->start();
		pcntl_wait($status);
	}
}

Db::setFileLocation('database.db');
$db = Db::getInstance();

$app = new Application();
$app->run();
