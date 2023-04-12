<?php

// Connect to the database


require("connect-db.php");
global $db;
// $sth = $db->query($query);
// Check if form submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user input from form
    $username = $_POST["username"];
    $password = $_POST["password"];
    $studentID = $_POST["studentID"];

    // // use this code to auto increment
    // $sql = "SELECT MAX(studentID) as max_id FROM login";
    // $result = $db->query($sql);
    // $row = $result->fetch(PDO::FETCH_ASSOC);
    // $studentID = $row["max_id"] + 1;

    // Insert new user into database
    $sql = "INSERT INTO login (studentID, username, userPassword) VALUES ('$studentID', '$username', '$password')";
    if ($db->query($sql) === TRUE) {
        // Success message
        echo "User created successfully!";
    } 
    else {
        // Error message
        echo "Error creating user";
    }
}


?>
<!DOCTYPE html>
<html>
<head>
	<title>Create User</title>
</head>
<body>
	<h2>Create User</h2>
	<form method="post" action="create_user.php">
		<label for="username">Username:</label>
		<input type="text" id="username" name="username" required><br><br>

		<label for="password">Password:</label>
		<input type="text" id="password" name="password" required><br><br>

        
		<label for="studentID">Student ID:</label>
		<input type="text" id="studentID" name="studentID" ><br><br>

		<input type="submit" value="Create User">
	</form>
</body>
</html>

