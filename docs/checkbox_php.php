<?php

$items = [
	"a" => "Item A",
	"b" => "Item B",
	"c" => "Item C"
];

//var_dump($_POST);
var_dump(file_get_contents('php://input'));

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Formulaire item</title>
</head>
<body>
	
	<?php if(isset($_POST["items"]) && sizeof($_POST["items"]) > 0): ?>
	<fieldset>
		<legend>Your selected items</legend>

		<?php foreach($_POST["items"] as $key): ?>

			<li><?= $items[$key] ?></li>	
		
		<?php endforeach; ?>
	
	</fieldset>
	<?php endif; ?>
	<form action="" method="post">
		<ul>
		
		<?php foreach($items as $key => $text): 
			$checked = isset($_POST["items"]) && array_search($key, $_POST["items"]) !== false;
		?>
				
			<li><input type="checkbox" name="items[]" value="<?= $key ?>" <?= $checked ?"checked='checked'" : "" ?>/> <?= $text ?></li>	
		
		<?php endforeach; ?>
		
		</ul>
		<p>
			<button type="submit">Send!</button>
		</p>
	</form>
</body>
</html>