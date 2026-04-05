<?php
session_start();
include("connect.php");

date_default_timezone_set('Asia/Manila');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $voter_id = $_SESSION['user_id'];
    $elec_id = 1; // Match the default election_id in your table
    $now = date('Y-m-d H:i:s');

    // 1. SECURITY: Check if already voted
    $check = $conn->query("SELECT vote_time FROM users WHERE user_id = '$voter_id'");
    $userData = $check->fetch_assoc();
    if ($userData['vote_time'] !== NULL) {
        echo "Error: You have already voted.";
        exit();
    }

    // 2. INSERT into the 'votes' table 
    foreach ($_POST as $key => $candidate_id) {
    if (strpos($key, 'pos_') === 0) {
        $pos_id = (int)str_replace('pos_', '', $key);
        $c_id = (int)$candidate_id;

            $sql = "INSERT INTO votes (voter_id, election_id, position_id, candidate_id) 
                VALUES ('$voter_id', 1, '$pos_id', '$c_id')";
        $conn->query($sql);
        }
    }

    // 3. Mark user as voted
    $update = "UPDATE users SET vote_time = '$now' WHERE user_id = '$voter_id'";
    if ($conn->query($update)) {
        echo "success";
    } else {
        echo "Database Error: " . $conn->error;
    }
}
?>