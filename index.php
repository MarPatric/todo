<?php

	require_once 'core/init.php';

	$itemsQuery = DB::getinstance()->query("
		SELECT id, name, done
		FROM items
	",array(Session::get('user_id')));

	

	$items = $itemsQuery->count() ? $itemsQuery : [];

	

?>


<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>To do list</title>
		<link rel="stylesheet" href="css/main.css">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
	</head>

	<body>

		<div class="list">
			<h1 class="header"> To do.</h1>

			<?php if(!empty($items)): ?>
			<ul class="items">
				<?php foreach($items->results() as $item): 
					$itemDone = $item->done; 
					$itemName = $item->name;
					$itemId = $item->id;
					 ?>
				<li>
					<span class="item<?php echo $itemDone ? ' done' : ''?>"> <?php echo $itemName; ?></span>
					<a class="material-icons" href="mark.php?as=delete&item=<?php echo $itemId; ?>">delete</a>
					<?php if(!$itemDone): ?> 
						<a class="material-icons"  href="mark.php?as=done&item=<?php echo $itemId; ?>">check_box_outline_blank</a>
					<?php else: ?>
						<a class="material-icons" href="mark.php?as=undone&item=<?php echo $itemId; ?>">check_box</a>						
					<?php endif; ?>
				</li>
				<?php endforeach; ?>
			</ul>
			<?php else: ?>
				<p>You haven't added any items yet.</p>
			<?php endif; ?>

			<form class="item-add" action="add.php" method="POST">
				<input type="text" name="name" placeholder="Type a new item here." class="input" autocomplete="off" maxlength="30" required>
				<input type="submit" value="Add" class="submit">
			</form>

		</div>

	</body>


		
</html>