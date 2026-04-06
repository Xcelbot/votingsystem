<?php
include ("../MODEL/connect.php");
// 1. Get form data
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$middle_name = $_POST['middle_name'];
$school_id = $_POST['school_id'];
$email = $_POST['email'];
$college = $_POST['college'];
$course = $_POST['course'];
$year_level = $_POST['year_level'];

// Get the role from the HTML dropdown
$role_id = (int)$_POST['role_id']; 

// 2. Security: Block any attempt to register as SuperAdmin (ID 1)
if ($role_id === 1) {
    echo "Unauthorized: You cannot register as a SuperAdmin.";
    exit();
}

// 3. Get passwords
$password_raw = $_POST['password']; 
$confirm_password = $_POST['confirm_password'];

// 4. Match check
if ($password_raw !== $confirm_password) {
    echo "Passwords do not match!";
    exit();
}

$fullname = $last_name . ", " . $first_name . " " . $middle_name; 

// 5. Hash the password
$hashed_password = password_hash($password_raw, PASSWORD_BCRYPT);

// 6. Check duplicates
$checkUser = "SELECT email FROM users WHERE email = '$email' OR school_id = '$school_id'";
$result = $conn->query($checkUser);

if ($result->num_rows > 0) {
    echo "Email or School ID already registered!";
} else {
    // 7. Insert into database (Now using the dynamic $role_id)
    $sql = "INSERT INTO users (role_id, school_id, fullname, email, password_hash, college, course, year_level) 
            VALUES ('$role_id', '$school_id', '$fullname', '$email', '$hashed_password', '$college', '$course', '$year_level')";

    if ($conn->query($sql) === TRUE) {
        echo "success";
    } else {
        echo "Error: " . $conn->error;
    }
}    
?>