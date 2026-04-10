<?php
session_start(); 
include("../MODEL/connect.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password_raw = trim($_POST['password']);

    // --- 1. PREDEFINED ADMIN (Hardcoded) ---
    if ($email === "admin@email.com" && $password_raw === "admin123") {
        $_SESSION['user_id'] = 0; 
        $_SESSION['role_id'] = 1; // Admin Role
        $_SESSION['fullname'] = "System Administrator";
        echo "success"; 
        exit();
    }

    // --- 2. DATABASE CHECK ---
    $sql = "SELECT * FROM users WHERE email = ? LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        if (password_verify($password_raw, $user['password_hash'])) {
            $user_id = $user['user_id'];
            $role_id = (int)$user['role_id'];

            // --- 3. VOTER SECURITY CHECK (Role 3) ---
            if ($role_id === 3) {
                $election_id = 1;
                $checkVoted = $conn->prepare("SELECT * FROM voter WHERE user_id = ? AND election_id = ?");
                $checkVoted->bind_param("ii", $user_id, $election_id);
                $checkVoted->execute();
                
                if ($checkVoted->get_result()->num_rows > 0) {
                    echo "already_voted";
                    exit();
                }
            }

            // --- 4. SET SESSIONS ---
            $_SESSION['user_id'] = $user_id;
            $_SESSION['role_id'] = $role_id; 
            $_SESSION['course'] = $user['course'];
            $_SESSION['fullname'] = $user['fullname'];
            
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