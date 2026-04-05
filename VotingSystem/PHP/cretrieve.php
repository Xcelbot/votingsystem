<?php
include ("connect.php");

// 1. Sort by Course first, then Position
$sql = "SELECT * FROM candidate ORDER BY course ASC, position_id ASC";
$result = $conn->query($sql);

$current_course = null;
$current_position = null;

// Map Short Codes to Full Names
$course_titles = [
    "BSIT" => "Bachelor of Science in Information Technology",
    "BLIS" => "Bachelor of Library and Information Science",
    "BSIS" => "Bachelor of Science in Information Systems"
];

// Map Position IDs to Names
$positions = [
    1 => "PRESIDENT",
    2 => "VICE PRESIDENT",
    3 => "SENATOR",
    4 => "GOVERNOR",
    5 => "VICE GOVERNOR",
    6 => "BOARD MEMBER",
];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        
        // 2. MAIN HEADER: FULL COURSE NAME (Middle)
        if ($current_course !== $row['course']) {
            $current_course = $row['course'];
            $current_position = null; 
            
            $full_course = $course_titles[$current_course] ?? $current_course;
            
            echo "<tr style='background-color: #343a40; color: white; font-weight: bold;'>
                    <td colspan='4' style='text-align: center; padding: 10px;'>
                        --- $full_course ---
                    </td>
                  </tr>";
        }

        // 3. SUB-HEADER: POSITION (Side)
        if ($current_position !== $row['position_id']) {
            $current_position = $row['position_id'];
            $pos_display = $positions[$current_position] ?? "CANDIDATE";
            
            echo "<tr style='background-color: #f8f9fa; border-bottom: 2px solid #dee2e6;'>
                    <td colspan='4' style='padding-left: 15px; font-weight: bold; color: #495057;'>
                        Position: $pos_display
                    </td>
                  </tr>";
        }

        // 4. CANDIDATE DATA ROW (Fixed: Removed duplicate and added all data-attributes)
        echo "<tr>
                <td style='padding-left: 40px;'>" . $row['candidate_name'] . "</td>
                <td style='text-align: center; color: #6c757d; font-size: 0.9em;'>" . $row['course'] . "</td>
                <td>" . $row['college'] . "</td>
                <td style='text-align: center;'>
                    <button class='edit-btn' 
                data-id='".$row['candidate_id']."' 
                data-name='".$row['candidate_name']."' 
                data-course='".$row['course']."' 
                data-college='".$row['college']."' 
                data-pos='".$row['position_id']."'>
                Edit
            </button>
            <button class='delete-btn' data-id='".$row['candidate_id']."'>Delete</button>
        </td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='4' style='text-align:center; padding: 20px;'>No candidates found.</td></tr>";
}
?>
