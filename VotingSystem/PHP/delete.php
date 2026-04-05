<?php
include("connect.php");

// 1. Check if the user_id was actually sent
if (isset($_POST['user_id'])) {
    
    // Sanitize the input to ensure it's a number
    $id = (int)$_POST['user_id'];

    // 2. Prepare the DELETE query
    // Use your exact column name: user_id
    $sql = "DELETE FROM users WHERE user_id = $id";

    // 3. Execute and respond
    if ($conn->query($sql) === TRUE) {
        // Echo 'success' so your info.js auto-refreshes the table
        echo "success";
    } else {
        // Echo the error if something went wrong
        echo "Error deleting record: " . $conn->error;
    }
} else {
    echo "Error: No User ID provided.";
}

$conn->close();
?>
