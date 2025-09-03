<?php
// Database credentials
 $servername = "127.0.0.1";
 $username = "admin";
 $password = "1!Admin$";
 $dbname = "ksg3";
 $port = 3306;


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
    $campus = $_POST['campus']; // Capture the campus field from the form

    // Check if campus is empty (optional validation)
    if (empty($campus)) {
        echo "<script>alert('Campus must be selected!'); window.location.href = 'VehicleCheckOutHTML.php';</script>";
        exit;
    }

    // Generate the unique identifier
    // Format: [Car Number Plate]-[Date]-[Time] (e.g., KCD390G-20231008-142300)
    $checkOutIdentifier = $carNumberPlate . '-' . date('Ymd-His', strtotime($checkOutDateTime));
    
    // Format the checkOutDateTime to the correct format for MySQL
    $checkOutDateTimeFormatted = date('Y-m-d H:i:s', strtotime($checkOutDateTime));

    // Prepare an SQL query to insert the data into the database
    $sql = "INSERT INTO ksgvehicle_checkout (car_number_plate, driver_name, authorized_by, check_out_datetime, checkout_identifier, campus)
            VALUES (?, ?, ?, ?, ?, ?)";

    // Prepare the statement
    $stmt = $conn->prepare($sql);

    // Bind parameters (6 strings: car_number_plate, driver_name, authorized_by, check_out_datetime, checkout_identifier, campus)
    $stmt->bind_param("ssssss", $carNumberPlate, $driverName, $authorizedBy, $checkOutDateTimeFormatted, $checkOutIdentifier, $campus);

    // Execute the query
    if ($stmt->execute()) {
        echo "<script>
                alert('$carNumberPlate has been checked out successfully. The Check-Out Identifier is $checkOutIdentifier!');
                window.location.href = 'VehicleCheckOutHTML.php'; // Redirect back to the checkout form page
            </script>";
    } else {
        // Check if the error is due to a duplicate entry (i.e., same car_number_plate)
        echo "<script>
                alert('Cannot check out $carNumberPlate twice!');
                window.location.href = 'VehicleCheckOutHTML.php'; // Redirect back to the checkout form page
            </script>";
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
