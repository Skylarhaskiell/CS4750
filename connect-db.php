<?php
// Remember to start the database server (or GCP SQL instance) before trying to connect to it
////////////////////////////////////////////

/** S23, PHP (on Google Standard App Engine) connect to MySQL instance (GCP) **/
// $username = 'root';                       // or your username
// $password = 'your-root-password';     
// $host = 'instance-connection-name';       // e.g., 'cs4750:us-east4:db-demo'; 
// $dbname = 'your-database-name';           // e.g., 'guestbook';
// $dsn = "mysql:unix_socket=/cloudsql/instance-connection-name;dbname=your-database-name";
//       e.g., "mysql:unix_socket=/cloudsql/cs4750:us-east4:db-demo;dbname=guestbook";
// --------- to test, include app.yaml with the following code
// runtime: php74
// entrypoint: serve connect-db.php

// to get instance connection name, go to GCP SQL overview page
////////////////////////////////////////////

/** S23, PHP (on local XAMPP or CS server) connect to MySQL instance (GCP) **/
// $username = 'root';
// $password = 'your-root-password';
// $host = 'instance-connection-name';       // e.g., 'cs4750:us-east4:db-demo'; 
// $dbname = 'your-database-name;;           // e.g., 'guestbook';
// $dsn = "mysql:host=your-SQL-public-IP-address;dbname=your-database-name";   // connect PHP (XAMPP) to DB (GCP)
//       e.g., "mysql:host=99.99.999.99;dbname=$dbname";   

// to get public IP addres of the SQL instance, go to GCP SQL overview page

// To connect from a local PHP to GCP SQL instance, need to add authormized network
// to allow (my)machine to connect to the SQL instance. 
// 1. Get IP of the computer that tries to connect to the SQL instance
//    (use http://ipv4.whatismyv6.com/ to find the IP address)
// 2. On the SQL connections page, add authorized networks, enter the IP address
////////////////////////////////////////////

/** S23, PHP (on GCP, local XAMPP, or CS server) connect to MySQL (on local XAMPP) **/
// $username = 'your-username';
// $password = 'your-password';
// $host = 'localhost:3306';           // default phpMyAdmin port = 3306
// $dbname = 'your-database-name';
// $dsn = "mysql:host=$host;dbname=$dbname";  
////////////////////////////////////////////
$username = 'smw6ure'; 
$password = 'CS4750!';
$host = 'mysql01.cs.virginia.edu';
$dbname = 'smw6ure_c';
$dsn = "mysql:host=$host;dbname=$dbname";
/** S23, PHP (on GCP, local XAMPP, or CS server) connect to MySQL (on CS server) **/
// $username = 'projectUser'; 
// $password = 'password';
// $host = 'LocalHost';
// $dbname = 'databaseproject';
// $dsn = "mysql:host=$host;dbname=$dbname";
////////////////////////////////////////////

try{
//  $db = new PDO("mysql:host=$hostname;dbname=db-demo", $username, $password);
   $db = new PDO($dsn, $username, $password);
   $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   
   // dispaly a message to let us know that we are connected to the database 
   //echo "<p>You are connected to the database: $dsn</p>";
}
catch (PDOException $e)     // handle a PDO exception (errors thrown by the PDO library)
{
   // Call a method from any object, use the object's name followed by -> and then method's name
   // All exception objects provide a getMessage() method that returns the error message 
   $error_message = $e->getMessage();        
   echo "<p>An error occurred while connecting to the database: $error_message </p>";
}
catch (Exception $e)       // handle any type of exception
{
   $error_message = $e->getMessage();
   echo "<p>Error message: $error_message </p>";
}

?>