<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <title>Professor List</title>
    <style>
        .parent {
            display:flex;

        }
        .professor-box {
            display: inline-block; 
            width: 48%; 
            vertical-align: middle; 
            padding: 50px; 
            text-align:center;
            border-radius: 10px;
            border-color: #f5cac3;
            border-width: 5px;
            border-style: solid;
            margin-top: 10px;
            margin-left: 10px;
            margin-right: 10px;
            margin-bottom: 10px;
            justify-content: center;
        }
        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            
        }
        .title-box {
            background-color: #f28482;
            color: white;
            padding: 40px;
            margin-bottom: 20px;
            display: inline-block; 
            vertical-align: top; 
            display: inline-block; 
            vertical-align: top; 
            width: 120%; 
            display: inline-block; 
            vertical-align: top; 
            padding: 30 px; 
            text-align:center;
            border-radius: 10px;
            border-color: #f7ede2;
            border-width: 5px;
            border-style: solid;
            margin-top: 10px;
            margin-left: 10px;
            margin-right: 10px;
            margin-bottom: 10px;
            }
        .class-list {
            margin-top: 50px;
            padding: 10px;
            vertical-align: center; 
            padding: 30px; 
            border-radius: 10px;
            border-color: #f7ede2;
            border-width: 5px;
            border-style: solid;
            background-color: white;
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
            echo "<div class='parent'>";
            echo "<div class='professor-box'>";
            echo "<h2>" . $row["firstName"] . " " . $row["lastName"] . "</h2>";


			global $db;
			$query1 = "SELECT avg(overall_rating), avg(hours_assignment_per_week), avg(hours_studying_per_week), avg(num_assignments) from rating natural join rankAbout natural join class where professorID = '$row[professorID]'";
			$statement1 = $db->prepare($query1);
			$statement1->execute();
			$rating = $statement1->fetch();
			$statement1->closeCursor();

			if ($rating[0]) {
				$prof_rating = $rating[0];
				$weekly_hours = $rating[1];
				$study_hours = $rating[2];
				$num_assignments = $rating[3];

			}
			else{
				$prof_rating = "No Ratings Yet";
				$weekly_hours = "No Ratings Yet";
				$study_hours = "No Ratings Yet";
				$num_assignments ="No Ratings Yet";
			}



            echo "Instructor Rating: ";
			echo $prof_rating;
			echo "<br> <br> Average Hours Spent on Assignments Weekly: ";
			echo $weekly_hours;
			echo "<br> <br> Average Hours Spent on Studying Weekly: ";
			echo $study_hours;
			echo "<br> <br> Average Number of Assignments: ";
			echo $num_assignments;
            
            echo "</div>";

            echo "<div class='professor-box'>";
            echo "<h3>Classes Taught:</h3>";
            echo "<ul>";
            // Join the class table with the professor table using professorID as the key
            
			//  while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
				// Join the class table with the professor table using professorID as the key
				$sql = "SELECT * FROM class WHERE professorID = '$row[professorID]'";
				$class_result = $db->query($sql);
				echo "<ul>";
                
				while ($class_row = $class_result->fetch(PDO::FETCH_ASSOC)) {
					$query_by_class = "SELECT avg(overall_rating) from rating natural join rankAbout natural join class where classID = $class_row[classID];";
					$statement1 = $db->prepare($query_by_class);
					$statement1->execute();
					$class_rating = $statement1->fetch();
					$statement1->closeCursor();

					if ($class_rating[0]) {
						$rating_by_class = $class_rating[0];
					}
					else{
						$rating_by_class = "No Ratings Yet";
					}
					echo "<li>" . $class_row["classCode"] . " - $rating_by_class </li>";
				}
				echo "</ul>";
			// }
			


            echo "</ul>";

        } else {
            echo "Professor not found.";
        }
    }
    echo "</div>";
    echo "</div>";



    // Query the database for all professors
    // $sql = "SELECT * FROM professor order by lastName";
    // $result = $db->query($sql);


    // // Display the dropdown with the list of professors
    // if ($result->rowCount() > 0) {
        echo "<div class='container'>";
        echo '<br>';
        echo "<div class='title-box'><h1>Ratings by Professor</h1></div>";
        echo "<form action='' method='post'>";
        echo "<input type='text' name='search' placeholder='Search by name' style='width:500px;' class='form-control'>";
        echo "<input type='submit' value='Search'  class='form-control'>";
        echo "</form>";
       
        echo "</div>";
        echo "<div>";

       
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

