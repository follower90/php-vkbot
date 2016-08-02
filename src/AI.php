<?php

class AI
{
	private static $_rules = [
		['equals', 'привет', 'здаров'],
		['equals', 'чо?', 'через плечо'],
		['equals', 'чо', 'через плечо'],
		['contains', 'азаза', ')000)))']
	];

	public static function getAction($text)
	{
		$result = null;

		foreach (self::$_rules as $rule) {
			$matches = false;
			$msg = mb_strtolower($text);

			switch ($rule[0]) {
				case 'equals':
					if ($msg == $rule[1]) $matches = true;
					break;
				case 'contains':
					if (strpos($msg, $rule[1]) !== false) $matches = true;
					break;
			};

			if ($matches) $result = $rule[2];
		}

		return $result;
	}
}
