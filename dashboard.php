<?php
include 'db.php';

// get selected campus
$campus = isset($_GET['campus']) ? $_GET['campus'] : '';

// Get selected date or today
$selectedDate = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');
$startOfDay = $selectedDate . " 00:00:00";
$endOfDay   = $selectedDate . " 23:59:59";

// Get current month range
$startOfMonth = date('Y-m-01 00:00:00', strtotime($selectedDate));
$endOfMonth   = date('Y-m-t 23:59:59', strtotime($selectedDate));

// === DAILY UNIQUE PARTICIPANTS (participants + ld) ===
if ($campus !== '') {
    $stmt1 = $conn->prepare("
        SELECT COUNT(*) AS daily_count FROM (
            SELECT DISTINCT idNumber 
            FROM (
                SELECT idNumber, DATE(arrivalDateTime) as login_date
                FROM participants
                WHERE arrivalDateTime BETWEEN ? AND ? AND campus = ?
                
                UNION
                SELECT idNumber, DATE(arrivalDateTime) as login_date
                FROM ld
                WHERE arrivalDateTime BETWEEN ? AND ? AND campus = ?
            ) as combined
        ) as daily_unique
    ");
    $stmt1->bind_param("ssssss", $startOfDay, $endOfDay, $campus, $startOfDay, $endOfDay, $campus);
} else {
    $stmt1 = $conn->prepare("
        SELECT COUNT(*) AS daily_count FROM (
            SELECT DISTINCT idNumber 
            FROM (
                SELECT idNumber, DATE(arrivalDateTime) as login_date
                FROM participants
                WHERE arrivalDateTime BETWEEN ? AND ?
                
                UNION
                SELECT idNumber, DATE(arrivalDateTime) as login_date
                FROM ld
                WHERE arrivalDateTime BETWEEN ? AND ?
            ) as combined
        ) as daily_unique
    ");
    $stmt1->bind_param("ssss", $startOfDay, $endOfDay, $startOfDay, $endOfDay);
}
$stmt1->execute();
$dailyCount = $stmt1->get_result()->fetch_assoc()['daily_count'] ?? 0;

// === MONTHLY UNIQUE PARTICIPANTS ===
if ($campus !== '') {
    $stmt2 = $conn->prepare("
        SELECT COUNT(*) AS monthly_count FROM (
            SELECT idNumber, login_date FROM (
                SELECT idNumber, DATE(arrivalDateTime) as login_date
                FROM participants
                WHERE arrivalDateTime BETWEEN ? AND ? AND campus = ?
                
                UNION
                SELECT idNumber, DATE(arrivalDateTime) as login_date
                FROM ld
                WHERE arrivalDateTime BETWEEN ? AND ? AND campus = ?
            ) as all_logins
            GROUP BY idNumber, login_date
        ) as monthly_unique
    ");
    $stmt2->bind_param("ssssss", $startOfMonth, $endOfMonth, $campus, $startOfMonth, $endOfMonth, $campus);
} else {
    $stmt2 = $conn->prepare("
        SELECT COUNT(*) as monthly_count FROM (
            SELECT idNumber, login_date FROM (
                SELECT idNumber, DATE(arrivalDateTime) as login_date
                FROM participants
                WHERE arrivalDateTime BETWEEN ? AND ?
                
                UNION
                SELECT idNumber, DATE(arrivalDateTime) as login_date
                FROM ld
                WHERE arrivalDateTime BETWEEN ? AND ?
            ) as all_logins
            GROUP BY idNumber, login_date
        ) as monthly_unique
    ");
    $stmt2->bind_param("ssss", $startOfMonth, $endOfMonth, $startOfMonth, $endOfMonth);
}
$stmt2->execute();
$monthlyCount = $stmt2->get_result()->fetch_assoc()['monthly_count'] ?? 0;

// === QUARTERLY RANGE CALCULATION ===
date_default_timezone_set('Africa/Nairobi');
$selected = new DateTime($selectedDate);
$month = (int) $selected->format('n');
$year = (int) $selected->format('Y');

if ($month >= 7 && $month <= 9) {
    $financialYear = $year . '/' . ($year + 1);
    $quarter = "1st Quarter";
    $start = "$year-07-01";
    $end   = "$year-09-30";
} elseif ($month >= 10 && $month <= 12) {
    $financialYear = $year . '/' . ($year + 1);
    $quarter = "2nd Quarter";
    $start = "$year-10-01";
    $end   = "$year-12-31";
} elseif ($month >= 1 && $month <= 3) {
    $financialYear = ($year - 1) . '/' . $year;
    $quarter = "3rd Quarter";
    $start = "$year-01-01";
    $end   = "$year-03-31";
} else {
    $financialYear = ($year - 1) . '/' . $year;
    $quarter = "4th Quarter";
    $start = "$year-04-01";
    $end   = "$year-06-30";
}

// === QUARTERLY UNIQUE PARTICIPANTS ===
if ($campus !== '') {
    $stmt3 = $conn->prepare("
        SELECT COUNT(*) AS quarterly_count FROM (
            SELECT idNumber, login_date FROM (
                SELECT idNumber, DATE(arrivalDateTime) as login_date
                FROM participants
                WHERE arrivalDateTime BETWEEN ? AND ? AND campus = ?
                
                UNION
                SELECT idNumber, DATE(arrivalDateTime) as login_date
                FROM ld
                WHERE arrivalDateTime BETWEEN ? AND ? AND campus = ?
            ) as all_logins
            GROUP BY idNumber, login_date
        ) as quarterly_unique
    ");
    $stmt3->bind_param("ssssss", $start, $end, $campus, $start, $end, $campus);
} else {
    $stmt3 = $conn->prepare("
        SELECT COUNT(*) as quarterly_count FROM (
            SELECT idNumber, login_date FROM (
                SELECT idNumber, DATE(arrivalDateTime) as login_date
                FROM participants
                WHERE arrivalDateTime BETWEEN ? AND ?
                
                UNION
                SELECT idNumber, DATE(arrivalDateTime) as login_date
                FROM ld
                WHERE arrivalDateTime BETWEEN ? AND ?
            ) as all_logins
            GROUP BY idNumber, login_date
        ) as quarterly_unique
    ");
    $stmt3->bind_param("ssss", $start, $end, $start, $end);
}
$stmt3->execute();
$quarterlyCount = $stmt3->get_result()->fetch_assoc()['quarterly_count'] ?? 0;

include 'dashboardCont.php';
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <script>
        var encodedExpirationTime = "<?php echo $encodedExpirationTime; ?>";
    </script>

    <script src="Update_fnObs.js"></script>
    <script src="js/html2canvas.min.js"></script>
    <script src="js/jspdf.umd.min.js"></script>
    <script src="js/tableDownloadHandlers.js"></script>
    <script src="js/searchHandlers.js"></script>
    <script src="js/inactivityLogout.js"></script>
    <script src="js/tableSelector.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.sidebar ul li').forEach(item => {
                item.addEventListener('click', function() {
                    showTableById(this.getAttribute('data-target'));
                });
            });
        });

        function showTableById(id) {
            document.querySelectorAll('.table').forEach(t => t.style.display = 'none');
            const target = document.getElementById(id);
            if (target) target.style.display = 'block';
        }

        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const icon = document.getElementById('toggleIcon');
            sidebar.classList.toggle('collapsed');

            if (sidebar.classList.contains('collapsed')) {
                icon.classList.remove('fa-angle-double-left');
                icon.classList.add('fa-angle-double-right');
            } else {
                icon.classList.remove('fa-angle-double-right');
                icon.classList.add('fa-angle-double-left');
            }
        }

        function logout() {
            alert("You clicked log out");
            window.location.href = 'adminLogin.html';
        }
    </script>
</head>
<body>

<div class="sidebar" id="sidebar">
    <div>
        <h3>Dashboard Tables</h3>
        <ul>
            <li data-target="vehicleTable">Guest Vehicle Details</li>
            <li data-target="generalTable">General Registration</li>
            <li data-target="staffTable">KSG Staff</li>
            <li data-target="participantTable">Participants</li>
            <li data-target="visitorTable">Visitors</li>
            <li data-target="ksgVehicleCheckInTable">KSG Vehicle Movement</li>
        </ul>
    </div>
    <button class="logout-button" onclick="logout()">Log Out</button>
</div>

<div class="main-content">
<style>
/* Top bar: brown background */
.top-bar {
    background-color: #7e4f09;/* brown */
    color: white;
    padding: 16px 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-bottom: 1px solid #ddd;
    position: relative;
}

/* Sidebar toggle button (inside brown bar, left) */
.top-bar .toggle-icon-container {
    position: absolute;
    left: 20px;
    top: 50%;
    transform: translateY(-50%);
    cursor: pointer;
    font-size: 20px;
    color: white;
}

/* Title */
.top-bar h1 {
    margin: 0;
    font-size: 28px;
    font-weight: bold;
    color: white;
}

/* Filters row (below top bar) */
.filter-bar {
    margin-top: 12px;
    display: flex;
    justify-content: center;
    gap: 15px;
    padding: 10px 0;
}

.filter-bar input[type="date"],
.filter-bar select {
    padding: 6px 10px;
    font-size: 14px;
    border: 1px solid #ccc;
    border-radius: 6px;
    min-width: 180px;
}

/* Date summary styling */
.date-summary {
    text-align: center;
  
    font-size: 15px;
    color: #333;
    line-height: 1.6;
}
.date-summary strong {
    color: #000;
}
</style>

<!-- Brown bar -->
<div class="top-bar">
    <!-- Sidebar toggle -->
    <div class="toggle-icon-container">
        <i id="toggleIcon" class="fas fa-angle-double-left"
           onclick="toggleSidebar()" title="Toggle Sidebar"></i>
    </div>
    <!-- Title -->
    <h1>Manager's Dashboard</h1>
</div>

<!-- Date summary below header -->
<div class="date-summary" style="text-align: center; margin:0 auto; padding:5px 0; font-size: 15px; line-height:1.6;">
    <p>
        Showing data for: 
        <strong><?= date('F j, Y', strtotime($selectedDate)) ?></strong><br>
        Monthly Range: 
        <strong><?= date('F 1, Y', strtotime($selectedDate)) ?> - <?= date('F t, Y', strtotime($selectedDate)) ?></strong><br>
        Campus: <strong><?= $campus !== '' ? htmlspecialchars($campus) : 'All Campuses' ?></strong>
    </p>

    <!-- Filters row (separate row below bar, centered) -->
<div class="filter-bar" style="margin-top:5px; margin-bottom:0;">
    <form method="GET" id="filterForm" style="display:flex; gap:15px;">
        <input type="date" name="date" id="selectedDate" 
            value="<?= htmlspecialchars($selectedDate) ?>" 
            onchange="document.getElementById('filterForm').submit();">

        <select name="campus" onchange="document.getElementById('filterForm').submit();">
            <option value="">-- All Campuses --</option>
            <option value="Lower Kabete"   <?= $campus=='Lower Kabete'   ? 'selected' : '' ?>>Lower Kabete</option>
            <option value="Mombasa"        <?= $campus=='Mombasa'        ? 'selected' : '' ?>>Mombasa</option>
            <option value="Embu"           <?= $campus=='Embu'           ? 'selected' : '' ?>>Embu</option>
            <option value="Baringo"        <?= $campus=='Baringo'        ? 'selected' : '' ?>>Baringo</option>
            <option value="Matuga"         <?= $campus=='Matuga'         ? 'selected' : '' ?>>Matuga</option>
        </select>
    </form>
</div>
</div>


    <div class="cards-container">
        <div class="card">
            <h4>Today's Participants                
            (<?= $campus !== '' ? htmlspecialchars($campus) : 'All Campuses' ?>)
        
            </h4>
            <p><?php echo $dailyCount; ?></p>
        </div>
        <div class="card">
            <h4>Monthly Total Participants</h4>
            <p><?php echo $monthlyCount; ?></p>
        </div>
        <div class="card">
            <h4><?php echo "$quarter ($financialYear)"; ?></h4>
            <p><?php echo $quarterlyCount; ?></p>
        </div>
    </div>

    <div class="content-container">
        <?php include 'tables.php'; ?>
    </div>
</div>

</body>
</html>
