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
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="author" content="Hannah Tuma">
  <meta name="description" content="include some description about your page">  
  <title>Home</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link rel="icon" type="image/png" href="http://www.cs.virginia.edu/~up3f/cs4750/images/db-icon.png" />
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
</head>
<body>
<?php include 'header.php'; ?>
<?php
  // Establish a database connection
  require("connect-db.php");
  global $db;

  if (isset($_POST['class'])) {
    $selectedClass = $_POST['class'];

    // Search for classes whose classCode matches the selected class
    $sql = "SELECT * from class natural join professor where classCode = :classCode";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':classCode', $selectedClass);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!empty($result)) {
      foreach ($result as $row) {
        echo "<div class='professor-box'>";
        echo "<h2>" . $row["classCode"] . "</h2>";
        echo "<p>Taught by " . $row["firstName"] . " " . $row["lastName"] . "</p>";

        $current_class = $row["classID"];
    //      echo "<h3>Ratings:</h3>";
    // echo "<p>Overall Rating: " . $row["overall_rating"] . "</p>";
    // echo "<p>Hours Assignment per Week: " . $row["hours_assignment_per_week"] . "</p>";
    // echo "<p>Hours Studying per Week: " . $row["hours_studying_per_week"] . "</p>";
    // echo "<p>Number of Assignments: " . $row["num_assignments"] . "</p>";
    
        // Get all comments for this class
        $sql = "SELECT * FROM class natural join professor natural join (comments natural join classComment) where classID = :classID";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':classID', $current_class);
        $stmt->execute();
        $ratings_result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $sql = "SELECT * FROM class natural join professor natural join (rating natural join rankAbout) where classID = :classID";
        //$sql = "SELECT * FROM class natural join professor natural join (comments  natural join classComment) where classID = :classID";
        
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':classID', $current_class);
        $stmt->execute();
        $class_result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (!empty($ratings_result)) {
          echo "<div class='class-list'>";
          echo "<div class='class-list'>
          <h3>Comments and Ratings:</h3>";
          foreach ($ratings_result as $rating_row) {
            echo "Reviews:";
            echo "<p>" . $rating_row["content"] . "</p>";
          }
          foreach( $class_result as $comment_row){
            echo "Comments:";
            echo "<p>" . $comment_row["content"] . "</p>";
          }
          echo "</div>";
        } else {
          echo "<div class='class-list'>";
          echo "<p>No comments for this class yet.</p>";
          echo "</div>";
        }
        echo "</div>";
      }
    } else {
      echo "Class not found.";
    }
  }

  // Retrieve the list of classes for the dropdown
  $sql = "SELECT DISTINCT classCode FROM class";
  $stmt = $db->query($sql);
  $classes = $stmt->fetchAll(PDO::FETCH_ASSOC);

  // Display the search form with dropdown menu
  echo "<div class='container'>";
  echo "<div class='title-box'><h2>Search for a class to see its ratings</h2></div>";
  echo "<form action='' method='post'>";
  echo "<select name='class'>";
  foreach ($classes as $class) {
    echo "<option value='" . $class['classCode'] . "'>" . $class['classCode'] . "</option>";
  }
  echo "</select>";
  echo "<input type='submit' value='Select'>";
  echo "</form>";
  echo "</div>";
?>
</body>
</html>

