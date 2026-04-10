<?php
include("../MODEL/connect.php");

// 1. Get the ID from the POST request sent by info.js
$id = isset($_POST['user_id']) ? intval($_POST['user_id']) : 0;

$user = null;

// 2. Fetch the specific user's current data
if ($id > 0) {
    $sql = "SELECT * FROM users WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
}

// 3. LOAD THE VIEW
// If no user is found, the template will handle the error message
include("../VIEW/userinfo_template.php");
?>