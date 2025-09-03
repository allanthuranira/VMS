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

// Sanitize input
$fullName = htmlspecialchars($_POST['fullName']);
$idNumber = htmlspecialchars($_POST['idNumber']);
$phoneNumber = htmlspecialchars($_POST['phoneNumber']);
$arrivalDateTime = htmlspecialchars($_POST['arrivalDateTime']);
$MeansQuestion = htmlspecialchars($_POST['MeansQuestion']);
$ksgStaffOrParticipantOrVisitor = htmlspecialchars($_POST['ksgStaffOrParticipantOrVisitor']);
$campus = htmlspecialchars($_POST['campus']);


// Prepare and bind
$stmt_ksggd = $conn->prepare("INSERT INTO ksggd (fullName, idNumber, phoneNumber, arrivalDateTime, MeansQuestion, motorNumber, ksgStaffOrParticipantOrVisitor,campus) VALUES (?, ?, ?, ?, ?, ?, ?,?)");


$stmt_ksggd->bind_param("ssssssss", $fullName, $idNumber, $phoneNumber, $arrivalDateTime, $MeansQuestion, $motorNumber, $ksgStaffOrParticipantOrVisitor,$campus);

// Check if the user is already registered
$sql_check_user = "SELECT idNumber FROM ksggd WHERE idNumber = ?";
$stmt_check_user = $conn->prepare($sql_check_user);
$stmt_check_user->bind_param("s", $idNumber);
$stmt_check_user->execute();
$stmt_check_user->store_result();
if ($stmt_check_user->num_rows > 0) {
    // User is already registered, redirect to login page
    echo "<script>alert('You are already registered. Please login.');</script>";
    echo "<script>window.location.href = 'loginHTML.php';</script>";
    exit(); // Stop further execution
}
$stmt_check_user->close();

// Get motorNumber if MeansQuestion is 'yes'
$motorNumber = ($MeansQuestion == 'yes') ? htmlspecialchars($_POST['motorNumber']) : null;


if ($stmt_ksggd->execute() === TRUE) {
    if ($MeansQuestion == 'yes') {
        $stmt_md = $conn->prepare("INSERT INTO md (arrivalDateTime, motorNumber, fullName, phoneNumber, ksgStaffOrParticipantOrVisitor,idNumber,campus) VALUES (?, ?, ?, ?, ?,?,?)");
        if (!$stmt_md) {
            die('Error in preparing Motor Details - md statement: ' . $conn->error);
        }
        $stmt_md->bind_param("sssssss", $arrivalDateTime, $motorNumber, $fullName, $phoneNumber, $ksgStaffOrParticipantOrVisitor, $idNumber,$campus);
        $stmt_md->execute();
    } 

    if ($ksgStaffOrParticipantOrVisitor == 'ksgStaff') {
        $stmt_ksgstaff = $conn->prepare("INSERT INTO ksgstaff (fullName, idNumber,campus) VALUES (?, ?, ?)");
        if (!$stmt_ksgstaff) {
            die('Error in preparing KSGSTAFF statement: ' . $conn->error);
        }
        $stmt_ksgstaff->bind_param("sss", $fullName, $idNumber,$campus);
        $stmt_ksgstaff->execute();
    } elseif ($ksgStaffOrParticipantOrVisitor == 'participant') {
        $courseName = htmlspecialchars($_POST['courseName']);
        $stmt_participant = $conn->prepare("INSERT INTO participants (fullName, idNumber, arrivalDateTime, courseName,campus) VALUES (?, ?, ?, ?,?)");
        if (!$stmt_participant) {
            die('Error in preparing PARTICIPANT statement: ' . $conn->error);
        }
        $stmt_participant->bind_param("sssss", $fullName, $idNumber, $arrivalDateTime, $courseName,$campus);
        $stmt_participant->execute();
    } elseif ($ksgStaffOrParticipantOrVisitor == 'visitor') {
        $officeVisiting = htmlspecialchars($_POST['officeVisiting']);
        $officerName = htmlspecialchars($_POST['officerName']);
        $visitorPurpose = htmlspecialchars($_POST['visitorPurpose']);
        $stmt_visitor = $conn->prepare("INSERT INTO visitors (fullName, idNumber, arrivalDateTime, officeVisiting, officerName, visitorPurpose,campus) VALUES (?, ?, ?, ?, ?, ?,?)");
        if (!$stmt_visitor) {
            die('Error in preparing VISITOR statement: ' . $conn->error);
        }
        $stmt_visitor->bind_param("sssssss", $fullName, $idNumber, $arrivalDateTime, $officeVisiting, $officerName, $visitorPurpose,$campus);
        $stmt_visitor->execute();
    }

    // Format the arrival date and time for better readability
    $formattedDateTime = (new DateTime($arrivalDateTime))->format('F j, Y, g:i a');

    // Log in the user (for simplicity, we start a session and store user details)
    session_start();
    $_SESSION['idNumber'] = $idNumber;
    $_SESSION['fullName'] = $fullName;
    $_SESSION['arrivalDateTime'] = $arrivalDateTime;

    // Extract the first name from the full name
    $firstName = explode(' ', $fullName)[0];

    // Print user details with KSG logo
    echo '<!DOCTYPE html>';
    echo '<html lang="en">';
    echo '<head>';
    echo '<meta charset="UTF-8">';
    echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
    echo '<title>Registration Successful</title>';
    echo '<link rel="icon" href="images/KSG Logo.png" type="image/x-icon">';
    echo '<style>';
    echo 'body { font-family: Arial, sans-serif; margin: 0; padding: 20px; }';
    echo '.container { position: relative; padding: 20px; max-width: 600px; margin: auto; border: 1px solid #ccc; border-radius: 10px; background-color: #f9f9f9; }';
    echo 'h1 { color: #333; }';
    echo 'p { margin: 5px 0; color: #555; }';
    echo 'img { position: absolute; left: 80%; transform: translateX(-50%); top: 40px; width: 100px; height: auto; }';
    echo '.button { margin: 20px 10px; padding: 10px 20px; font-size: 16px; border: none; border-radius: 5px; cursor: pointer; }';
    echo '.button-print { background-color: #4CAF50; color: white; }';
    echo '.button-back { background-color: #f44336; color: white; }';
    echo '@media print {';
    echo '  .button { display: none; }';
    echo '}';
    echo '</style>';
    echo '</head>';
    echo '<body>';
    echo '<div class="container">';
    echo '<div style="text-align: left;">';
    echo "<h1>Registration Successful</h1>";
    echo "<p><strong>Full Name:</strong> $fullName</p>";
    echo "<p><strong>ID Number:</strong> $idNumber</p>";
    echo "<p><strong>Phone Number:</strong> $phoneNumber</p>";
    echo "<p><strong>Arrival Date and Time:</strong> $formattedDateTime</p>";
    echo "<p><strong>Campus:</strong> $campus</p>";
    echo "<p><strong>Driving/Riding Motorcycle:</strong> " . ($MeansQuestion == 'yes' ? 'Yes' : 'No') . "</p>";
    if ($MeansQuestion == 'yes') {
        echo "<p><strong>Motor Number:</strong> $motorNumber</p>";
    } elseif ($MeansQuestion == 'no') {
        echo "<p><i> Did not come with car or motorcycle</i> </p>";
    }

    echo "<p><strong>User Type:</strong> " . ucfirst($ksgStaffOrParticipantOrVisitor) . "</p>";
    if ($ksgStaffOrParticipantOrVisitor == 'ksgStaff') {
        echo "<p>Welcome <strong>$firstName</strong>.Enjoy your day!</p>";
    } elseif ($ksgStaffOrParticipantOrVisitor == 'participant') {
        echo "<p><strong>Course Name:</strong> $courseName</p>";
    } elseif ($ksgStaffOrParticipantOrVisitor == 'visitor') {
        echo "<p><strong>Office Visiting:</strong> $officeVisiting</p>";
        echo "<p><strong>Officer Name:</strong> $officerName</p>";
        echo "<p><strong>Purpose of Visit:</strong> $visitorPurpose</p><br><br>";
        echo '__________________________________________<br>';
        echo '<i><p>Signature/ Stamp</p></i>';
    }

    echo '</div>';
    echo '<img src="images/KSG Logo.png" alt="KSG Logo">';
    echo '<div style="text-align: center; margin-top: 20px;">';
    echo '<button class="button button-print" onclick="window.print()">Print this page</button>';
    echo '<button class="button button-back" onclick="window.location.href=\'index.php\'">Go back to Registration</button>';
    echo '</div>';
    echo '</div>';
    echo '</body>';
    echo '</html>';
} else {
    echo "Error: " . $stmt_ksggd->error;
}

$stmt_ksggd->close();
$conn->close();
?>
