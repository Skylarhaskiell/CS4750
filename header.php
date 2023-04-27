<!-- <{% load bootstrap5 %}
{% load static %}
{% bootstrap_css %}
{% bootstrap_javascript %} -->

<?php 
session_start();
$studentID = $_SESSION['studentID'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Course Rating</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link rel="icon" type="image/png" href="http://www.cs.virginia.edu/~up3f/cs4750/images/db-icon.png" />
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
</head>
<body>
  <!-- source for navbar: https://getbootstrap.com/docs/5.0/components/navbar/ -->

    <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #e3f2fd;">
        <div class="container-fluid">
          <a class="navbar-brand" href="index.php">CS Forum</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link" aria-current="page" href="index.php">Home</a>
              </li>
              <?php if (isset($_SESSION['studentID'])) : ?>
              <li class="nav-item">
                <a class="nav-link" href="rating_simpleform.php">Add Rating</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="simpleform.php">Add Comment</a>
              </li>
              <?php else : ?>
                <li class="nav-item">
                <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Add Rating</a>
              </li>
              <li class="nav-item">
                <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Add Comment</a>
              </li>
              <?php endif; ?>
              <li class="nav-item">
                <a class="nav-link" href="viewclass.php">Reviews By Class</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="viewprofessor.php">Reviews By Professor</a>
              </li>
              <!-- <li class="nav-item">
                <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
              </li> -->
            </ul>
            <div class="collapse navbar-collapse justify-content-end">
              <ul class="navbar-nav">
              <?php if (isset($_SESSION['studentID'])) : ?>
                <span class="navbar-text">
                You are logged in as: <?php echo $studentID; ?>
              </span>
                <li class="nav-item">
                <a class="nav-link" href="logout.php">Logout</a>
                
              </li>
              <?php else : ?>
                <li class="nav-item">
              <a class="nav-link" href="login.php">Login</a>
              <li class="nav-item">
                <a class="nav-link" href="create_user.php">Sign Up</a>
              </li>
              <?php endif; ?>
            </ul>
          </div>
          </div>
        </div>
      </nav>

</body>
</html>

