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