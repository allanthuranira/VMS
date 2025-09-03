<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection parameters
$servername = "127.0.0.1";  // better to use 127.0.0.1 instead of localhost for mysqli
$username   = "admin";      // use your DB username
$password   = "1!Admin$";   // use your DB password
$dbname     = "ksg3";
$port       = 3306;  // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form data is set
if (isset($_POST['idNumber']) && isset($_POST['arrivalTime'])) {
    // Get the form data
    $idNumber = $_POST['idNumber'];
    $arrivalTime = $_POST['arrivalTime'];

    // Check if the ID already exists
    $sql = "SELECT * FROM ksgat WHERE idNumber = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $idNumber);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<script type='text/javascript'>
                alert('Thank you! You have already registered your arrival time today. Another participant can Register or Login for the day.');
                window.location.href='login.php';
              </script>";
    } else {
        // Prepare and bind the SQL statement
        $stmt = $conn->prepare("INSERT INTO ksgat (idNumber, arrivalTime) VALUES (?, ?)");
        $stmt->bind_param("ss", $idNumber, $arrivalTime);

        // Execute the statement
        if ($stmt->execute() === TRUE) {
            echo "<script type='text/javascript'>
                    alert('Arrival time registered successfully!' + String.fromCharCode(10) + 'Next participant can login or register.');
                    window.location.href='login.php';
                  </script>";
        } else {
            echo "<script type='text/javascript'>
                    alert('Error: " . $stmt->error . "');
                    window.location.href='index.html';
                  </script>";
        }
    }

    $stmt->close();
} else {
    echo "<script type='text/javascript'>
            alert('Error: Missing ID Number or Arrival Time.');
            window.location.href='index.html';
          </script>";
}

$conn->close();
?>
