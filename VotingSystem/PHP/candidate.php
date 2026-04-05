<?php
include ("connect.php");

// 1. Get Action and ID (Always sent)
$action = $_POST['action'] ?? '';
$c_id = isset($_POST['candidate_id']) ? (int)$_POST['candidate_id'] : 0;

$elec_id = 1; // Default active election

// 2. Logic: Handle different actions
if ($action == 'add') {
    // Move inputs INSIDE here to prevent "Undefined key" errors during delete
    $name = $_POST['name'];
    $course = $_POST['course'];
    $college = $_POST['college'];
    $pos_id = (int)$_POST['position_id'];

    // Duplicate Check
    $checkCandidate = "SELECT * FROM candidate WHERE candidate_name = '$name' AND election_id = '$elec_id'";
    $result = $conn->query($checkCandidate);

    if ($result->num_rows > 0) {
        echo "Candidate already registered in this election!";
        exit();
    } else {
        $sql = "INSERT INTO candidate (candidate_name, course, college, position_id, election_id) 
                VALUES ('$name', '$course', '$college', '$pos_id', '$elec_id')";
    }

} elseif ($action == 'update') {
    if ($c_id === 0) { echo "Error: Missing Candidate ID"; exit(); }

    // Move inputs INSIDE here too
    $name = $_POST['name'];
    $course = $_POST['course'];
    $college = $_POST['college'];
    $pos_id = (int)$_POST['position_id'];

    $sql = "UPDATE candidate SET 
            candidate_name = '$name', course = '$course', 
            college = '$college', position_id = '$pos_id' 
            WHERE candidate_id = '$c_id'";

} elseif ($action == 'delete') {
    if ($c_id === 0) { echo "Error: Missing Candidate ID"; exit(); }

    // No need for $name, $course, etc. here
    $sql = "DELETE FROM candidate WHERE candidate_id = '$c_id'";

} else {
    echo "Invalid Action";
    exit();
}

// 3. Execution
if ($conn->query($sql) === TRUE) {
    echo "success";
} else {
    echo "Error: " . $conn->error;
}
?>
