<?php
include("../MODEL/connect.php");

// 1. Get total unique people who have cast a ballot
$totalVotersQuery = $conn->query("SELECT COUNT(DISTINCT voter_id) as total FROM votes");
$totalVoters = $totalVotersQuery->fetch_assoc()['total'] ?? 0;

// 2. Fetch candidates and their current vote counts
$sql = "SELECT c.candidate_id, c.candidate_name, c.college, c.position_id, 
               COUNT(v.vote_id) as total_votes 
        FROM candidate c 
        LEFT JOIN votes v ON v.candidate_id = c.candidate_id 
        GROUP BY c.candidate_id, c.position_id
        ORDER BY c.position_id ASC, total_votes DESC";

$result = $conn->query($sql);

$positionNames = [
    1 => "PRESIDENT", 
    2 => "VICE PRESIDENT", 
    3 => "SENATOR", 
    4 => "GOVERNOR", 
    5 => "VICE GOVERNOR", 
    6 => "BOARD MEMBER"
];

$resultsByPosition = [];

if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $posId = $row['position_id'];
        $resultsByPosition[$posId][] = $row;
    }
}

// 3. LOAD THE VIEW
include("../VIEW/result_template.php");
?>
