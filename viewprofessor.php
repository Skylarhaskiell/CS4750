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
<?php include 'header.php';
?>
<?php
    // Establish a database connection
    require("connect-db.php");
    global $db;
   
    if (isset($_POST['search'])) {
        $search = $_POST['search'];
        // Search for professors whose first or last name matches the search query
        $sql = "SELECT * FROM professor WHERE CONCAT(firstName, ' ', lastName) LIKE '%$search%' OR CONCAT(lastName, ' ', firstName) LIKE '%$search%' ORDER BY lastName";
        $result = $db->query($sql);


        if ($result->rowCount() > 0) {
            ($row = $result->fetch(PDO::FETCH_ASSOC));
            echo "<div class='professor-box'>";
            echo "<h2>" . $row["firstName"] . " " . $row["lastName"] . "</h2>";


			global $db;
			$query1 = "SELECT avg(overall_rating) as RATE, avg(hours_assignment_per_week) as WEEKLY from rating natural join rankAbout natural join class where professorID = '$row[professorID]'";
			$statement1 = $db->prepare($query1);
			$statement1->execute();
			$rating = $statement1->fetch();
			$statement1->closeCursor();

			if ($rating[0] > 0) {
				$prof_rating = $rating[0];
			}
			else{
				$prof_rating = "No Ratings Yet";
			}

			if ($rating[1] > 0) {
				$weekly_hours = $rating[1];
			}
			else{
				$weekly_hours = "No Ratings Yet";
			}


            echo "Instructor Rating: ";
			echo $prof_rating;
			echo "<br> <br> Average Hours Spent on Assignments Weekly: ";
			echo $weekly_hours;
            echo "<div class='class-list'>";
            echo "<h3>Classes Taught:</h3>";
            echo "<ul>";
            // Join the class table with the professor table using professorID as the key
            
			//  while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
				// Join the class table with the professor table using professorID as the key
				$sql = "SELECT * FROM class WHERE professorID = '$row[professorID]'";
				$class_result = $db->query($sql);
				echo "<ul>";
				while ($class_row = $class_result->fetch(PDO::FETCH_ASSOC)) {
					echo "<li>" . $class_row["classCode"] . " - " . $class_row["semester"] . " " . $class_row["year"] . "</li>";
				}
				echo "</ul>";
			// }
			


            echo "</ul>";
            echo "</div>";
            echo "</div>";
        } else {
            echo "Professor not found.";
        }
    }


    // Query the database for all professors
    // $sql = "SELECT * FROM professor order by lastName";
    // $result = $db->query($sql);


    // // Display the dropdown with the list of professors
    // if ($result->rowCount() > 0) {
        echo "<div class='container'>";
        echo "<div class='title-box'><h2>Search for a professor to see their ratings</h2></div>";
        echo "<form action='' method='post'>";
        echo "<input type='text' name='search' placeholder='Search by name'>";
        echo "<input type='submit' value='Search'>";
        echo "</form>";
       
        echo "</div>";
       
?>
<?php
// Establish a database connection
require("connect-db.php");
global $db;


// Get the professorID parameter from the URL
if (isset($_GET["professorID"])) {
    $professorID = $_GET["professorID"];
   
    // Query the database for the professor's reviews
    $sql = "SELECT * FROM review WHERE professorID = '$professorID'";
    $result = $db->query($sql);


    if ($result->rowCount() > 0) {
        // Set the headers for the CSV file
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=reviews.csv');


        // Create a file pointer connected to the output stream
        $output = fopen('php://output', 'w');


        // Write the headers to the CSV file
        fputcsv($output, array('Review ID', 'Rating', 'Comment'));


        // Loop through the results and write them to the CSV file
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            fputcsv($output, array($row["reviewID"], $row["rating"], $row["comment"]));
        }
       
        // Close the file pointer
        fclose($output);
    } else {
        echo "No reviews found.";
    }
}
?>




</body>
</html>

