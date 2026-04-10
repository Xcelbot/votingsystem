<?php
include("../MODEL/connect.php");

header('Content-Type: application/json');

// 1. Fetch candidates and their current vote counts
// We JOIN with the positions table to get the real name dynamically
$sql = "SELECT c.candidate_id, c.candidate_name, c.position_id, p.position_name,
               COUNT(v.vote_id) as total_votes 
        FROM candidate c 
        INNER JOIN positions p ON c.position_id = p.position_id
        LEFT JOIN votes v ON v.candidate_id = c.candidate_id 
        GROUP BY c.candidate_id, c.position_id, p.position_name
        ORDER BY p.priority_order ASC, total_votes DESC";

$result = $conn->query($sql);

$data = [];

if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $posName = $row['position_name'];
        
        if (!isset($data[$posName])) {
            $data[$posName] = [
                'labels' => [],
                'votes'  => []
            ];
        }
        
        $data[$posName]['labels'][] = $row['candidate_name'];
        $data[$posName]['votes'][]  = (int)$row['total_votes'];
    }
}

echo json_encode($data);

$conn->close();
?>
