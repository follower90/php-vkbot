<?php

class Bot
{
	const TIMEOUT = 3;

	private $_api;
	private $_ai;
	private $_log;

	public function __construct(Api $api, IAI $ai, ILogger $log)
	{
		$this->_api = $api;
		$this->_ai = $ai;
		$this->_log = $log;
	}

	public function start()
	{
		$this->_log->logInfo('Bot started! Working!');

		while (true) {
			$this->work();
			sleep(self::TIMEOUT);
		}
	}

	public function work()
	{
		$messages = $this->_api->getLastUnreadMessages(self::TIMEOUT);

		foreach ($messages as $message) {

			$message = new Message($message);
			if (!$message->isIncoming()) continue;

			$sender = $message->isPrivate()
					? $this->_api->getUserName($message->getUserId())
					: $this->_api->getChatName($message->getChatId());

			$this->_log->logInfo('Got message: "' . $message->getText() . '" from "' . $sender .'"');

			$responseText = $this->_ai->getAnswer($message->getText(), $message->userId(), $message->chatId());

			if ($responseText) {
				$this->_log->logInfo('Sent: ' . $responseText);

				try {
					$this->_api->sendMessage($message->respondToMessage($responseText));
				} catch (\Exception $e) {
					$this->_log->logError($e->getMessage());
				}
			}
		}
	}
}