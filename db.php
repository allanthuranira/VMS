<?php
$servername = "127.0.0.1";  // better to use 127.0.0.1 instead of localhost for mysqli
$username   = "admin";      // use your DB username
$password   = "1!Admin$";   // use your DB password
$dbname     = "ksg3";
$port       = 3306;  

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
