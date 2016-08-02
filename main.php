<?php

require_once('src/autoload.php');
require_once('config.php');

$api = VkApi::configure($config);
$bot = new Bot($api);
$bot->start();
