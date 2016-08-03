<?php

class Bot
{
	const TIMEOUT = 3;

	private $_api;

	public function __construct()
	{
		$this->_api = Api::getInstance();
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
			if (!$message->isIncoming()) continue;

			Logger::logInfo('Got message: "' . $message->getText() . '" from "' . $message->getSenderName() .'"');
			$responseText = AI::getAction($message->getText(), $message->userId(), $message->chatId());

			if ($responseText) {
				Logger::logInfo('Sent: ' . $responseText);

				try {
					$this->_api->sendMessage($message->respondToMessage($responseText));
				} catch (\Exception $e) {
					Logger::logError($e->getMessage());
				}
			}
		}
	}
}