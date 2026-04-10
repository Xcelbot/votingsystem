<?php
include("../MODEL/connect.php");

// 1. PARTICIPATION STATS
$q1 = $conn->query("SELECT COUNT(*) as total FROM users WHERE role_id = 3");
$total = $q1->fetch_assoc()['total'] ?? 0;

$q2 = $conn->query("SELECT COUNT(*) as current FROM voter");
$current = $q2->fetch_assoc()['current'] ?? 0;

$percent = ($total > 0) ? round(($current / $total) * 100, 1) : 0;

// 2. LIVE RESULT HISTORY: Fetching candidates and their current tallies
$sqlResults = "SELECT c.candidate_name, c.position_id, p.position_name, c.course, 
               (SELECT COUNT(*) FROM votes v WHERE v.candidate_id = c.candidate_id) as vote_count 
               FROM candidate c 
               INNER JOIN positions p ON c.position_id = p.position_id
               ORDER BY p.priority_order ASC, vote_count DESC";
$resultsQuery = $conn->query($sqlResults);

$liveResults = [];
while ($row = $resultsQuery->fetch_assoc()) {
    $liveResults[] = $row;
}

// 3. Pass all data to the View
// Note: $positions mapping is no longer needed as we fetch position_name in the query
include("../VIEW/stat_template.php");
?>