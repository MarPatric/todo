<?php

	

	require_once 'core/init.php';
	if(isset($_GET['as'], $_GET['item'])) {
		$as    = $_GET['as'];
		$item  = $_GET['item'];
	}

	switch($as) {
		case 'done':

			$doneQuery = DB::getinstance()->query("
				UPDATE items 
				SET done = 1
				WHERE id = $item
			");

			
		break;

		case 'undone':
			$undoneQuery = DB::getinstance()->query("
				UPDATE items
				SET done = 0
				WHERE id = $item
			");

		break;

		case 'delete':
			$deleteQuery = DB::getinstance()->query("
				DELETE FROM items
				WHERE id = $item
			");

		break;
	}

header('Location: index.php');

?>