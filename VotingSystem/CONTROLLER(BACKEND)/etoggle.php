<?php
include("../MODEL/connect.php");

// 1. Get the current status
$result = $conn->query("SELECT status FROM elections LIMIT 1");
$row = $result->fetch_assoc();

if ($row) {
    // 2. Toggle the logic
    $currentStatus = $row['status'];
    $newStatus = ($currentStatus === 'Active') ? 'Closed' : 'Active';

    // 3. Update the database
    $stmt = $conn->prepare("UPDATE elections SET status = ?");
    $stmt->bind_param("s", $newStatus);

    if ($stmt->execute()) {
        echo $newStatus; // Return the new status to the frontend
    } else {
        echo "error";
    }
} else {
    // If table is empty, create an initial 'Active' row
    $conn->query("INSERT INTO elections (title, status) VALUES ('General Election', 'Active')");
    echo "Active";
}
?>