<?php
include("../MODEL/connect.php");

// 1. Fetch candidates and their current vote counts
// Dynamic join with positions table
$sql = "SELECT c.candidate_id, c.candidate_name, c.college, c.position_id, p.position_name,
               COUNT(v.vote_id) as total_votes 
        FROM candidate c 
        INNER JOIN positions p ON c.position_id = p.position_id
        LEFT JOIN votes v ON v.candidate_id = c.candidate_id 
        GROUP BY c.candidate_id, c.position_id, p.position_name
        ORDER BY p.priority_order ASC, total_votes DESC";

$result = $conn->query($sql);

$resultsByPosition = [];

if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $posName = $row['position_name'];
        $resultsByPosition[$posName][] = $row;
    }
}

// 2. LOAD THE VIEW
include("../VIEW/result_template.php");
?>
