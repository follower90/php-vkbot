<?php

spl_autoload_register(function ($class_name) {
	$fileName = $class_name . '.php';
	include $fileName;
});
