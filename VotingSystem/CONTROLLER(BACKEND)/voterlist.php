<?php
include("../MODEL/connect.php");

// 1. Fetch the list of people who have voted
// We JOIN with 'users' to get the fullname and school_id
$sql = "SELECT v.voted_at, u.fullname, u.school_id, u.course 
        FROM voter v 
        JOIN users u ON v.user_id = u.user_id 
        ORDER BY v.voted_at DESC";

$result = $conn->query($sql);
$voters = [];

if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $voters[] = $row;
    }
}

// 2. LOAD THE VIEW
include("../VIEW/voterlist_template.php");
?>