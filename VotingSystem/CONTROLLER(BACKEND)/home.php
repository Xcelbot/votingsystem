<?php
include("../MODEL/connect.php");

// This backend for home.html can be used to fetch the current election title or status
$action = $_POST['action'] ?? '';

if ($action === 'get_info') {
    // Fetch the most recent active or draft election to show on the splash page
    $sql = "SELECT title FROM elections ORDER BY election_id DESC LIMIT 1";
    $result = $conn->query($sql);
    
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo json_encode(['status' => 'success', 'title' => $row['title']]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No active elections found.']);
    }
} else {
    // For now, just a basic success response
    echo "Home Backend Connected";
}
?>
