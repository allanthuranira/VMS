<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: adminLogin.html");
    exit();
}

include 'db.php'; // Assuming this file contains your database connection details

// Fetch all data from the md table
$vehicleQuery = "SELECT * FROM md ORDER BY id DESC";
$vehicleResult = $conn->query($vehicleQuery);

// Fetch all data from the ksggd table
$generalQuery = "SELECT * FROM ksggd ORDER BY id DESC";
$generalResult = $conn->query($generalQuery);

// Fetch all data from the ksgstaff table
$staffQuery = "SELECT * FROM ksgstaff ORDER BY id DESC";
$staffResult = $conn->query($staffQuery);

// Fetch all data from the partcipants table
$participantQuery = "SELECT * FROM participants ORDER BY id DESC";
$participantResult = $conn->query($participantQuery);


// Fetch all data from the partcipants table
$visitorQuery = "SELECT * FROM visitors ORDER BY id DESC";
$visitorResult = $conn->query($visitorQuery);

// Fetch all data from the KSG Vehicle check IN table
$ksgVehicleCheckInQuery = "SELECT * FROM ksgvehicle_checkin ORDER BY id DESC";
$ksgvehicle_checkInResult = $conn->query($ksgVehicleCheckInQuery);

// Set the TIME
$expirationTime = time() + 3000000; // current time +  seconds
// Encode the expiration time using base64
$encodedExpirationTime = base64_encode($expirationTime);

// Function to force download as CSV
function forceDownloadCSV($data, $filename) {
    // Output CSV headers
    header("Content-Type: text/csv");
    header("Content-Disposition: attachment; filename=$filename.csv");
    header("Pragma: no-cache");
    header("Expires: 0");

    // Output CSV data
    $output = fopen("php://output", "w");
    $headerDisplayed = false;
    foreach ($data as $row) {
        if (!$headerDisplayed) {
            fputcsv($output, array_keys($row));
            $headerDisplayed = true;
        }
        // Enclose idNumber and phoneNumber in double quotes
        $row['idNumber'] = '"' . $row['idNumber'] . '"';
        $row['phoneNumber'] = '"' . $row['phoneNumber'] . '"';
        fputcsv($output, $row);
    }
    fclose($output);
    exit;
}

// Handle CSV download request
if (isset($_GET['download']) && $_GET['download'] == 'vehicle') {
    forceDownloadCSV($vehicleResult->fetch_all(MYSQLI_ASSOC), 'Vehicle_Details');
}

if (isset($_GET['download']) && $_GET['download'] == 'general') {
    forceDownloadCSV($generalResult->fetch_all(MYSQLI_ASSOC), 'General_Details');
}

if (isset($_GET['download']) && $_GET['download'] == 'staff') {
    forceDownloadCSV($staffResult->fetch_all(MYSQLI_ASSOC), 'KSG_Staff_Details');
}

if (isset($_GET['download']) && $_GET['download'] == 'participants') {
    forceDownloadCSV($participantResult->fetch_all(MYSQLI_ASSOC), 'Participants_Details');
}

if (isset($_GET['download']) && $_GET['download'] == 'visitors') {
    forceDownloadCSV($visitorResult->fetch_all(MYSQLI_ASSOC), 'visitors_Details');
}

if (isset($_GET['download']) && $_GET['download'] == 'ksgvehicle_checkin') {
    forceDownloadCSV($ksgvehicle_checkInResult->fetch_all(MYSQLI_ASSOC), 'KSG_Vehicles_Check_IN_Details');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manager's Dashboard</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" href="images/KSG Logo.png" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="css/dashStyles.css">
    <style>
        body {
            background-color: #f5f5f5;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            min-height: 100vh;
            padding: 20px;
        }
        .inner {
            width: 100%;
            max-width: 800px;
            background: white;
            padding: 20px;
            box-shadow: -20px 20px 20px rgba(170, 212, 0, 0.9);
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        
    </style>
    <script>
        var encodedExpirationTime = "<?php echo $encodedExpirationTime; ?>";
    </script>
    <script src="Update_fnObs.js"></script>

    <script>
        // Function to handle logout
        function logout() {
            window.location.href = 'adminLogin.html';
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Ensure the function is attached after the DOM is loaded
            document.getElementById('tableSelector').addEventListener('change', showTable);
        });
    </script>
</head>
<body>
    <div class="inner">
        <h1 style="font-size: 28px; color: #654321; margin-bottom: 24px;">Manager's Dashboard</h1>
        
        <!-- Dropdown to select table -->
        <div class="select-container">
            <label for="tableSelector">Select the Table You want to View below</label>
            <select id="tableSelector">
                <option value="">SELECT TABLE </option>
                <option value="vehicleTable">Guest Vehicle Details</option>
                <option value="generalTable">General Registration Details</option>
                <option value="staffTable">KSG Staff Details</option>
                <option value="participantTable">Participant's Details</option>
                <option value="visitorTable">Visitor's Details</option>
                <option value="ksgVehicleCheckInTable">KSG Vehicles Details</option>
                <!-- Add more options for other tables here -->
            </select>
        </div>

        <!-- Vehicle Details Table -->
        <div class="table" id="vehicleTable" style="display: none;">
            <h2>Vehicle Details</h2>
            <div class="search-container">
                <div class="search-form">
                    <input type="text" id="searchTermVehicle" placeholder="Search by Number Plate">
                </div>
            </div>

            <div id="content">
                <table id="vehicleDataTable">
                    <thead>
                        <tr>
                            <th>Time and Date of Arrival</th>
                            <th>Number Plate</th>
                            <th>Full Name</th>
                            <th>Phone Number</th>
                            <th>Type of Visitor</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = $vehicleResult->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo $row['arrivalDateTime']; ?></td>
                            <td><?php echo $row['motorNumber']; ?></td>
                            <td><?php echo $row['fullName']; ?></td>
                            <td><?php echo $row['phoneNumber']; ?></td>
                            <td><?php echo $row['ksgStaffOrParticipantOrVisitor']; ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <div class="button-container">
                <button class="download-button" id="downloadVehiclePDF">Download as PDF</button>
                <button class="download-button" id="downloadVehicleImage">Download as Image</button>
            </div>
        </div>

        <!-- General Registration Details Table -->
        <div class="table" id="generalTable">
            <h2>General Registration Details</h2>
            <div class="search-container">
                <div class="search-form">
                    <input type="text" id="searchTermGeneral" placeholder="Search by ID Number">
                </div>
            </div>

            <div id="contentGeneral">
                <table id="generalDataTable">
                    <thead>
                        <tr>
                            <th>ID Number</th>
                            <th>Full Name</th>
                            <th>Phone Number</th>
                            <th>Registration Date & Time</th>
                            <th>Did the Guest come Driving</th>
                            <th>Number Plate</th>
                            <th>KSG Staff or Partcipant or Visitor</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = $generalResult->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo $row['idNumber']; ?></td>
                            <td><?php echo $row['fullName']; ?></td>
                            <td><?php echo $row['phoneNumber']; ?></td>
                            <td><?php echo $row['arrivalDateTime']; ?></td>
                            <td><?php echo $row['MeansQuestion']; ?></td>
                            <td><?php echo $row['motorNumber']; ?></td>
                            <td><?php echo $row['ksgStaffOrParticipantOrVisitor']; ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <div class="button-container">
                <button class="download-button" id="downloadGeneralPDF">Download as PDF</button>
                <button class="download-button" id="downloadGeneralExcel">Download as Excel</button>
            </div>
        </div>

        <!-- Add similar divs for other tables like staffTable, participantTable, visitorTable -->
        <div class="table" id="staffTable">
            <h2>KSG Staff Details</h2>
            <div class="search-container">
                <div class="search-form">
                    <input type="text" id="searchTermStaff" placeholder="Search by ID Number">
                </div>
            </div>
        <div id="contentStaff">
            <table id="staffDataTable">
                <thead>
                <tr>
                    <th>Full Name</th>
                    <th>Personal Number/ID Number</th>
                    
                </tr>
                </thead>
                <tbody>
                <?php while($row = $staffResult->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo $row['fullName']; ?></td>
                            <td><?php echo $row['idNumber']; ?></td>
                            
                            
                        </tr>
                        <?php } ?>
                </tbody>
            </table>
        </div>
            <div class="button-container">
                <button class="download-button" id="downloadStaffPDF">Download as PDF</button>
                <button class="download-button" id="downloadStaffExcel">Download as Excel</button>
            </div>
        </div>

        <div class="table" id="participantTable">
            <h2>Participant's Details</h2>
            <!-- Add the content for Participant's Details table here -->
            
            <div class="search-container">
                <div class="search-form">
                    <input type="text" id="searchTermParticipant" placeholder="Search by ID Number">
                </div>
            </div>
        <div id="contentParticipant">
            <table id="participantDataTable">
                <thead>
                <tr>
                    <th>Full Name</th>
                    <th>ID Number</th>
                    <th>Arrival Date & Time</th>
                    <th>Course Name</th>
                </tr>
                </thead>
                <tbody>
                <?php while($row = $participantResult->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo $row['fullName']; ?></td>
                            <td><?php echo $row['idNumber']; ?></td>
                            <td><?php echo $row['arrivalDateTime']; ?></td>
                            <td><?php echo $row['courseName']; ?></td>
                            
                            
                        </tr>
                        <?php } ?>
                </tbody>
            </table>
        </div>
        <div class="button-container">
            <button class="download-button" id="downloadParticipantPDF">Download as PDF</button>
            <button class="download-button" id="downloadParticipantExcel">Download as Excel</button>
            </div>
        </div>
                
        <!-- Visitor's Details Table -->
        <div class="table" id="visitorTable">
            <h2>Visitor's Details</h2>
            <div class="search-container">
                <div class="search-form">
                    <input type="text" id="searchTermVisitor" placeholder="Search by ID Number">
                </div>
            </div>
        <div id="contentVisitor">
            <table id="visitorDataTable">
                <thead>
                <tr>
                    <th>Full Name</th>
                    <th>ID Number</th>
                    <th>Arrival Date & Time</th>
                    <th>Office Visiting</th>
                    <th>Officer Name</th>
                    <th>Visitor Purpose</th>
                </tr>
                </thead>
                <tbody>
                <?php while($row = $visitorResult->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo $row['fullName']; ?></td>
                            <td><?php echo $row['idNumber']; ?></td>
                            <td><?php echo $row['arrivalDateTime']; ?></td>
                            <td><?php echo $row['officeVisiting']; ?></td>
                            <td><?php echo $row['officerName']; ?></td>
                            <td><?php echo $row['visitorPurpose']; ?></td>
                        </tr>
                        <?php } ?>
                </tbody>
            </table>
        </div>
            <div class="button-container">
                <button class="download-button" id="downloadVisitorPDF">Download as PDF</button>
                <button class="download-button" id="downloadVisitorExcel">Download as Excel</button>
            </div>
        </div>
        <!-- KSG Vehicle Check IN Details Table -->
        <div class="table" id="ksgVehicleCheckInTable">
            <h2>KSG Vehicles Movement Details</h2>
            <div class="search-container">
                <div class="search-form">
                    <input type="text" id="searchTermKSGVehicle" placeholder="Search by Number Plate">
                </div>
            </div>
        <div id="contentKSGVehicles">
            <table id="ksgVehicleDataTable">
                <thead>
                <tr>
                    <th>Number Plate</th>
                    <th>Driver Name</th>
                    <th>Check OUT Date & Time</th>
                    <th>Check IN Date & Time</th>
                    <th>Authorized BY:</th>
                    
                </tr>
                </thead>
                <tbody>
                <?php while($row = $ksgvehicle_checkInResult->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo $row['car_number_plate']; ?></td>
                            <td><?php echo $row['driver_name']; ?></td>
                            <td><?php echo $row['check_out_datetime']; ?></td>
                            <td><?php echo $row['check_in_datetime']; ?></td>
                            <td><?php echo $row['authorized_by']; ?></td>
                        </tr>
                        <?php } ?>
                </tbody>
            </table>
        </div>
            <div class="button-container">
                <button class="download-button" id="downloadKSGVehiclesPDF">Download as PDF</button>
                <button class="download-button" id="downloadKSGVehiclesExcel">Download as Excel</button>
            </div>
        </div>
        
        </div>
        <button class="logout-button" onclick="logout()">Log Out</button>
                    
    <script src="js/html2canvas.min.js"></script>
    <script src="js/jspdf.umd.min.js"></script>
    <script>
        window.addEventListener('load', function () {
    function downloadPDF(contentId, filename) {
        const { jsPDF } = window.jspdf;
        const content = document.getElementById(contentId);

        html2canvas(content).then(canvas => {
            const imgData = canvas.toDataURL('image/png');
            const pdf = new jsPDF('p', 'mm', 'a4');
            
            const imgProps = pdf.getImageProperties(imgData);
            const pdfWidth = pdf.internal.pageSize.getWidth();
            const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;
            
            pdf.addImage(imgData, 'PNG', 0, 0, pdfWidth, pdfHeight);
            pdf.save(filename);
        });
    }

    function downloadImage(contentId, filename) {
        const content = document.getElementById(contentId);
        html2canvas(content).then(function (canvas) {
            const link = document.createElement('a');
            link.href = canvas.toDataURL('image/png');
            link.download = filename;
            link.click();
        });
    }

    function downloadCSV(contentId, filename) {
        const content = document.getElementById(contentId);
        const table = content.querySelector('table');
        const rows = table.querySelectorAll('tr');

        let csvContent = '';

        rows.forEach(row => {
            const cols = row.querySelectorAll('td, th');
            let rowContent = '';
            cols.forEach(col => {
                rowContent += '"' + col.textContent.trim().replace(/"/g, '""') + '",';
            });
            csvContent += rowContent.slice(0, -1) + '\n'; // Remove last comma and add new line
        });

        const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
        const link = document.createElement('a');
        const url = URL.createObjectURL(blob);
        link.href = url;
        link.setAttribute('download', filename);
        link.style.display = 'none';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }

    document.getElementById('downloadVehiclePDF').onclick = () => downloadPDF('content', 'Car_Number_plates.pdf');
    document.getElementById('downloadVehicleImage').onclick = () => downloadImage('content', 'Car_Number_plates.png');
    document.getElementById('downloadGeneralPDF').onclick = () => downloadPDF('contentGeneral', 'General_Registration_Details.pdf');
    document.getElementById('downloadGeneralExcel').onclick = () => downloadCSV('contentGeneral', 'General_Registration_Details.csv');
    document.getElementById('downloadStaffPDF').onclick = () => downloadPDF('contentStaff', 'Staff_Details.pdf');
    document.getElementById('downloadStaffExcel').onclick = () => downloadCSV('contentStaff', 'Staff_Details.csv');
    document.getElementById('downloadParticipantPDF').onclick = () => downloadPDF('contentParticipant', 'Participants_Details.pdf');
    document.getElementById('downloadParticipantExcel').onclick = () => downloadCSV('contentParticipant', 'Participants_Details.csv');
    document.getElementById('downloadVisitorPDF').onclick = () => downloadPDF('contentVisitor', 'Visitors_Details.pdf');
    document.getElementById('downloadVisitorExcel').onclick = () => downloadCSV('contentVisitor', 'Visitors_Details.csv');
    document.getElementById('downloadKSGVehiclesPDF').onclick = () => downloadPDF('contentKSGVehicles', 'KSG_Vehicles_Check_IN_Details.pdf');
    document.getElementById('downloadKSGVehiclesExcel').onclick = () => downloadCSV('contentKSGVehicles', 'KSG_Vehicles_Check_IN_Details.csv');
    

    document.getElementById('searchTermVehicle').addEventListener('input', function () {
        const searchTerm = this.value.toLowerCase();
        const rows = document.querySelectorAll('#vehicleDataTable tbody tr');

        rows.forEach(row => {
            const motorNumber = row.cells[1].textContent.toLowerCase();
            if (motorNumber.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });

    document.getElementById('searchTermGeneral').addEventListener('input', function () {
        const searchTerm = this.value.toLowerCase();
        const rows = document.querySelectorAll('#generalDataTable tbody tr');

        rows.forEach(row => {
            const idNumber = row.cells[0].textContent.toLowerCase();
            if (idNumber.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });

    document.getElementById('searchTermStaff').addEventListener('input', function () {
        const searchTerm = this.value.toLowerCase();
        const rows = document.querySelectorAll('#staffDataTable tbody tr');

        rows.forEach(row => {
            const idNumber = row.cells[1].textContent.toLowerCase();
            if (idNumber.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });

    document.getElementById('searchTermParticipant').addEventListener('input', function () {
        const searchTerm = this.value.toLowerCase();
        const rows = document.querySelectorAll('#participantDataTable tbody tr');

        rows.forEach(row => {
            const idNumber = row.cells[1].textContent.toLowerCase();
            if (idNumber.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });

    document.getElementById('searchTermVisitor').addEventListener('input', function () {
        const searchTerm = this.value.toLowerCase();
        const rows = document.querySelectorAll('#visitorDataTable tbody tr');

        rows.forEach(row => {
            const idNumber = row.cells[1].textContent.toLowerCase();
            if (idNumber.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });

    document.getElementById('searchTermKSGVehicle').addEventListener('input', function () {
        const searchTerm = this.value.toLowerCase();
        const rows = document.querySelectorAll('#ksgVehicleDataTable tbody tr');

        rows.forEach(row => {
            const idNumber = row.cells[0].textContent.toLowerCase();
            if (idNumber.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });


    let inactivityTime = function () {
        let time;
        window.onload = resetTimer;
        window.onmousemove = resetTimer;
        window.onmousedown = resetTimer;
        window.ontouchstart = resetTimer;
        window.onclick = resetTimer;
        window.onkeypress = resetTimer;

        function logout() {
            window.location.href = 'adminLogin.html';
        }

        function resetTimer() {
            clearTimeout(time);
            time = setTimeout(logout, 600000); // 10 minutes in milliseconds
        }
    };

    inactivityTime();
});

// Function to show the selected table
function showTable() {
    console.log("showTable function called"); // Debug log
    const selectedTable = document.getElementById('tableSelector').value;
    console.log("Selected Table:", selectedTable); // Debug log
    const tables = document.querySelectorAll('.table');

    tables.forEach(table => {
        table.style.display = 'none';
    });

    if (selectedTable) {
        const tableToShow = document.getElementById(selectedTable);
        if (tableToShow) {
            tableToShow.style.display = 'block';
        } else {
            console.log("No table found with ID:", selectedTable); // Debug log
        }
    }
}

    </script>
</body>
</html>

<?php
$conn->close();
?>
