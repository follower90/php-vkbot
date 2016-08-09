<?php

interface ILogger {
	public function logError($error);
	public function logInfo($message);
}