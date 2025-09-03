<?php
session_start();
include 'db.php'; // Assuming this file contains your database connection details

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $personalNumber = $_POST['personalNumber'];
    $password = $_POST['password'];

    // SQL query to fetch the admin details
    $query = "SELECT * FROM adminmanager WHERE personalNumber = ? AND password = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ss', $personalNumber, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Admin authenticated
        $admin = $result->fetch_assoc();
        $adminName = $admin['FullName'];
        $_SESSION['admin'] = $personalNumber;
        echo "<script>
            alert('Welcome $adminName!');
            window.location.href = 'dashboard.php';
        </script>";
    } else {
        // Authentication failed
        echo "<script>
            alert('Invalid Personal Number or Password');
            window.location.href = 'adminLogin.html';
        </script>";
    }

    $stmt->close();
    $conn->close();
}
?>
