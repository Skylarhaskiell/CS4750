<!DOCTYPE html>
<html>
<head>
	<title>Class List</title>
	<style>
		.class-box {
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
		/* .class-list {
			margin-top: 20px;
			padding: 10px;
			border: 1px solid black;
		} */
	</style>
</head>
<body>

<?php
	// Establish a database connection
	require("connect-db.php");
	global $db;
	
	// Display the selected professor's information
	if (isset($_GET["classID"])) {
		$professorID = $_GET["classID"];
		$sql = "SELECT * FROM class WHERE classID = '$classID'";
		$result = $db->query($sql);
  

		if ($result->rowCount() > 0) {
            ($row = $result->fetch(PDO::FETCH_ASSOC));
            echo "<div class='class-box'>";
            echo "<h2>" . $row["classID"] . " " . $row["classCode"] . "</h2>";
            //need to fix line below
            echo "<p>Class Rating: " . $row["class_rating"] . "</p>";
            echo "<div class='class-list'>";
            echo "<h3>Class Comments:</h3>";
            echo "<ul>";
            $sql = "SELECT c.content
            FROM comments c
            INNER JOIN classComment cc ON c.commentID = cc.commentID
            WHERE cc.classID = '$classID' ";
            
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
	$sql = "SELECT * FROM class order by classID";
	$result = $db->query($sql);

	// Display the dropdown with the list of professors
  
	if ($result->rowCount() > 0) {
		echo "<div class='container'>";
		echo "<div class='title-box'><h2>Select a class to see its ratings</h2></div>";
		echo "<form action=''>";
		echo "<select name='classID'>";
		while($row = $result->fetch(PDO::FETCH_ASSOC)) {
			echo "<option value='" . $row["classID"] . "'>" . $row["classCode"] . " " . $row["professorID"] . "</option>";
		}
		echo "</select>";
		echo "<br><br>";
		echo "<input type='submit' value='Select'>";
		echo "</form>";
		echo "</div>";
	} else {
		echo "No classes found.";
	}
?>

</body>
</html>
