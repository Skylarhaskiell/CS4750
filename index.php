<?php include 'header.php';?>
<!-- 1. create HTML5 doctype -->
<!DOCTYPE html>
<html>
<head>
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
  
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  <!-- if you choose to download bootstrap and host it locally -->
  <!-- <link rel="stylesheet" href="path-to-your-file/bootstrap.min.css" /> --> 
  
  <!-- include your CSS -->
  <!-- <link rel="stylesheet" href="custom.css" />  -->
  

</head>

<body>
  
<div class="container" >
  <h1 class = 'header'>Welcome to the Course Rating Page</h1>  





  <!-- CDN for JS bootstrap -->
  <!-- you may also use JS bootstrap to make the page dynamic -->
  <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script> -->
  
  <!-- for local -->
  <!-- <script src="your-js-file.js"></script> -->  
  

  <div class="search-container">
    <form action="/action_page.php">
      <input class="form-control" type="text" placeholder="Search.." name="search" style = 'width: 80%;'>
    </form>
  </div>



  
  <br>
  <div class="div1" style="background-color: #f6bd60">
    <a class='text1' href="rating_simpleform.php">Add A Rating</a>
  </div> 
  <div class="div1" style="background-color: #f5cac3">
    <a class='text1' href="simpleform.php">Add A Comment</a>
  </div> 
  <div class="div1" style="background-color: #84a59d">
    <a class='text1' href = "viewclass.php"> Reviews by Class</a>
  </div> 
  <div class="div1" style="background-color: #f28482">
    <a class='text1' href = "viewprofessor.php"> Reviews by Professor</a>
  </div> 

  <style> 
    .container { 
      padding:50px;
  } 
  </style> 

  <style> 
    .div1 { 
      display: inline-block; 
      vertical-align: top; 
      display: inline-block; 
      vertical-align: top; 
      width: 20%; 
      display: inline-block; 
      vertical-align: top; 
      padding: 30px; 
      text-align:center;
      border-radius: 10px;
      border-color: #f7ede2;
      border-width: 5px;
      border-style: solid;
  } 
</style> 

<style> 
  .text1 { 
    color: #f7ede2;
    text-decoration: none;
} 
</style> 

<style> 
  .header { 
    display: inline-block; 
    vertical-align: top; 
    display: inline-block; 
    vertical-align: top; 
    width: 80%; 
    display: inline-block; 
    vertical-align: top; 
    padding: 10px; 
    text-align:center;
    margin-left: auto;
    margin-right: auto;
} 
</style> 

</div>    
</body>
</html>




