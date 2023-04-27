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

    // Retrieve the list of classes for the dropdown
    $sql = "SELECT DISTINCT classCode FROM class";
    $stmt = $db->query($sql);
    $classes = $stmt->fetchAll(PDO::FETCH_ASSOC);
  
    // Display the search form with dropdown menu
    echo "<br>";
    echo "<div class='container'>";
    echo "<div class='title-box'><h1> Ratings by Class</h1></div>";
    echo "<form action='' method='post'>";
    echo "<select name='class' class='form-control' style = 'width: 300px; text-align:center;'>";
    foreach ($classes as $class) {
      echo '<option value="none" selected disabled hidden>      Select a Class       </option>';
      echo "<option value='" . $class['classCode'] . "'>" . $class['classCode'] . "</option>";
    }
    echo "</select>";
    echo "<input type='submit' value='Select' class='form-control'>";
    echo "</form>";
    echo "</div>";


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
        echo "<div class = 'name-box'> <h2>" . $row["classCode"] . " with " . $row["firstName"] . " " . $row["lastName"] . "</h2> </div>";

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
        $comment_result = $stmt->fetchAll(PDO::FETCH_ASSOC);


        $sql = "SELECT * FROM class natural join professor natural join (rating natural join rankAbout) where classID = :classID";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':classID', $current_class);
        $stmt->execute();
        $rating_result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo "<h4 style='font-weight:bolder;'>Reviews:</h4>";
        if ($comment_result[0]) {
          foreach ($comment_result as $comment_row) {
            echo $comment_row["content"] . "<br>";
            echo $comment_row['date_posted'] . "<br><br>";
          }
        } 
        
        else {
          echo "<p>No comments for this class yet.</p>";
        }
        echo "<h4 style='font-weight:bolder;'>Ratings:</h4>";
        if ($rating_result[0]) {
          foreach ($rating_result as $rating_row) {
            echo "Overall Rating: " . $rating_row["overall_rating"] . "<br>";
            echo "Weekly Hours on Assignments: " . $rating_row["hours_assignment_per_week"] . "<br>";
            echo "Weekly Hours Studying: " . $rating_row["hours_studying_per_week"] . "<br>";
            echo "Number of Assignments: " . $rating_row["num_assignments"] . "<br><br>";
          }
        } 
        else {
          echo "<p>No ratings for this class yet.</p>";
        }


        echo "</div>";
      }
    } else {
      echo "Class not found.";
    }
  }

?>
</body>
</html>




<style> 
    .professor-box { 
      display: inline-block; 
      vertical-align: top; 
      display: inline-block; 
      vertical-align: top; 
      width: 48%; 
      display: inline-block; 
      vertical-align: top; 
      padding: 30 px; 
      text-align:center;
      border-radius: 10px;
      border-color: #f7ede2;
      border-width: 5px;
      border-style: solid;
      background-color: #f5cac3;
      margin-top: 10px;
      margin-left: 10px;
      margin-right: 10px;
      margin-bottom: 10px;

  } 
  .name-box { 
      display: inline-block; 
      vertical-align: top; 
      display: inline-block; 
      vertical-align: top; 
      width: 70%; 
      display: inline-block; 
      vertical-align: top; 
      padding: 30px; 
      text-align:center;
      border-radius: 10px;
      border-color: #f7ede2;
      border-width: 5px;
      border-style: solid;
      background-color: white;
  } 
  
</style> 