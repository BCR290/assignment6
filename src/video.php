<?php
	include("config.php");
	$dbc = getdbc();
	// this is an array of the genres that can be chosen, when the user selects a genre the selector returns a number
	// This is silly
	#remove all 
	if ($_GET["action"] == "removeAll") {
		// Delete all the rows in a table
		$query = "DELETE FROM videos WHERE 1";
		mysqli_query($dbc, $query);
	}
	
	#rent and return
	if ($_GET["action"] == "rent") {
		if (isset($_POST["rent"])) {
			$id = $_POST["rent"];
			$query = "UPDATE videos 
					  SET rented = 1
					  WHERE id = $id";
			mysqli_query($dbc, $query);
		} else if(isset($_POST["return"])) {
			$id = $_POST["return"];
			$query = "UPDATE videos 
					  SET rented = 0
					  WHERE id = $id";
			mysqli_query($dbc, $query); 
		}
	}
	
	#add a movie
	if ($_GET["action"] == "addmovie") {
		if(!isset($_POST["Title"])) {
			echo "unable to add movie";
		} else {
			$title = $_POST["Title"];
			$genre = $_POST["Genre"];
			$length = $_POST["Length"];
			$query = "INSERT INTO videos (name, category, length) 
				      VALUES ('$title', '$genre', '$length')";
			$add = mysqli_query($dbc, $query);
		}
		// add a row to the table
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Horizontal Video</title>
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>

	<body>
		<!-- removing all movies from Database -->
		<form name="Remove" action="video.php?action=removeAll" method="POST">
			DANGER:<input type="submit" value="Remove All">
		</form>

		<!-- select a genre to show. -->
		<fieldset>
			<legend>Filter Movies</legend>
			<form action="video.php?action=selectGenre" method="POST">
				<select name="Genre">
					<option value="none">none</option>
					<option value="action">Action</option>
					<option value="adventure">Adventure</option>
					<option value="comedy">Comedy</option>
					<option value="crime">Crime</option>
					<option value="fantasy">Fantasy</option>
					<option value="historical">Historical</option>
					<option value="horror">Horror</option>
					<option value="mystery">Mystery</option>
					<option value="political">Political</option>
					<option value="romance">Romance</option>
					<option value="saga">Saga</option>
					<option value="satire">Satire</option>
					<option value="science">Science</option>
					<option value="thriller">Thriller</option>
					<option value="urban">Urban</option>
					<option value="other">other</option>
				</select>
				<input type="submit" value="Show Genre">
			</form>
		</fieldset>

		<!-- Displaying movies -->
<?php
		$genre;
		$movies = "SELECT * FROM videos";
		if($_GET["action"] == "selectGenre") {
			if (isset($_POST['Genre']) && $_POST["Genre"] != "none") {
				$genre = $_POST["Genre"];
				$movies = "SELECT * FROM videos WHERE category = '$genre'";
			}
		}
?> 
		<fieldset>
			<legend>Movies: <?=$genre?></legend>
<?php		
			# request all the movies from the server and print them out in a loop
			$result = mysqli_query($dbc, $movies) or die("you fucked up");
			while ($row = mysqli_fetch_array($result)) {
				?>
				<div class="movie">
					<span>title: </span><span><?=$row['name']?></span><br>
					<span>genere: </span><span><?=$row['category']?></span><span>length: </span><span><?=$row['length']?></span>
					<form method="POST" action="video.php?action=rent">
						<span>Currently Avaliable:</span>
						<?php 
							if ($row['rented'] == 1) {
								?>
									<button name="return" value="<?php echo htmlspecialchars($row['id']); ?>">return</button>
								<?php
							} else {
								?>
									<button name="rent" value="<?php echo htmlspecialchars($row['id']); ?>">rent</button>
								<?php
							}
						?>
					</form>
				</div>
				<?php
			}
?>		
		</fieldset>

		<!-- adding a movie -->
		<fieldset>
			<legend>Add a movie</legend>
			<form action = "video.php?action=addmovie" method = "POST">		
				Title:<input type = "text" name = "Title"><br>
				Video Length(min):<input type="number" name="Length" min = "0" max ="600"><br>
				Choose a Genre:
				<select name="Genre">
					<option value="action">Action</option>
					<option value="adventure">Adventure</option>
					<option value="comedy">Comedy</option>
					<option value="crime">Crime</option>
					<option value="fantasy">Fantasy</option>
					<option value="historical">Historical</option>
					<option value="horror">Horror</option>
					<option value="mystery">Mystery</option>
					<option value="political">Political</option>
					<option value="romance">Romance</option>
					<option value="saga">Saga</option>
					<option value="satire">Satire</option>
					<option value="science">Science</option>
					<option value="thriller">Thriller</option>
					<option value="urban">Urban</option>
					<option value="other">other</option>
				</select>
				<input type="submit" value="Add Movie">
			</form>
		</fieldset>

	</body>
</html>
