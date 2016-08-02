<?php

class AI
{
	public static function getAction($text, $user, $chat)
	{
		$result = null;

		/// SWITCH THIS SHIT TO USE ANY DATABASE
		require ('rules.php');

		foreach ($rules as $rule) {
			$matches = false;
			$msg = mb_strtolower($text);

			if ($user && $rule['users'] && !in_array($user, explode(',', $rule['users']))) continue;
			if ($chat && $rule['chats'] && !in_array($chat, explode(',', $rule['chats']))) continue;

			switch ($rule['operation']) {
				case 'equals':
					if ($msg == $rule['in']) $matches = true;
					break;
				case 'contains':
					if (strpos($msg, $rule['in']) !== false) $matches = true;
					break;
			};

			if ($matches) $result = $rule['out'];
		}

		if (!$result) {
			
			if ($user) {
				$user = VkApi::getInstance()->getUserInfo($user);
				$name = $user[0]['first_name'] . ' ' . $user[0]['last_name'];
			}
			Logger::logInfo('Message: "' . $text . '" from "' . $name .'" does not match any existing rule');
		}

		return $result;
	}
}
