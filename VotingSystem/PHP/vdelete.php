<?php
include("connect.php");

if (isset($_POST['user_id'])) {
    $id = $conn->real_escape_string($_POST['user_id']);

    // Step 1: Manually delete their votes first
    $conn->query("DELETE FROM votes WHERE voter_id = '$id'");

    // Step 2: Delete the user (Match role_id 3 from your image)
    $sql = "DELETE FROM users WHERE user_id = '$id' AND role_id = 3";
    
    if ($conn->query($sql)) {
        echo "success";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>