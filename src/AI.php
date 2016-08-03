<?php

class AI
{
	public static function getAction($text, $user, $chat)
	{
		$result = null;
		$rules = Db::getInstance()->rows("SELECT * FROM rules");

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

			if ($matches) $result = $rule['message_out'];
		}

		return $result;
	}
}
