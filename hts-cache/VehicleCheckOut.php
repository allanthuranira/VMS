<?php
// Database credentials
$servername = "localhost";
$username = "root";  // Default MySQL username
$password = "";      // Default password is empty for localhost
$dbname = "ksg3";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Capture form data
    $carNumberPlate = $_POST['carNumberPlate'];
    $driverName = $_POST['driverName'];
    $authorizedBy = $_POST['authorizedBy'];
    $checkOutDateTime = $_POST['checkOutDateTime'];

    // Generate the unique identifier
    // Format: [Car Number Plate]-[Date]-[Time] (e.g., KCD390G-20231008-142300)
    $checkOutIdentifier = $carNumberPlate . ' - ' . date('Y/m/d H:i:s', strtotime($checkOutDateTime));
    
    // Format the arrivalDateTime to the correct format for MySQL
    $checkOutDateTimeFormatted = date('F j, Y, g:i a', strtotime($checkOutDateTime));

    // Prepare an SQL query to insert the data into the database
    $sql = "INSERT INTO ksgvehicle_checkout (car_number_plate, driver_name, authorized_by, check_out_datetime, checkout_identifier)
            VALUES (?, ?, ?, ?, ?)";
    
    // Prepare the statement
    $stmt = $conn->prepare($sql);
    
    // Bind parameters (4 strings: car_number_plate, driver_name, authorized_by, check_out_datetime, unique_identifier)
    $stmt->bind_param("sssss", $carNumberPlate, $driverName, $authorizedBy, $checkOutDateTimeFormatted, $checkOutIdentifier);
    
    // Execute the query
    if ($stmt->execute()) {
        echo "<script>
                alert(' $carNumberPlate has been checked out successfully, the Check-Out Identifier is $checkOutIdentifier !');
                window.location.href = 'VehicleCheckOutHTML.php'; // Redirect back to the checkout form page
            </script>";
    } else {
        echo "<script>
                alert('Can not check OUT $carNumberPlate twice!');
                window.location.href = 'VehicleCheckOutHTML.php'; // Redirect back to the checkout form page
            </script>";
    }
    
    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
