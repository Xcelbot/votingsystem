<?php
include("../MODEL/connect.php");

// 1. Election status check
$check = $conn->query("SELECT status FROM elections WHERE status = 'Active' LIMIT 1");
if ($check->num_rows === 0) {
    die("unavailable"); 
}

$courseCode = isset($_POST['course']) ? $_POST['course'] : '';

// 2. Fetch candidates (No JOIN needed since we are mapping in code)
$sql = "SELECT * FROM candidate WHERE course = ? ORDER BY position_id ASC, candidate_name ASC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $courseCode);
$stmt->execute();
$result = $stmt->get_result();

// 3. INTERNAL MAP: This replaces the 'positions' table
// The keys match your position_id, the values are the names and sort order
$positionMap = [
    1 => "President",
    2 => "Vice President",
    3 => "Senator",
    4 => "Governor",
    5 => "Vice Governor",
    6 => "Board Member"
];

$ballotData = [];

while ($row = $result->fetch_assoc()) {
    $id = $row['position_id'];
    
    // Look up the name in our manual map, or default to "Unknown"
    $posName = isset($positionMap[$id]) ? $positionMap[$id] : "Unknown Position";
    
    // Group the candidate under that name
    $ballotData[$posName][] = $row;
}

// 4. Load the view
include("../VIEW/ballot_template.php");
?>