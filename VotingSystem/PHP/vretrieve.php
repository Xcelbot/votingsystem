<?php
session_start();
include("connect.php");

// 1. Get the course code sent by voter.js (BSIT, BSIS, or BLIS)
$v_course = $_POST['course'] ?? '';

// 2. Mapping: If your HTML sends the full name, convert it to the short code
$course_map = [
    "Bachelor of Science in Information Technology" => "BSIT", 
    "Bachelor of Science in Information Systems"    => "BSIS", 
    "Bachelor of Library and Information Science"   => "BLIS"
];
if (isset($course_map[$v_course])) {
    $v_course = $course_map[$v_course];
}

if (empty($v_course)) {
    echo "<div>Error: No course filter detected.</div>";
    exit();
}

// 3. THE FIX: Strict SQL Filter
// This ensures ONLY candidates matching the specific course are pulled
$sql = "SELECT * FROM candidate 
        WHERE course = '$v_course' 
        ORDER BY position_id ASC";

$result = $conn->query($sql);

$current_pos = null;
$positions = [
    1 => "PRESIDENT", 2 => "VICE PRESIDENT", 3 => "SENATOR", 
    4 => "GOVERNOR", 5 => "VICE GOVERNOR", 6 => "BOARD MEMBER"
];

if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        
        // Position Header logic
        if ($current_pos !== $row['position_id']) {
            $current_pos = $row['position_id'];
            $pos_name = $positions[$current_pos] ?? "CANDIDATE";
            
            echo "<div style='font-weight:bold; margin-top:20px; border-bottom: 1px solid #ccc; padding-bottom: 5px;'>
                    POSITION: $pos_name
                  </div>";
            
            // Add Abstain Option
            echo "<div style='margin: 10px 0; display: flex; align-items: center; color: #d9534f;'>
                    <input type='radio' name='pos_$current_pos' value='0' required style='margin-right:10px;'>
                    <span style='font-weight: bold;'>ABSTAIN / NONE</span>
                  </div>";
        }

        // Candidate Row (Now strictly filtered by $v_course)
        echo "<div style='margin: 15px 0; display: flex; align-items: center;'>
                <input type='radio' name='pos_$current_pos' value='".$row['candidate_id']."' required style='margin-right:10px;'>
                <div>
                    <span style='font-size: 1.1em;'>" . $row['candidate_name'] . "</span><br>
                    <small style='color: #666;'>" . $row['college'] . "</small>
                </div>
              </div>";
    }
} else {
    echo "<div style='padding:20px; text-align:center;'>No candidates available for $v_course.</div>";
}
?>
