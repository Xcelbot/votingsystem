<?php
include("../MODEL/connect.php");

// Check if the essential data is actually being POSTed
if (isset($_POST['name']) && isset($_POST['action'])) {
    $name    = $_POST['name'];
    $pos     = $_POST['position_id'];
    $college = $_POST['college'];
    $course  = $_POST['course'];
    $action  = $_POST['action'];

    if ($action == 'add') {
        $stmt = $conn->prepare("INSERT INTO candidate (candidate_name, position_id, college, course) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("siss", $name, $pos, $college, $course);
    } else {
        $id = $_POST['candidate_id'];
        $stmt = $conn->prepare("UPDATE candidate SET candidate_name=?, position_id=?, college=?, course=? WHERE candidate_id=?");
        $stmt->bind_param("sissi", $name, $pos, $college, $course, $id);
    }

    if ($stmt->execute()) {
        echo "success";
    } else {
        // Log the error but don't show specific DB details to users in production
        echo "error"; 
    }
    
    $stmt->close(); // Always good practice to close the statement
    $conn->close();
    exit();
}
?>