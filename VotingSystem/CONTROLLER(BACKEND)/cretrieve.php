<?php
include ("../MODEL/connect.php"); //

// 1. Fetch candidates sorted by Course and Position
$sql = "SELECT * FROM candidate ORDER BY course ASC, position_id ASC";
$result = $conn->query($sql);

// 2. Mapping data for readable display
$course_titles = [
    "BSIT" => "Bachelor of Science in Information Technology",
    "BLIS" => "Bachelor of Library and Information Science",
    "BSIS" => "Bachelor of Science in Information Systems"
];

$positions = [
    1 => "PRESIDENT",
    2 => "VICE PRESIDENT",
    3 => "SENATOR",
    4 => "GOVERNOR",
    5 => "VICE GOVERNOR",
    6 => "BOARD MEMBER",
];

$groupedCandidates = [];

// 3. Organize data into a structured array instead of echoing
if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $course = $row['course'];
        $posId = $row['position_id'];
        
        // Group by Course -> Then by Position
        $groupedCandidates[$course][$posId][] = $row;
    }
}

// 4. Pass the data to the View
include("../VIEW/cretrieve_template.php");
?>
