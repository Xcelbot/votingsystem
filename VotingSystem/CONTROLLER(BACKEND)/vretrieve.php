<?php
include("../MODEL/connect.php");

// 1. Election status check
$check = $conn->query("SELECT status FROM elections WHERE status = 'Active' LIMIT 1");
if ($check->num_rows === 0) {
    die("unavailable"); 
}

$courseCode = isset($_POST['course']) ? $_POST['course'] : '';

// 2. Fetch candidates with their dynamic position names
$sql = "SELECT c.*, p.position_name, p.priority_order
        FROM candidate c 
        INNER JOIN positions p ON c.position_id = p.position_id
        WHERE c.course = ? 
        ORDER BY p.priority_order ASC, c.candidate_name ASC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $courseCode);
$stmt->execute();
$result = $stmt->get_result();

$ballotData = [];

while ($row = $result->fetch_assoc()) {
    $posName = $row['position_name'];
    $posId   = $row['position_id']; // We still need the ID for the form name
    
    // Structure: [ Position Name ] => [ ID ] => [ Candidates... ]
    if (!isset($ballotData[$posName])) {
        $ballotData[$posName] = [
            'id' => $posId,
            'candidates' => []
        ];
    }
    $ballotData[$posName]['candidates'][] = $row;
}

// 4. Load the view
include("../VIEW/ballot_template.php");
?>