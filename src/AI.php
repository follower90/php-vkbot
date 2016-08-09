<?php

class AI implements IAI
{
	private $_db;

	public function __construct(IDatabase $db)
	{
		$this->_db = new $db();
	}

	public function getAnswer($text, $user = null, $chat = null) {
		$result = null;
		$rules = $this->_db->rows("SELECT * FROM rules");

		foreach ($rules as $rule) {
			$matches = false;
			$msg = mb_strtolower($text);

			if ($user && $rule['users'] && !in_array($user, explode(',', $rule['users']))) continue;
			if ($chat && $rule['chats'] && !in_array($chat, explode(',', $rule['chats']))) continue;

			switch ($rule['operation']) {
				case 'equals':
					if ($msg == $rule['message_in']) $matches = true;
					break;
				case 'contains':
					if (strpos($msg, $rule['message_in']) !== false) $matches = true;
					break;
			};

			if ($matches) {
				$result = $this->processResultMessage($msg, $rule['message_out']);
			}
		}

		return $result;
	}

	private static function processResultMessage($incomingMessage, $messageRule)
	{
		$items = explode('|', $messageRule);
		return $items[mt_rand(0, count($items) - 1)];
	}
}
