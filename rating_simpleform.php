<?php include 'header.php';
?>
<?php
require("connect-db.php");
require("rating-db.php");
require('friend-db.php');



//var_dump($ratings);
// echo $professorID;
session_start(); // Start the session

$studentID = $_SESSION['studentID'];

$ratings = selectAllRatings($studentID);

$rating_to_delete = null;


if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
  if (!empty($_POST['actionBtn']) && ($_POST['actionBtn'] == "Add Rating")) 
  {
    #add to rating table
    addRating($_POST['overall_rating'], $_POST['hours_per_week_assignments'], $_POST['hours_per_week_study'], $_POST['num_assignments']);
    #add to ranks table
    addRanks($studentID);
    # retrieving class ID
    $classID = (int)getClassID($_POST['course'], $professorID);
    #add to rankAbout table
    addRankAbout($_POST['course']);
    #refresh ratings
    $ratings = selectAllRatings($studentID);
    header("location:rating_simpleform.php");

  }
  else if (!empty($_POST['actionBtn']) && ($_POST['actionBtn'] == "Delete")) {
    $rating_to_delete = $_POST['rating_to_delete'];
    deleteRating($rating_to_delete);
    // deleteRankAbout($rating_to_delete);
    // deleteRanks($rating_to_delete);
    $ratings = selectAllRatings($studentID);
    header("location:rating_simpleform.php");
  }

}
?>


<!-- 1. create HTML5 doctype -->
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">  
  
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  
  <meta name="author" content="Hannah Tuma">
  <meta name="description" content="include some description about your page">  
    
  <title>Bootstrap example</title>
  

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  

  <link rel="icon" type="image/png" href="http://www.cs.virginia.edu/~up3f/cs4750/images/db-icon.png" />
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

       
</head>


<body>
  
<div class="container">
  <h1>Add Course Rating</h1>  
  <form name="mainForm" action="rating_simpleform.php" method="post">  
  <!-- <div class="row mb-3 mx-3">
    ComputingID:
    <input type="text" class="form-control" name="computingID" required />        
  </div> -->


  <div class="row mb-3 mx-3"> 
    Course: 
    <select type="text" class="form-control" name = 'course' required>
      <option> SELECT COURSE </option>
      <?php 
        $connection = mysqli_connect("mysql01.cs.virginia.edu","smw6ure","CS4750!","smw6ure_c");
        $sql = mysqli_query($connection, "SELECT classID, classCode, firstName, lastName, professorID from class NATURAL JOIN professor ORDER BY classCode");
        while ($row = $sql->fetch_assoc()){
          if($row['professorID'] != ""){
            echo "<option value='" . $row['classID'] . "'>" . $row['classCode']. " - " . $row['firstName'] . " " . $row['lastName'] ."</option>";
          }
          else{
            echo "<option value='" . $row['classID'] . "'>" . $row['classCode']. " - Unknown Professor" ."</option>";
          }
        }
      ?>
  </select>
  </div>


  <div class="row mb-3 mx-3">
    Overall Rating:
    <input type="number" class="form-control" name="overall_rating" min="1" max="5" required />        
  </div>
  <div class="row mb-3 mx-3">
    Hours spent on assignments per week:
    <input type="number" class="form-control" name="hours_per_week_assignments" min="0" max="168" required />        
  </div>
  <div class="row mb-3 mx-3">
    Hours spent studying per week:
    <input type="number" class="form-control" name="hours_per_week_study" min="0" max="168" required />        
  </div>
  <div class="row mb-3 mx-3">
    Number of assignments:
    <input type="number" class="form-control" name="num_assignments" min="0" required />        
  </div>
  <div class="row mb-3 mx-3">
  <input type="submit" class="btn btn-primary" name="actionBtn" value="Add Rating" title="click to add rating" style='background-color:#f28482;'>
</div>

</form>  

<div class="row justify-content-center">  
<table class="w3-table w3-bordered w3-card-4 center" style="width:90%">
  <thead>
  <tr style="background-color:#B0B0B0">
    <th>Course        
    <th>Professor 
    <th>Student ID  
    <th>Rating
    <th>Hours On Assignments/Week   
    <th>Hours Studying/Week 
    <th>#Assignments 
    <th>Delete? 
  </tr>
  </thead>
<?php foreach ($ratings as $rating): ?>
  <tr>
     <td><?php echo $rating['classCode']; ?></td>
     <td><?php echo $rating['firstName'] . " " . $rating['lastName']; ?></td> 
     <td><?php echo $rating['studentID']; ?></td>
     <td><?php echo $rating['overall_rating']; ?></td>    
     <td><?php echo $rating['hours_assignment_per_week']; ?></td>    
     <td><?php echo $rating['hours_studying_per_week']; ?></td>  
     <td><?php echo $rating['num_assignments']; ?></td>     
    <td>
      <form action="rating_simpleform.php" method="post">
        <input type="submit" name="actionBtn" value="Delete" class="btn btn-danger" style='background-color:#f28482;'/>
        <input type="hidden" name="rating_to_delete" value="<?php echo $rating['rankID'];?>" />
      </form>
    </td> 
  </tr>
<?php endforeach; ?>
</table>
</div>  


 <br>
 <br>
 <br>
  
</div>    
</body>
</html>
