<!DOCTYPE html>
<html>
<head>
	<title>Professor List</title>
	<style>
		.professor-box {
			border: 1px solid black;
			padding: 10px;
			margin-bottom: 20px;
		}
	</style>
</head>
<body>

<?php
	// Establish a database connection
	require("connect-db.php");
	global $db;

	// Display the selected professor's information
	if (isset($_GET["professorID"])) {
		$professorID = $_GET["professorID"];
		$sql = "SELECT * FROM professor WHERE professorID = '$professorID'";
		$result = $db->query($sql);

		if ($result->rowCount() > 0) {
			($row = $result->fetch(PDO::FETCH_ASSOC));
			echo "<div class='professor-box'>";
			echo "<h2>" . $row["firstName"] . " " . $row["lastName"] . "</h2>";
			echo "<p>Instructor Rating: " . $row["instructor_rating"] . "</p>";
			echo "</div>";
		} else {
			echo "Professor not found.";
		}
	}

	// Query the database for all professors
	$sql = "SELECT * FROM professor";
	$result = $db->query($sql);

	// Display the list of professors
	if ($result->rowCount() > 0) {
		while($row = $result->fetch(PDO::FETCH_ASSOC)) {
			echo "<p><a href=\"?professorID=" . $row["professorID"] . "\">" . $row["firstName"] . " " . $row["lastName"] . "</a></p>";
		}
	} else {
		echo "No professors found.";
	}
?>

</body>
</html>


