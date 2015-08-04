
<?php
	include("config.php");
	$dbc = getdbc();

	// this is an array of the genres that can be chosen, when the user selects a genre the selector returns a number
	// This is silly

	#remove all 


	if ($_GET["action"] == "removeAll") {
		// Delete all the rows in a table
		$stmt = $dbc->prepare("DELETE FROM videos WHERE 1");
		$stmt->execute();
	}
	
	#rent and return
	if ($_GET["action"] == "rent") {
		$stmt = $dbc->prepare("UPDATE videos SET rented = ? WHERE id = ?");
		$stmt->bind_param("ii", $ren, $id);
		if (isset($_POST["rent"])) {
			$ren = 1;
			$id = $_POST["rent"];
		} else if(isset($_POST["return"])) {
			$id = $_POST["return"];
			$ren = 0;
			$id = $_POST["return"];
		}
		$stmt->execute();
	}
	
	#add a movie
	if (isset($_POST["Title"]) && $_POST["Title"] == NULL) {
		echo 'You must input a movie name! Movie not added.';
	} else if ($_GET["action"] == "addmovie") {
		if(!isset($_POST["Title"])) {
			echo "unable to add movie";
		} else {
			$stmt = $dbc->prepare("INSERT INTO videos (name, category, length) 
				      VALUES (?, ?, ?)");
			$stmt->bind_param("ssi", $title, $genre, $length);
			$title = $_POST["Title"];
			$genre = $_POST["Genre"];
			$length = $_POST["Length"];
			$stmt->execute();
		}
		// add a row to the table
	}
	#delete a movie
	if ($_GET["action"] == "delete") {
		$stmt = $dbc->prepare("DELETE FROM videos WHERE id = ?");
		$stmt->bind_param("i", $id);
		$id = $_POST["delete"];
		$stmt->execute();
	}

?>

<!DOCTYPE html>
<html>
	<head>
		<title>Horizontal Video</title>
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>

	<body>
		<h1 id="title">  Horizontal Movies </h1>

		<!-- removing all movies from Database -->
		<form name="Remove" action="video.php?action=removeAll" method="POST">
			DANGER:<input type="submit" value="Remove All">
		</form>

		<!-- select a genre to show. -->
		<fieldset>
			<legend>Filter Movies</legend>
			<form action="video.php?action=selectGenre" method="POST">
				<select name="genre">
					<option value="none">All Genres</option>
					<?php 
					$stmt = $dbc->prepare("SELECT DISTINCT category FROM videos WHERE 1");
					$stmt->execute();
					$result = $stmt->get_result();
						while($genre = $result->fetch_array(MYSQLI_ASSOC)) {
							if (isset($_POST["genre"]) && $_POST["genre"] == $genre["category"]) {
								?>
								<option value=<?php echo htmlspecialchars($genre["category"]); ?> selected="selected"><?=$genre["category"]?></option>
								<?php
							} else {
								?>
								<option value=<?php echo htmlspecialchars($genre["category"]); ?> ><?=$genre["category"]?></option>
							<?php
							}
						}
					?>
				</select>
				<input type="submit" value="Show Genre">
			</form>
		</fieldset>

		<!-- Displaying movies -->
<?php
		$genre;
		$stmt = $dbc->prepare("SELECT * FROM videos");
		if($_GET["action"] == "selectGenre") {
			if (isset($_POST['genre']) && $_POST["genre"] != "none") {
				$stmt = $dbc->prepare("SELECT * FROM videos WHERE category = ?");
				$stmt->bind_param("s", $genre);
				$genre = $_POST["genre"];
			}
		}

?> 
		<fieldset>
			<legend>Movies: <?=$genre?></legend>
<?php		
			# request all the movies from the server and print them out in a loop
			$stmt->execute();
			$result = $stmt->get_result();
			while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
				?>
				<div class="movie">
					<span>Title: </span><span><?=$row['name']?></span><br>
					<span>Genere: </span><span><?=$row['category']?></span><br>
					<span>Length: </span><span><?=$row['length']?></span>
					<form method="POST" action="video.php?action=rent">
						<span>Currently Avaliable:</span>
						<?php 
							if ($row['rented'] == 1) {
								?>
									<button name="return" value="<?php echo htmlspecialchars($row['id']); ?>">Checked Out</button>
								<?php
							} else {
								?>
									<button name="rent" value="<?php echo htmlspecialchars($row['id']); ?>">Avaliable</button>
								<?php
							}
						?>	
					</form>
					<form action="video.php?action=delete" method="POST">
						<button name="delete" value="<?php echo htmlspecialchars($row['id']); ?>">DELETE</button>
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
					<?php 
						$genres = ["none", "action", "adventure", "comedy", "crime", "fantasy", "historical", "horror", "mystery", "political", "romance", "saga", "satire", "science", "thriller", "urban", "other"];
						foreach ($genres as $genre) {
							?>	
							<option value=<?php echo htmlspecialchars($genre); ?>><?=$genre?></option>
							<?php					
						}
					?>
				</select>
				<input type="submit" value="Add Movie">
			</form>
		</fieldset>

	</body>
</html>

