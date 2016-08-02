<?php

require_once('src/autoload.php');
require_once('config.php');

VkApi::configure($config);

$bot = new Bot();
$bot->start();
