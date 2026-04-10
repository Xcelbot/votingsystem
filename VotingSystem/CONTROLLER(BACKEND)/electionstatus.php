<?php
include("../MODEL/connect.php");
header('Content-Type: text/plain');

try {
    // Fetch the status of the MOST RECENT election record
    $sql = "SELECT status FROM elections ORDER BY election_id DESC LIMIT 1";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo trim($row['status']);
    } else {
        // Fallback if no election record exists at all
        echo "Closed";
    }

} catch (Exception $e) {
    echo "Error";
}

$conn->close();
?>