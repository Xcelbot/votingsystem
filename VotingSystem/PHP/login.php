<?php
session_start(); 
include("connect.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password_raw = trim($_POST['password']);

    $sql = "SELECT * FROM users WHERE email = ? LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        if (password_verify($password_raw, $user['password_hash'])) {
            
            // --- NEW: Check if the user has already voted ---
            // Only check this for voters (role_id 3)
            if ($user['role_id'] == 3 && $user['vote_time'] !== NULL) {
                echo "already_voted";
                exit();
            }

            // Save session information
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['role_id'] = (int)$user['role_id']; 
            $_SESSION['course'] = $user['course'];
            $_SESSION['fullname'] = $user['fullname'];
            
            // Return "success" so your AJAX can handle the redirect
            echo "success";
            exit();
        } else {
            echo "Invalid Password.";
        }
    } else {
        echo "Email not found.";
    }
}
?>