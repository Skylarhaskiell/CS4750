<?php include 'header.php';
?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
	<title>Professor List</title>
	<style>
		.professor-box {
			border: 1px solid black;
			padding: 10px;
			margin-bottom: 20px;
		}
		.container {
			display: flex;
			flex-direction: column;
			align-items: center;
		}
		.title-box {
			background-color: #f28482;
			color: white;
			padding: 10px;
			margin-bottom: 20px;
		}
		.class-list {
			margin-top: 20px;
			padding: 10px;
			border: 1px solid black;
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
            echo "<div class='class-list'>";
            echo "<h3>Classes Taught:</h3>";
            echo "<ul>";
            // Join the class table with the professor table using professorID as the key
            $sql = "SELECT class.classID, class.classCode, class.semester, class.year, professor.professorID
            FROM class
            JOIN professor ON professor.professorID = class.professorID
            WHERE CONCAT(professor.firstName, ' ', professor.lastName) = '$row[professorID]'";
            
			 $result = $db->query($sql);
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                echo "<li>" . $row["classCode"] . " - " . $row["semester"] . " " . $row["year"] . "</li>";
            }
			echo "</ul>";
			echo "</div>";
			echo "</div>";
		} else {
			echo "Professor not found.";
		}
	}

	// Query the database for all professors
	$sql = "SELECT * FROM professor order by lastName";
	$result = $db->query($sql);

	// Display the dropdown with the list of professors
	if ($result->rowCount() > 0) {
		echo "<div class='container'>";
		echo "<div class='title-box'><h2>Select a professor to see their ratings</h2></div>";
		echo "<form action=''>";
		echo "<select name='professorID'>";
		while($row = $result->fetch(PDO::FETCH_ASSOC)) {
			echo "<option value='" . $row["professorID"] . "'>" . $row["firstName"] . " " . $row["lastName"] . "</option>";
		}
		echo "</select>";
		echo "<br><br>";
		echo "<input type='submit' value='Select'>";
		echo "</form>";
		echo "</div>";
	} else {
		echo "No professors found.";
	}
?>

</body>
</html>


