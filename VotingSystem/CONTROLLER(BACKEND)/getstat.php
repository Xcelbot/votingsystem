<?php
include("../MODEL/connect.php");

// 1. PARTICIPATION STATS
$q1 = $conn->query("SELECT COUNT(*) as total FROM users WHERE role_id = 3");
$total = $q1->fetch_assoc()['total'] ?? 0;

$q2 = $conn->query("SELECT COUNT(*) as current FROM voter");
$current = $q2->fetch_assoc()['current'] ?? 0;

$percent = ($total > 0) ? round(($current / $total) * 100, 1) : 0;

// 2. LIVE RESULT HISTORY: Fetching candidates and their current tallies
// We join the candidate table with the votes table to count records
$sqlResults = "SELECT c.candidate_name, c.position_id, c.course, 
               (SELECT COUNT(*) FROM votes v WHERE v.candidate_id = c.candidate_id) as vote_count 
               FROM candidate c 
               ORDER BY c.position_id ASC, vote_count DESC";
$resultsQuery = $conn->query($sqlResults);

$liveResults = [];
while ($row = $resultsQuery->fetch_assoc()) {
    $liveResults[] = $row;
}

// 3. POSITION MAPPING
$positions = [
    1 => "PRESIDENT", 2 => "VICE PRESIDENT", 3 => "SENATOR",
    4 => "GOVERNOR", 5 => "VICE GOVERNOR", 6 => "BOARD MEMBER"
];

// Pass all data to the View
include("../VIEW/stat_template.php");
?>