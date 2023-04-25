<?php include 'header.php';
?>
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

  <meta charset="UTF-8">  
  
  <!-- 2. include meta tag to ensure proper rendering and touch zooming -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- 
  Bootstrap is designed to be responsive to mobile.
  Mobile-first styles are part of the core framework.
   
  width=device-width sets the width of the page to follow the screen-width
  initial-scale=1 sets the initial zoom level when the page is first loaded   
  -->
  
  <meta name="author" content="Hannah Tuma">
  <meta name="description" content="include some description about your page">  
    
  <title>Home</title>
  
  <!-- 3. link bootstrap -->
  <!-- if you choose to use CDN for CSS bootstrap -->  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  
  <!-- you may also use W3's formats -->
  <!-- <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css"> -->
  
  <!-- 
  Use a link tag to link an external resource.
  A rel (relationship) specifies relationship between the current document and the linked resource. 
  -->
  
  <!-- If you choose to use a favicon, specify the destination of the resource in href -->
  <link rel="icon" type="image/png" href="http://www.cs.virginia.edu/~up3f/cs4750/images/db-icon.png" />
  
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

  
  <!-- if you choose to download bootstrap and host it locally -->
  <!-- <link rel="stylesheet" href="path-to-your-file/bootstrap.min.css" /> --> 
  
  <!-- include your CSS -->
  <!-- <link rel="stylesheet" href="custom.css" />  -->

</head>
<body>
<?php
	// Establish a database connection
	require("connect-db.php");
	global $db;

	if (isset($_POST['search'])) {
		$search = $_POST['search'];

		// Search for classes whose classCode matches the search query
		
        $sql = "SELECT * from class where classCode like '%$search%' ";
		$result = $db->query($sql);

		if ($result->rowCount() > 0) {
			while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
				echo "<div class='professor-box'>";
				echo "<h2>" . $row["classCode"] . "</h2>";
				// echo "<p>Professor: " . $row["firstName"] . " " . $row["lastName"] . "</p>";

				// Get all comments and ratings for this class
				$sql = "SELECT class.classID, class.classCode, class.semester, class.year, professor.firstName, professor.lastName
					FROM class
					JOIN professor ON professor.professorID = class.professorID
					WHERE class.classCode LIKE '%$search%'";
				// $sql = "SELECT * FROM rating WHERE classID = " . $row["classID"];
					$ratings_result = $db->query($sql);

				if ($ratings_result->rowCount() > 0) {
					echo "<div class='class-list'>";
					
					echo "<h3>Comments and Ratings:</h3>";
					while ($rating_row = $ratings_result->fetch(PDO::FETCH_ASSOC)) {
						echo "<p>" . $rating_row["comment"] . "</p>";
						echo "<p>Rating: " . $rating_row["rating"] . "</p>";
					}
					echo "</div>";
				} else {
					echo "<div class='class-list'>";
					echo "<p>No ratings for this class yet.</p>";
					echo "</div>";
				}
				echo "</div>";
			}
		} else {
			echo "Class not found.";
		}
	}

	// Display the search form
	echo "<div class='container'>";
	echo "<div class='title-box'><h2>Search for a class to see its ratings</h2></div>";
	echo "<form action='' method='post'>";
	echo "<input type='text' name='search' placeholder='Search by class code'>";
	echo "<input type='submit' value='Search'>";
	echo "</form>";
	echo "</div>";

?>
</body>
</html>