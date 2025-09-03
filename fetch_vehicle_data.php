<?php
// Log errors to file but not display them to browser
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/php-error.log');

header('Content-Type: application/json');
include 'db.php'; // Database connection

// --- DataTables request parameters ---
$draw        = isset($_POST['draw']) ? intval($_POST['draw']) : 0;
$row         = isset($_POST['start']) ? intval($_POST['start']) : 0;
$rowPerPage  = isset($_POST['length']) ? intval($_POST['length']) : 50;
$searchValue = isset($_POST['search']['value']) ? trim($_POST['search']['value']) : '';

// --- Campus filter (from POST or GET) ---
$campus = '';
if (!empty($_POST['campus'])) {
    $campus = trim($_POST['campus']);
} elseif (!empty($_GET['campus'])) {
    $campus = trim($_GET['campus']);
}
$campusNorm = strtolower(preg_replace('/\s+/', ' ', $campus));

// --- Union query (base dataset) ---
$unionQuery = "
    (
        SELECT 
            md.arrivalDateTime,
            md.motorNumber,
            md.fullName,
            md.phoneNumber,
            md.ksgStaffOrParticipantOrVisitor,
            md.campus
        FROM md
        WHERE motorNumber IS NOT NULL AND motorNumber <> ''
    )
    UNION
    (
        SELECT 
            ld.arrivalDateTime,
            ld.motorNumber,
            ld.fullName,
            ld.phoneNumber,
            ld.ksgStaffOrParticipantOrVisitor,
            ld.campus
        FROM ld
        WHERE motorNumber IS NOT NULL AND motorNumber <> ''
    ) 
";
$baseQuery = "SELECT * FROM ($unionQuery) AS combined";

// --- Count total BEFORE filtering ---
$totalRecords = 0;
$totalRecordsQuery = "SELECT COUNT(*) AS total FROM ($baseQuery) AS t";
if ($resTotal = $conn->query($totalRecordsQuery)) {
    $rowTotal = $resTotal->fetch_assoc();
    $totalRecords = intval($rowTotal['total'] ?? 0);
}

// --- Build WHERE clauses ---
$whereClauses = [];

// Campus filter (skip if ALL)
if ($campusNorm !== '' && $campusNorm !== 'all' && $campusNorm !== 'all campuses' && $campusNorm !== 'allcampuses') {
    $safeCampus = $conn->real_escape_string($campus);
    $whereClauses[] = "TRIM(campus) = '$safeCampus'";
}

// Global search (also includes campus)
if ($searchValue !== '') {
    $safeSearch = $conn->real_escape_string($searchValue);
    $whereClauses[] = "(
        motorNumber LIKE '%$safeSearch%' OR
        fullName LIKE '%$safeSearch%' OR
        phoneNumber LIKE '%$safeSearch%' OR
        ksgStaffOrParticipantOrVisitor LIKE '%$safeSearch%' OR
        campus LIKE '%$safeSearch%'
    )";
}

// --- Final query with filters ---
$filteredQuery = $baseQuery;
if (count($whereClauses) > 0) {
    $filteredQuery .= " WHERE " . implode(" AND ", $whereClauses);
}

// --- Count AFTER filtering ---
$filteredRecords = 0;
$filteredRecordsQuery = "SELECT COUNT(*) AS total FROM ($filteredQuery) AS t";
if ($resFiltered = $conn->query($filteredRecordsQuery)) {
    $rowFiltered = $resFiltered->fetch_assoc();
    $filteredRecords = intval($rowFiltered['total'] ?? 0);
}

// --- Paginated results ---
$orderQuery = $filteredQuery . " ORDER BY arrivalDateTime DESC LIMIT $row, $rowPerPage";
$data = [];
if ($resData = $conn->query($orderQuery)) {
    while ($r = $resData->fetch_assoc()) {
        $formattedDate = '';
        if (!empty($r['arrivalDateTime'])) {
            $dt = new DateTime($r['arrivalDateTime']);
            $formattedDate = $dt->format('F j, Y, g:i A');
        }
        $data[] = [
            "arrivalDateTime" => $formattedDate,
            "motorNumber"     => $r['motorNumber'],
            "fullName"        => $r['fullName'],
            "phoneNumber"     => $r['phoneNumber'],
            "ksgStaffOrParticipantOrVisitor" => $r['ksgStaffOrParticipantOrVisitor'],
            "campus"          => $r['campus'] ?? ''
        ];
    }
}

// --- Respond ---
echo json_encode([
    "draw"            => $draw,
    "recordsTotal"    => $totalRecords,
    "recordsFiltered" => $filteredRecords,
    "data"            => $data
]);
exit;
?>
