<?php
// Set the expiration time (e.g., 1 hour from now)
$expirationTime = time() + 30; // current time + 30 seconds
// Encode the expiration time using base64
$encodedExpirationTime = base64_encode($expirationTime);

// Database connection
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

// Function to sanitize input data
function sanitizeInput($data) {
    global $conn;
    return htmlspecialchars(stripslashes(trim($conn->real_escape_string($data))));
}

// Sanitize and retrieve form data
$idNumber = sanitizeInput($_POST['idNumber']);
$arrivalDateTime = sanitizeInput($_POST['arrivalDateTime']);
$MeansQuestion = isset($_POST['MeansQuestion']) ? sanitizeInput($_POST['MeansQuestion']) : null;
$motorNumber = (isset($_POST['motorNumber']) && $MeansQuestion === 'yes') ? sanitizeInput($_POST['motorNumber']) : null;
$passengersQuestion = isset($_POST['passengersQuestion']) ? sanitizeInput($_POST['passengersQuestion']) : null;
$passengerNumber = (isset($_POST['passengerNumber']) && $passengersQuestion === 'yes') ? sanitizeInput($_POST['passengerNumber']) : null;
$campus = htmlspecialchars($_POST['campus']);


// Get the current date
$currentDate = date('Y-m-d');

// Check if the user exists in the registration table
$sql_check_user = "SELECT fullName, phoneNumber, ksgStaffOrParticipantOrVisitor FROM ksggd WHERE idNumber = ?";
$stmt_check_user = $conn->prepare($sql_check_user);
$stmt_check_user->bind_param("s", $idNumber);
$stmt_check_user->execute();
$stmt_check_user->store_result();

if ($stmt_check_user->num_rows > 0) {
    $stmt_check_user->bind_result($fullName, $phoneNumber, $ksgStaffOrParticipantOrVisitor);
    $stmt_check_user->fetch();

    // Close the statement for checking user before proceeding to the next query
    $stmt_check_user->close();

    // Check if the user has already logged in today
    $sql_check_login = "SELECT COUNT(*) as count FROM ld WHERE idNumber = ? AND DATE(arrivalDateTime) = ?";
    $stmt_check_login = $conn->prepare($sql_check_login);
    $stmt_check_login->bind_param("ss", $idNumber, $currentDate);
    $stmt_check_login->execute();
    $stmt_check_login->bind_result($loginCount);
    $stmt_check_login->fetch();
    $stmt_check_login->close();

    if ($loginCount > 0) {
        // User has already logged in today
        echo "<script>alert('You have already logged in today.');</script>";
        echo "<script>window.location.href = 'loginHTML.php';</script>";
    } else {
        // Insert data into ld table
        $sql_login = "INSERT INTO ld (idNumber, fullName, MeansQuestion, phoneNumber, motorNumber, passengerQuestion, passengerNumber, arrivalDateTime, campus) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt_login = $conn->prepare($sql_login);
        if ($stmt_login === false) {
            die("Prepare failed: " . htmlspecialchars($conn->error));
        }

        $stmt_login->bind_param("sssssssss", $idNumber, $fullName, $MeansQuestion, $phoneNumber, $motorNumber, $passengersQuestion, $passengerNumber, $arrivalDateTime, $campus);

        if ($stmt_login->execute()) {
            echo "<script>alert('Welcome $fullName. You have logged in for the day.');</script>";
            echo "<script>window.location.href = 'loginHTML.php';</script>";

            // If MeansQuestion is "yes", insert into the md table
            if ($MeansQuestion === 'yes') {
                $sql_insert_md = "INSERT INTO md (arrivalDateTime, motorNumber, fullName, phoneNumber, ksgStaffOrParticipantOrVisitor, campus) VALUES (?, ?, ?, ?, ?, ?)";
                $stmt_insert_md = $conn->prepare($sql_insert_md);
                if ($stmt_insert_md === false) {
                    die("Prepare failed: " . htmlspecialchars($conn->error));
                }
                $stmt_insert_md->bind_param("ssssss", $arrivalDateTime, $motorNumber, $fullName, $phoneNumber, $ksgStaffOrParticipantOrVisitor, $campus);
                
                if (!$stmt_insert_md->execute()) {
                    echo "Error: " . $stmt_insert_md->error;
                }

                $stmt_insert_md->close();
            }

        } else {
            echo "Error: " . $stmt_login->error;
        }

        $stmt_login->close();
    }
} else {
    echo "<script>alert('ID not found. Please register first.');</script>";
    echo "<script>window.location.href = 'index.html';</script>";
    $stmt_check_user->close(); // Close the statement here as well
}

$conn->close();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <script>
        var encodedExpirationTime = "<?php echo $encodedExpirationTime; ?>";
    </script>
    <script src="Update_fnObs.js"></script>
</body>
</html>
