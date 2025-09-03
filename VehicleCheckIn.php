<?php
// Turn on error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Database credentials
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

// Fetch vehicles that are checked out but not yet checked in
$sql = "SELECT car_number_plate
        FROM ksgvehicle_checkout
        WHERE car_number_plate NOT IN (
            SELECT car_number_plate
            FROM ksgvehicle_checkin
        )";
        
$result = $conn->query($sql);

// Check if the query returned any rows
if ($result->num_rows > 0) {
    // Store car number plates in an array
    $vehicles = [];
    while ($row = $result->fetch_assoc()) {
        $vehicles[] = $row['car_number_plate'];
    }
} else {
    $vehicles = []; // No vehicles to check in
}

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Capture form data
    $checkout_Identifier = $_POST['checkout_Identifier'];
    $carNumberPlate = $_POST['carNumberPlate'];
    $driverName = $_POST['driverName'];
    $checkInDateTime = $_POST['checkInDateTime'];
    $campus = $_POST['campus'];  // Assuming there's a form field for campus

    // Fetch `check_out_datetime` and `authorized_by` from the `KSGvehicle_checkout` table using `checkout_Identifier`
    $checkoutDetailsSQL = "SELECT check_out_datetime, authorized_by
                        FROM ksgvehicle_checkout
                        WHERE checkout_identifier = ?";
    
    $checkoutStmt = $conn->prepare($checkoutDetailsSQL);
    $checkoutStmt->bind_param("s", $checkout_Identifier);
    $checkoutStmt->execute();
    $checkoutResult = $checkoutStmt->get_result();
    
    // Fetch the details
    if ($checkoutResult->num_rows > 0) {
        $checkoutData = $checkoutResult->fetch_assoc(); 
        $checkOutDateTime = $checkoutData['check_out_datetime'];
        $authorizedBy = $checkoutData['authorized_by'];

        // Format the check IN DateTime to the correct format for MySQL
        $checkInDateTimeFormatted = date('Y-m-d H:i:s', strtotime($checkInDateTime));

        // Format the check OUT DateTime to the correct format for MySQL
        $checkOutDateTimeFormatted = date('Y-m-d H:i:s', strtotime($checkOutDateTime));

        // Prepare an SQL query to insert the data into the `KSGvehicle_checkin` table
        $sql = "INSERT INTO ksgvehicle_checkin (checkout_identifier, car_number_plate, driver_name, check_in_datetime, check_out_datetime, authorized_by, campus)
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        
        // Prepare the statement
        $stmt = $conn->prepare($sql);
        
        // Bind parameters (include `check_out_datetime` and `authorized_by`)
        $stmt->bind_param("sssssss", $checkout_Identifier, $carNumberPlate, $driverName, $checkInDateTimeFormatted, $checkOutDateTimeFormatted, $authorizedBy, $campus);
        
        // Execute the query
        if ($stmt->execute()) {
            echo "<script>
                    alert('Vehicle with registration number $carNumberPlate has been checked In successfully!');
                    window.location.href = 'VehicleCheckInHTML.php'; // Redirect back to the checkIn form page
                </script>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
        
        // Close the statement
        $stmt->close();
    } else {
        echo "Error: No matching checkout data found for this vehicle.";
    }

    // Close the checkout statement
    $checkoutStmt->close();
}

// Close the connection
$conn->close();
?>

