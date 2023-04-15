
<?php
// Connect to the database
require("connect-db.php");
global $db;

// Check if form submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user input from form
    $firstName = $_POST["firstName"];
    $lastName = $_POST["lastName"];
    $studentID = $_POST["studentID"];
    $year = $_POST["year"];
    // Check if studentID exists in login table
$sql = "SELECT * FROM login WHERE studentID = '$studentID'";
$result = $db->query($sql);
if ($result->rowCount() == 0) {

    // Error message
    echo "Student ID not found in login table";
}
// Insert data into student table
if($result->rowCount() != 0){
$sql = "INSERT INTO student (studentID, firstName, lastName,  year)  VALUES ('$studentID','$firstName', '$lastName',  '$year)";
$db->query($sql);

    $sql = "INSERT INTO student (firstName, lastName, studentID, year) VALUES ('$firstName', '$lastName', '$studentID', $year)";
    $db->query($sql);   
    
}
// Check if insertion was successful
$sql = "SELECT * FROM student WHERE firstName = '$firstName' AND lastName = '$lastName'";
$result = $db->query($sql);

if ($result->rowCount() > 0) {
    // Success message
    echo "User created successfully!";
    header('Location: index.html');
    exit();
}
else {
    // Error message
    echo "Error creating user";
    header('Location: student_details.php');
    exit();
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
	<form method="POST" action="student_details.php">
        
		<label for="studentID">Student ID:</label>
		<input type="text" id="studentID" name="studentID" ><br><br>

		<label for="firstName">First Name:</label>
		<input type="text" id="firstName" name="firstName" required><br><br>

		<label for="lastName">Last Name:</label>
		<input type="text" id="lastName" name="lastName" required><br><br>

        <label for="year"> Academic Year</label>
		<input type="number" id="year" name="year" required><br><br>


		<input onclick="window.location.href = 'student_details.php';" type="submit" value="Submit Info">
	</form>
</body>
</html>
