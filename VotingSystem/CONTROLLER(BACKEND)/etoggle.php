<?php
include("../MODEL/connect.php");

// 1. Get the status of the MOST RECENT election
$result = $conn->query("SELECT election_id, status FROM elections ORDER BY election_id DESC LIMIT 1");
$row = $result->fetch_assoc();

if ($row) {
    $targetId = $row['election_id'];
    $currentStatus = $row['status'];
    $newStatus = ($currentStatus === 'Active') ? 'Closed' : 'Active';

    // 2. Update ONLY that specific election
    $stmt = $conn->prepare("UPDATE elections SET status = ? WHERE election_id = ?");
    $stmt->bind_param("si", $newStatus, $targetId);

    if ($stmt->execute()) {
        echo $newStatus;
    } else {
        echo "error";
    }
} else {
    // 3. Fallback: If table is completely empty, create a default election
    $conn->query("INSERT INTO elections (title, status) VALUES ('General Election', 'Active')");
    echo "Active";
}

$conn->close();
?>