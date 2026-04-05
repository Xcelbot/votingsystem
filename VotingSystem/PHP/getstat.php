<?php
include("connect.php");

// 1. Total: Count everyone with role_id 3
$q1 = $conn->query("SELECT COUNT(*) as total FROM users WHERE role_id = 3");
$total = $q1->fetch_assoc()['total'] ?? 0;

// 2. Current: Count how many UNIQUE voters have actually cast a ballot
$q2 = $conn->query("SELECT COUNT(DISTINCT voter_id) as current FROM votes");
$current = $q2->fetch_assoc()['current'] ?? 0;

// 3. Percentage Calculation
$percent = ($total > 0) ? round(($current / $total) * 100, 1) : 0;

// 4. Match the layout in your screenshot
echo "<span>Total Voters: <b>$total</b></span>";
echo "<span>Current Votes: <b>$current</b></span>";
echo "<span>Percentage: <b>$percent%</b></span>";
?>