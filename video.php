<?php
echo '<form name=\"Remove\">';
echo '<input type="submit" value="Remove">';
echo '</form>';

echo '<form name="Submit">';
echo '<input type="submit" value="Submit">';
echo '</form>';

$selected = '';

function get_options($select){
	$genre = array('Action'=>1,'Adventure'=>2,'Comedy'=>3,'Crime'=>4,'Fantasy'=>5,'Historical' => 6, 'Horror' => 7, 'Mystery' => 8, 'Political' => 9, 'Romance' => 10, 'Saga' => 11, 'Satire' => 12, 'Science' => 13, 'Thriller' => 14, 'Urban' => 15);
	$option = '';
	while (list($k, $v)=each($genre)){
		if ($select == $v){
			$option.='<option value="'.$v.'" selected>'.$k.'</option>';
		}
		else{
			$option.='<option value="'.$v.'">'.$k.'</option>';
		}	
	}
	return $option;

}

if (isset($_POST['Genre'])){
	$selected = $_POST['Genre'];
	echo $selected;
}
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Video List</title>

	</head>
	<body>
	<form action = "<?php echo $_SERVER['PHP_SELF']; ?>" method = "POST">
		<select name="Genre" onchange="this.form.submit();">
		<?php echo get_options($selected); ?>
		</select>
		</form>
	</body>
</html>
