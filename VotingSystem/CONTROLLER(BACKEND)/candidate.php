<?php
include("../MODEL/connect.php");

// 1. Check for 'position_id' instead of just 'name' to ensure data integrity
if (isset($_POST['position_id']) && isset($_POST['name'])) {
    
    // Assign variables from POST data
    $pos     = $_POST['position_id']; // This MUST be a number (1, 2, 3...)
    $name    = $_POST['name'];
    $college = $_POST['college'];
    $course  = $_POST['course'];
    $action  = $_POST['action'];

    // 2. Add Logic
    if ($action == 'add') {
        // Ensure you are including election_id if your table requires it (default to 1)
        $stmt = $conn->prepare("INSERT INTO candidate (candidate_name, position_id, college, course, election_id) VALUES (?, ?, ?, ?, 1)");
        $stmt->bind_param("siss", $name, $pos, $college, $course);
        
    // 3. Update Logic
    } else {
        $id = $_POST['candidate_id'];
        $stmt = $conn->prepare("UPDATE candidate SET candidate_name=?, position_id=?, college=?, course=? WHERE candidate_id=?");
        $stmt->bind_param("sissi", $name, $pos, $college, $course, $id);
    }

    // 4. Execution & Feedback
    if ($stmt->execute()) {
        echo "success";
    } else {
        // If it fails, this will help you debug (remove for production)
        echo "Error: " . $stmt->error; 
    }
    
    $stmt->close();
    $conn->close();
    exit();
} else {
    echo "missing_data";
}
?>