
<!DOCTYPE html>
<html>
<head>
	<title>Add Student</title>
	<style>
		body {
			background-color: #FFEBEB;
			text-align: center;
		}
		form {
			display: inline-block;
			text-align: left;
            outline: 2px dashed grey;
		}
	</style>
</head>
<body>
	<h1>Add Student</h1>
	<form action="index.html" method="post">
		<label for="studentID">Student ID:</label>
		<input type="text" name="studentID" id="studentID"><br>
		<label for="firstName">First Name:</label>
		<input type="text" name="firstName" id="firstName"><br>
		<label for="lastName">Last Name:</label>
		<input type="text" name="lastName" id="lastName"><br>
		<label for="year">Year:</label>
		<input type="number" name="year" id="year"><br>
		<input type="submit" value="Add Student">
	</form>
</body>
</html>




<?php
// Connect to the database
require("connect-db.php");


// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	// Get the form data
	$studentID = $_POST["studentID"];
	$firstName = $_POST["firstName"];
	$lastName = $_POST["lastName"];
	$year = $_POST["year"];

	// Check if the studentID is already in the database
	$sql = "SELECT studentID FROM student WHERE studentID = '$studentID'";
	$result = $db->query($sql);

	if ($result->rowCount() > 0) {
		// Display an error message if the studentID is already in the database
		echo "Error: Student ID already exists in the database";
	} else {
		// Insert the new student into the database
		$sql = "INSERT INTO student (studentID, firstName, lastName, year) VALUES ('$studentID', '$firstName', '$lastName', '$year')";
		$db->query($sql);

		// Redirect the user to index.html if the insertion was successful
		header("Location: index.html");
		exit();
	}
}

?>
