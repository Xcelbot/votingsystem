<?php
include("connect.php");

// 1. Get the total number of unique voters who have cast at least one vote
$totalVotersQuery = $conn->query("SELECT COUNT(DISTINCT voter_id) as total FROM votes");
$totalVoters = $totalVotersQuery->fetch_assoc()['total'] ?? 0;

// 2. Optimized SQL: Removed the undefined '$id' and grouped by position
$sql = "SELECT c.candidate_id, c.candidate_name, c.college, c.position_id, 
               COUNT(v.vote_id) as total_votes 
        FROM candidate c 
        LEFT JOIN votes v ON c.candidate_id = v.candidate_id 
        GROUP BY c.candidate_id, c.position_id
        ORDER BY c.position_id ASC, total_votes DESC";

$result = $conn->query($sql);

$positions = [
    1 => "PRESIDENT", 
    2 => "VICE PRESIDENT", 
    3 => "SENATOR", 
    4 => "GOVERNOR", 
    5 => "VICE GOVERNOR", 
    6 => "BOARD MEMBER"
];

if ($result && $result->num_rows > 0) {
    // Group candidates by their position_id
    $groupedData = [];
    while($row = $result->fetch_assoc()) {
        $groupedData[$row['position_id']][] = $row;
    }

    // Loop through each position group
    foreach ($groupedData as $pos_id => $candidates) {
        $pos_name = $positions[$pos_id] ?? "CANDIDATE";
        $votes_in_this_pos = 0;

        echo "<div style='background:#444; color:white; text-align:center; padding:8px; font-weight:bold; text-transform:uppercase;'>$pos_name</div>";
        echo "<table border='1' width='100%' style='border-collapse:collapse; background:white; color:black; margin-bottom:20px;'>
                <thead>
                    <tr style='background:#f2f2f2;'>
                        <th width='35%'>NAME</th>
                        <th width='45%'>COLLEGE</th>
                        <th width='20%'>VOTE COUNT</th>
                    </tr>
                </thead>
                <tbody>";

        foreach ($candidates as $row) {
            $votes_in_this_pos += $row['total_votes'];
            echo "<tr>
                    <td style='padding:10px;'>" . htmlspecialchars($row['candidate_name']) . "</td>
                    <td style='padding:10px; font-size:0.85em;'>" . htmlspecialchars($row['college']) . "</td>
                    <td style='padding:10px; text-align:center; color:#27ae60;'><strong>" . $row['total_votes'] . "</strong></td>
                  </tr>";
        }

        // 3. Calculate Abstain: Total voters minus everyone who picked a candidate in this position
        // This includes those who specifically chose 'Abstain' (id 0) if you use that system
        $abstain_count = $totalVoters - $votes_in_this_pos;
        if ($abstain_count < 0) $abstain_count = 0; // Safety check

        echo "<tr style='background:#f9f9f9; font-style:italic;'>
                <td colspan='2' style='padding:10px;'>ABSTAIN (No selection / None)</td>
                <td style='padding:10px; text-align:center;'><strong>$abstain_count</strong></td>
              </tr>";
        echo "</tbody></table>";
    }
} else {
    echo "<div style='text-align:center; padding:20px;'>No candidates registered yet.</div>";
}
?>
