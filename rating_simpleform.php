<?php include 'header.php';
?>
<?php
require("connect-db.php");
require("rating-db.php");

$ratings = selectAllRatings();
//var_dump($ratings);

echo $_POST['course'];

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
  if (!empty($_POST['actionBtn']) && ($_POST['actionBtn'] == "Add Rating")) 
  {
    #add to rating table
    addRating($_POST['overall_rating'], $_POST['hours_per_week_assignments'], $_POST['hours_per_week_study'], $_POST['num_assignments']);
    #add to ranks table
    addRanks($_POST['computingID']);
    # retrieving class ID
    $classID = (int)getClassID($_POST['course'], $_POST['year'], $_POST['semester']);
    #add to rankAbout table
    addRankAbout($classID);
    #refresh ratings
    $ratings = selectAllRatings();
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
  <h1>Course Rating</h1>  
  <form name="mainForm" action="rating_simpleform.php" method="post">  
  <div class="row mb-3 mx-3">
    ComputingID:
    <input type="text" class="form-control" name="computingID" required />        
  </div>


  <div class="row mb-3 mx-3"> 
    Course: 
    <select type="text" class="form-control" name = 'course' required>
      <option> SELECT COURSE </option>
      <?php 
        $connection = mysqli_connect("mysql01.cs.virginia.edu","smw6ure","CS4750!","smw6ure_b");
        $sql = mysqli_query($connection, "SELECT DISTINCT classCode from class ORDER BY classCode");
        while ($row = $sql->fetch_assoc()){
          echo "<option>" . $row['classCode']. "</option>";
        }
      ?>
  </select>
  </div>

  <div class="row mb-3 mx-3"> 
    Year: 
    <select type="text" class="form-control" name = 'year' required>
      <?php 
        $connection = mysqli_connect("mysql01.cs.virginia.edu","smw6ure","CS4750!","smw6ure_b");
        $sql = mysqli_query($connection, "SELECT DISTINCT year from class");
        while ($row = $sql->fetch_assoc()){
          echo "<option>" . $row['year']. "</option>";
        }
      ?>
  </select>
  </div>

  <div class="row mb-3 mx-3"> 
    Semester: 
    <select type="text" class="form-control" name = 'semester' required>
      <?php 
        $connection = mysqli_connect("mysql01.cs.virginia.edu","smw6ure","CS4750!","smw6ure_b");
        $sql = mysqli_query($connection, "SELECT DISTINCT semester from class");
        while ($row = $sql->fetch_assoc()){
          echo "<option>" . $row['semester']. "</option>";
        }
      ?>
  </select>
  </div>


  <div class="row mb-3 mx-3">
    Overall Rating:
    <input type="text" class="form-control" name="overall_rating" required />        
  </div>
  <div class="row mb-3 mx-3">
    Hours spent on assignments per week:
    <input type="text" class="form-control" name="hours_per_week_assignments" required />        
  </div>
  <div class="row mb-3 mx-3">
    Hours spent studying per week:
    <input type="text" class="form-control" name="hours_per_week_study" required />        
  </div>
  <div class="row mb-3 mx-3">
    Number of assignments:
    <input type="text" class="form-control" name="num_assignments" required />        
  </div>
  <div class="row mb-3 mx-3">
  <input type="submit" class="btn btn-primary" name="actionBtn" value="Add Rating" title="click to add rating">
</div>

</form>  

<div class="row justify-content-center">  
<table class="w3-table w3-bordered w3-card-4 center" style="width:90%">
  <thead>
  <tr style="background-color:#B0B0B0">
    <th>Course        
    <th>Semester        
    <th>Year 
    <th>Professor 
    <th>Rating
    <th>Hours On Assignments/Week   
    <th>Hours Studying/Week 
    <th>#Assignments 
  </tr>
  </thead>
<?php foreach ($ratings as $rating): ?>
  <tr>
     <td><?php echo $rating['classCode']; ?></td>
     <td><?php echo $rating['semester']; ?></td>        
     <td><?php echo $rating['year']; ?></td>  
     <td><?php echo $rating['professorID']; ?></td> 
     <td><?php echo $rating['overall_rating']; ?></td>    
     <td><?php echo $rating['hours_assignment_per_week']; ?></td>    
     <td><?php echo $rating['hours_studying_per_week']; ?></td>  
     <td><?php echo $rating['num_assignments']; ?></td>                            
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
