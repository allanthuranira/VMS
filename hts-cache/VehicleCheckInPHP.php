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

// Fetch vehicles that are checked out but not yet checked in
$sql = "SELECT car_number_plate
        FROM KSGvehicle_checkout
        WHERE car_number_plate NOT IN (
            SELECT car_number_plate
            FROM KSGvehicle_checkin
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

    // Fetch `check_out_datetime` and `authorized_by` from the `KSGvehicle_checkout` table using `checkout_Identifier`
    $checkoutDetailsSQL = "SELECT check_out_datetime, authorized_by
                        FROM KSGvehicle_checkout
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
        $checkInDateTimeFormatted = date('F j, Y, g:i a', strtotime($checkInDateTime));

        // Format the check OUT DateTime to the correct format for MySQL
        $checkOutDateTimeFormatted = date('F j, Y, g:i a', strtotime($checkOutDateTime));
        

        // Prepare an SQL query to insert the data into the `KSGvehicle_checkin` table
        $sql = "INSERT INTO ksgvehicle_checkin (checkout_identifier, car_number_plate, driver_name, check_in_datetime, check_out_datetime, authorized_by)
                VALUES (?, ?, ?, ?, ?, ?)";
        
        // Prepare the statement
        $stmt = $conn->prepare($sql);
        
        // Bind parameters (include `check_out_datetime` and `authorized_by`)
        $stmt->bind_param("ssssss", $checkout_Identifier, $carNumberPlate, $driverName, $checkInDateTimeFormatted, $checkOutDateTimeFormatted, $authorizedBy);
        
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

    // Close the checkout statement and connection
    $checkoutStmt->close();
    $conn->close();
}
?>
