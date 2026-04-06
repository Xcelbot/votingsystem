<?php
// Include your database connection
include("../MODEL/connect.php");

// Set header to plain text so JavaScript can easily read it
header('Content-Type: text/plain');

try {
    // 1. Fetch the status of the current election
    // We assume election_id 1 is your primary active poll
    $sql = "SELECT status FROM elections WHERE election_id = 1 LIMIT 1";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        // 2. Output the status (Expected: "Active" or "Closed")
        // We use trim() to ensure no accidental whitespace is sent
        echo trim($row['status']);
    } else {
        // Fallback if no election record is found
        echo "Closed";
    }

} catch (Exception $e) {
    // If there is a database error, default to Closed for safety
    echo "Error";
}

$conn->close();
?>