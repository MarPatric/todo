<?php


require_once 'core/init.php';

if(Input::get('name')) {
	$name = trim($_POST['name']);
	$name = escape($name);

	$dt = new DateTime();



	if(!empty($name)) {
		$addedQuery = DB::getinstance()->insert('items',array(
			'name' => $name,
			'done' => 0,
			'created' => $dt->format('Y-m-d H:i:s')
			));

	
	}

}

header('Location: index.php');

?>