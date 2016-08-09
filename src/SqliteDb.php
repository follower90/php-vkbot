<?php

class SqliteDb extends SQLite3 implements IDatabase
{
	private static $_instance;
	private static $_path;

	public function __construct()
	{
		$this->open(self::$_path);
	}

	public static function setFileLocation($path = '')
	{
		if ($path) {
			self::$_path = $path;
		}
	}

	public function query($query)
	{
		return parent::query($query);
	}

	public function rows($query)
	{
		$query = $this->query($query);
		$result = [];

		while ($row = $query->fetchArray(1)) {
			$result[] = $row;
		}

		return $result;
	}

	public static function getInstance()
	{
		if (!self::$_instance) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}
}
