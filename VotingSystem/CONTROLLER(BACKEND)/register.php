<?php
include ("../MODEL/connect.php");

// 1. Get and sanitize form data
$first_name  = trim($_POST['first_name']  ?? '');
$last_name   = trim($_POST['last_name']   ?? '');
$middle_name = trim($_POST['middle_name'] ?? '');
$school_id   = trim($_POST['school_id']   ?? '');
$email       = trim($_POST['email']       ?? '');
$college     = trim($_POST['college']     ?? '');
$course      = trim($_POST['course']      ?? '');
$year_level  = trim($_POST['year_level']  ?? '');
$role_id     = intval($_POST['role_id']   ?? 0);

// Basic Validation
if (empty($first_name) || empty($last_name) || empty($school_id) || empty($email) || empty($role_id)) {
    echo "Please fill in all required fields.";
    exit();
}

// 2. Security: Block any attempt to register as SuperAdmin (ID 1)
if ($role_id === 1) {
    echo "Unauthorized: You cannot register as a SuperAdmin.";
    exit();
}

// 3. Get and validate passwords
$password_raw     = $_POST['password'] ?? ''; 
$confirm_password = $_POST['confirm_password'] ?? '';

if ($password_raw !== $confirm_password) {
    echo "Passwords do not match!";
    exit();
}

$fullname = $last_name . ", " . $first_name . " " . $middle_name; 

// 4. Hash the password
$hashed_password = password_hash($password_raw, PASSWORD_BCRYPT);

// 5. Check duplicates (Email or School ID) using Prepared Statements
$checkSql = "SELECT user_id FROM users WHERE email = ? OR school_id = ?";
$checkStmt = $conn->prepare($checkSql);
$checkStmt->bind_param("ss", $email, $school_id);
$checkStmt->execute();
$checkResult = $checkStmt->get_result();

if ($checkResult->num_rows > 0) {
    $existing = $checkResult->fetch_assoc();
    echo "Error: This Email or Student ID is already registered!";
    exit();
}

// 6. Insert into database
$sql = "INSERT INTO users (role_id, school_id, fullname, email, password_hash, college, course, year_level, is_active) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, 1)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("iisssssi", $role_id, $school_id, $fullname, $email, $hashed_password, $college, $course, $year_level);

if ($stmt->execute()) {
    echo "success";
} else {
    echo "Database Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>