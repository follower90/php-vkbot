<?php

class Bot
{
	const TIMEOUT = 3;

	private $_api;

	public function __construct(VkApi $api)
	{
		$this->_api = $api;
	}

	public function start()
	{
		Logger::logInfo('Bot started! Working!');

		while (true) {
			$this->work();
			sleep(self::TIMEOUT);
		}
	}

	public function work()
	{
		$messages = $this->_api->getLastUnreadMessages(self::TIMEOUT);
		array_shift($messages);

		Logger::logInfo('Got ' . count($messages) . ' messages...');

		foreach ($messages as $message) {
			$message = new Message($message);
			$responseText = AI::getAction($message->getText());

			if ($responseText) {
				Logger::logInfo('got message: ' . $message->getText());
				Logger::logInfo('sent: ' . $responseText);

				try {
					$this->_api->sendMessage($message->respondToMessage($responseText));
				} catch (\Exception $e) {
					Logger::logError($e->getMessage());
				}
			}
		}
	}
}