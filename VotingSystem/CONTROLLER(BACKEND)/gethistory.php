<?php
include("../MODEL/connect.php");

// 1. Fetch the 10 most recent voters
// Using DATE_FORMAT to get clean strings directly from SQL
$sql = "SELECT school_id, email, fullname,
               DATE_FORMAT(vote_time, '%h:%i %p') as v_time, 
               DATE_FORMAT(vote_time, '%M %e, %Y') as v_date,
               vote_time
        FROM users 
        WHERE vote_time IS NOT NULL 
        ORDER BY vote_time DESC LIMIT 100";

$result = $conn->query($sql);
$history = [];

if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        // Optional: Add a "Status" label logic
        $row['status'] = "Confirmed";
        $history[] = $row;
    }
}

// 2. LOAD THE VIEW
include("../VIEW/history_template.php");
?>