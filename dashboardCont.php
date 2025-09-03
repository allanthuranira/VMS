<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: adminLogin.html");
    exit();
}

include 'db.php'; // Database connection

// Campus filter
$campus = isset($_GET['campus']) ? $_GET['campus'] : '';

// === LOGIN DETAILS (ld table) ===
if ($campus !== '') {
    $logInQuery = $conn->prepare("SELECT * FROM ld WHERE campus = ? ORDER BY id DESC");
    $logInQuery->bind_param("s", $campus);
    $logInQuery->execute();
    $logInResult = $logInQuery->get_result();
} else {
    $logInResult = $conn->query("SELECT * FROM ld ORDER BY id DESC");
}


// === GENERAL REGISTRATION (ksggd + ld combined) ===
$generalQuery = "
    SELECT * FROM (
        SELECT 
            ksggd.id AS combined_id,
            ksggd.fullName AS fullName,
            ksggd.idNumber AS idNumber,
            ksggd.phoneNumber AS phoneNumber,
            ksggd.arrivalDateTime AS arrivalDateTime,
            ksggd.MeansQuestion AS MeansQuestion,
            md.motorNumber AS motorNumber,
            NULL AS passengerNumber,
            NULL AS passengerQuestion,
            ksggd.ksgStaffOrParticipantOrVisitor AS ksgStaffOrParticipantOrVisitor,
            ksggd.campus AS campus,
            'ksggd' AS source_table
        FROM ksggd
        LEFT JOIN md ON ksggd.idNumber = md.idNumber
        WHERE ksggd.idNumber IS NOT NULL AND ksggd.idNumber <> ''
        
        UNION ALL
        
        SELECT 
            ld.id AS combined_id,
            ld.fullName AS fullName,
            ld.idNumber AS idNumber,
            ld.phoneNumber AS phoneNumber,
            ld.arrivalDateTime AS arrivalDateTime,
            ld.MeansQuestion AS MeansQuestion,
            md.motorNumber AS motorNumber,
            ld.passengerNumber AS passengerNumber,
            ld.passengerQuestion AS passengerQuestion,
            ld.ksgStaffOrParticipantOrVisitor AS ksgStaffOrParticipantOrVisitor,
            ld.campus AS campus,
            'ld' AS source_table
        FROM ld
        LEFT JOIN md ON ld.idNumber = md.idNumber
        WHERE ld.idNumber IS NOT NULL AND ld.idNumber <> ''
    ) AS combined
";

// Apply campus filter
if ($campus !== '') {
    $generalQuery .= " WHERE campus = ? ";
}
$generalQuery .= " ORDER BY combined.arrivalDateTime DESC, combined_id DESC";

if ($campus !== '') {
    $stmtGeneral = $conn->prepare($generalQuery);
    $stmtGeneral->bind_param("s", $campus);
    $stmtGeneral->execute();
    $generalResult = $stmtGeneral->get_result();
} else {
    $generalResult = $conn->query($generalQuery);
}


// === KSG STAFF ===
if ($campus !== '') {
    $staffQuery = $conn->prepare("SELECT * FROM ksgstaff WHERE campus = ? ORDER BY id DESC");
    $staffQuery->bind_param("s", $campus);
    $staffQuery->execute();
    $staffResult = $staffQuery->get_result();
} else {
    $staffResult = $conn->query("SELECT * FROM ksgstaff ORDER BY id DESC");
}


// === PARTICIPANTS ===
if ($campus !== '') {
    $participantQuery = $conn->prepare("SELECT * FROM participants WHERE campus = ? ORDER BY id DESC");
    $participantQuery->bind_param("s", $campus);
    $participantQuery->execute();
    $participantResult = $participantQuery->get_result();
} else {
    $participantResult = $conn->query("SELECT * FROM participants ORDER BY id DESC");
}


// === VISITORS ===
if ($campus !== '') {
    $visitorQuery = $conn->prepare("SELECT * FROM visitors WHERE campus = ? ORDER BY id DESC");
    $visitorQuery->bind_param("s", $campus);
    $visitorQuery->execute();
    $visitorResult = $visitorQuery->get_result();
} else {
    $visitorResult = $conn->query("SELECT * FROM visitors ORDER BY id DESC");
}


// === KSG VEHICLE CHECK-IN ===
if ($campus !== '') {
    $ksgVehicleCheckInQuery = $conn->prepare("SELECT * FROM ksgvehicle_checkin WHERE campus = ? ORDER BY check_in_datetime DESC");
    $ksgVehicleCheckInQuery->bind_param("s", $campus);
    $ksgVehicleCheckInQuery->execute();
    $ksgvehicle_checkInResult = $ksgVehicleCheckInQuery->get_result();
} else {
    $ksgvehicle_checkInResult = $conn->query("SELECT * FROM ksgvehicle_checkin ORDER BY check_in_datetime DESC");
}

// === Session Expiration Time ===
$expirationTime = time() + 3000000; // current time + seconds
$encodedExpirationTime = base64_encode($expirationTime);

// === Force Download CSV Function ===
function forceDownloadCSV($data, $filename) {
    header("Content-Type: text/csv");
    header("Content-Disposition: attachment; filename=$filename.csv");
    header("Pragma: no-cache");
    header("Expires: 0");

    $output = fopen("php://output", "w");
    $headerDisplayed = false;
    foreach ($data as $row) {
        if (!$headerDisplayed) {
            fputcsv($output, array_keys($row));
            $headerDisplayed = true;
        }
        $row['idNumber'] = '"' . $row['idNumber'] . '"';
        $row['phoneNumber'] = '"' . $row['phoneNumber'] . '"';
        fputcsv($output, $row);
    }
    fclose($output);
    exit;
}

// === CSV Downloads ===
if (isset($_GET['download'])) {
    switch ($_GET['download']) {
        case 'general':
            forceDownloadCSV($generalResult->fetch_all(MYSQLI_ASSOC), 'General_Details');
            break;
        case 'staff':
            forceDownloadCSV($staffResult->fetch_all(MYSQLI_ASSOC), 'KSG_Staff_Details');
            break;
        case 'participants':
            forceDownloadCSV($participantResult->fetch_all(MYSQLI_ASSOC), 'Participants_Details');
            break;
        case 'visitors':
            forceDownloadCSV($visitorResult->fetch_all(MYSQLI_ASSOC), 'Visitors_Details');
            break;
        case 'ksgvehicle_checkin':
            forceDownloadCSV($ksgvehicle_checkInResult->fetch_all(MYSQLI_ASSOC), 'KSG_Vehicles_Check_IN_Details');
            break;
    }
}

$conn->close();
?>
