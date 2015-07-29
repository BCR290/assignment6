
<?php
	include("config.php");
	$dbc = getdbc();

?>

<!DOCTYPE html>
<html>
	<head>
		<title>Horizontal Video</title>
	</head>

	<body>
	<!-- rogers forms -->
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
	<form action = "<?php echo $_SERVER['PHP_SELF']; ?>" method = "POST">
		<select name="Genre" onchange="this.form.submit();">
		<?php echo get_options($selected); ?>
		</select>
		</form>
		<form>
		Title:<br>
		<input type="text" title="Title">
		<br>

		Length:<br>
		<input type="text" length="Length">
	</form>
	<?php
		# request all the movies from the server and print them out in a loop
		$movies = "SELECT * FROM videos";
		$result = new mysqli_query($dbc, $movies);
		while ($row = mysqli_fetch_array($result)) {
			?>
			<div class="movie">
				<span>title: </span><span><?=$row[name]?></span><br>
				<span>genere: </span><span><?=$row[category]?></span><span>length: </span><span><?=$row[length]?></span>
				<form method="POST" action="logic.php">
					<span>Currently Avaliable:</span>
					<?php 
						if ($row[rented] == 1) {
							?>
								<button name="return" value="<?=$row[id]?>">return</button>
							<?php
						} else {
							?>
								<button name="rent" value="<?=$row[id]?>">rent</button>
							<?php
						}
					?>
				</form>
			</div>
			<?php
		}
	?>

	<!-- brads forms -->
	
	</body>
</html>

