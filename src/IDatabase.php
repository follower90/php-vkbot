<?php

interface IDatabase {
	public static function getInstance();
	public function rows($query);
	public function query($query);
}