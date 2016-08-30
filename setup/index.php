<?php

require_once('../src/autoload.php');


SqliteDb::setFileLocation('../database.db');
$db = SqliteDb::getInstance();

if(isset($_POST['create'])) {
	$db->exec('INSERT INTO rules VALUES("","","","","")');
	header('Location: /');

}  elseif (isset($_POST['submit'])) {
	$db->exec('DELETE FROM rules');
	$i = 0;
	foreach ($_POST['operation'] as $item) {
		$operation = $_POST['operation'][$i];
		$message_in = $_POST['message_in'][$i];
		$message_out = $_POST['message_out'][$i];
		$users = $_POST['users'][$i];
		$chats = $_POST['chats'][$i];

		$db->exec("INSERT INTO rules VALUES ('$operation', '$message_in', '$message_out' , '$users', '$chats')");
		$i++;
	}

	header('Location: /');
} else {
	ob_start();

	$rules = $db->rows("SELECT * FROM rules");

	include 'tpl/main.phtml';
	$content = ob_get_contents();
	ob_end_clean();

	echo $content;
}
