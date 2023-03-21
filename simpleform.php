<?php
require("connect-db.php");

require("friend-db.php");

$friends = selectAllFriends();
//var_dump($friends);

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
  if (!empty($_POST['actionBtn']) && ($_POST['actionBtn'] == "Add friend"))
  {
    addFriend($_POST['name'], $_POST['major'], $_POST['year']);
    $friends = selectAllFriends();
  }
   else if (!empty($_POST['actionBtn']) && ($_POST['actionBtn'] == "Delete"))
  {
    deleteFriend($_POST['friend_to_delete']);
    $friends = selectAllFriends();
  }
}

?>

<!-- 1. create HTML5 doctype -->
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">  
  
  <!-- 2. include meta tag to ensure proper rendering and touch zooming -->
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
  <h1>Friend Book</h1>  

  <form name="mainForm" action="simpleform.php" method="post">   
  <div class="row mb-3 mx-3">
    Name:
    <input type="text" class="form-control" name="name" required />  
    </div> 
    <div class="row mb-3 mx-3">    
    Major:
    <input type="text" class="form-control" name="major" required /> 
    </div>
    <div class="row mb-3 mx-3">  
    Year:
    <input type="text" class="form-control" name="year" required />   
  </div> 
  <div class="row mb-3 mx-3">
  <input type="submit" class="btn btn-primary" name="actionBtn" value="Add friend" title="click to insert friend"/> 
</div>
</form> 



  
</div> 
<div class="row justify-content-center">  
<table class="w3-table w3-bordered w3-card-4 center" style="width:70%">
  <thead>
  <tr style="background-color:#B0B0B0">
    <th width="30%">Name</th>        
    <th width="30%">Major</th>        
    <th width="30%">Year</th> 
    <th>Update?</th>
    <th>Delete?</th>
  </tr>
  </thead>
<?php foreach ($friends as $item): ?>
  <tr>
     <td><?php echo $item['name']; ?></td>
     <td><?php echo $item['major']; ?></td>        
     <td><?php echo $item['year']; ?></td>
     <td>
      <form action="simpleform.php" method="post">
        <input type="submit" name="actionBtn" value="Update" class="btn btn-dark" />
        <input type="hidden" name="friend_to_update" value="<?php echo $item['name'];?>" />
      </form>
    </td>    
    <td>
      <form action="simpleform.php" method="post">
        <input type="submit" name="actionBtn" value="Delete" class="btn btn-danger" />
        <input type="hidden" name="friend_to_delete" value="<?php echo $item['name'];?>" />
      </form>
    </td>                   
  </tr>
<?php endforeach; ?>
</table>
</div>     
</body>
</html>