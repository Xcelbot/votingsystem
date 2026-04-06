<?php
include("../MODEL/connect.php");

if (isset($_POST['user_id'])) {
    $id = (int)$_POST['user_id'];

    // Utilize the Relationship: Delete dependent data first
    // 1. Clear the ballots
    $conn->query("DELETE FROM votes WHERE voter_id = '$id'");
    
    // 2. Clear the participation record
    $conn->query("DELETE FROM voter WHERE user_id = '$id'");

    // 3. Delete the user (Only if they are a Voter - role_id 3)
    $sql = "DELETE FROM users WHERE user_id = '$id' AND role_id = 3";
    
    if ($conn->query($sql)) {
        echo "success";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>