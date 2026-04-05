<?php
header('Content-Type: application/json');
include("connect.php");

$results = [];

// 1. Total Turnout Logic
$total_voters = $conn->query("SELECT COUNT(*) as count FROM users WHERE role_id = 2")->fetch_assoc()['count'];
$voted_count = $conn->query("SELECT COUNT(DISTINCT voter_id) as count FROM votes")->fetch_assoc()['count'];

$results['turnout'] = [
    'title' => 'Total Turnout',
    'labels' => ['Voted', 'Not Voted'],
    'data' => [(int)$voted_count, (int)($total_voters - $voted_count)]
];

// 2. Position Logic (Only shows positions with candidates)
$pos_names = [1 => "PRESIDENT", 2 => "VICE PRESIDENT", 3 => "SENATOR", 4 => "GOVERNOR", 5 => "VICE GOVERNOR", 6 => "BOARD MEMBER"];

$active_pos = $conn->query("SELECT DISTINCT position_id FROM candidate");

while($p = $active_pos->fetch_assoc()) {
    $id = $p['position_id'];
    $name = $pos_names[$id] ?? "POSITION $id";

    // Fetch Candidates and Counts
    $sql = "SELECT c.candidate_name, 
            (SELECT COUNT(*) FROM votes v WHERE v.candidate_id = c.candidate_id) as votes 
            FROM candidate c WHERE c.position_id = '$id'";
    
    $cand_res = $conn->query($sql);
    $labels = [];
    $data = [];

    while($row = $cand_res->fetch_assoc()) {
        $labels[] = $row['candidate_name'];
        $data[] = (int)$row['votes'];
    }

    // Add Abstain Count for this position
    $abstain = $conn->query("SELECT COUNT(*) as count FROM votes WHERE position_id = '$id' AND candidate_id = 0")->fetch_assoc()['count'];
    $labels[] = "Abstain";
    $data[] = (int)$abstain;

    $results['positions'][$id] = [
        'title' => $name,
        'labels' => $labels,
        'data' => $data
    ];
}

echo json_encode($results);
?>
