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
<?php include 'header.php';
?>
<?php
  // Establish a database connection
  require("connect-db.php");
  global $db;


  if (isset($_POST['search'])) {
    $search = $_POST['search'];


    // Search for classes whose classCode matches the search query
   
        $sql = "SELECT * from class natural join professor where classCode like '%$search%' ";
    $result = $db->query($sql);


    if ($result->rowCount() > 0) {
      while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        echo "<div class='professor-box'>";
        echo "<h2>" . $row["classCode"] . "</h2>";
        echo "<p>Taught by " . $row["firstName"] . " " . $row["lastName"] . "</p>";

        $current_class = $row["classID"];
        // Get all comments for this class
        $sql = "SELECT * FROM class natural join professor natural join (comments natural join classComment) where classID like '%$current_class%'";
          $ratings_result = $db->query($sql);
        if ($ratings_result->rowCount() > 0) {
          echo "<div class='class-list'>";
          echo "<h3>Comments and Ratings:</h3>";
          while ($rating_row = $ratings_result->fetch(PDO::FETCH_ASSOC)) {
            echo "Reviews:";
            echo "<p>" . $rating_row["content"] . "</p>";
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
