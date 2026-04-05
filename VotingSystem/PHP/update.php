<?php
include("connect.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // 1. Get the Hidden ID and Manual Inputs from POST
    $user_id     = (int)$_POST['user_id'];
    $first_name  = mysqli_real_escape_string($conn, trim($_POST['fname']));
    $middle_name = mysqli_real_escape_string($conn, trim($_POST['mname']));
    $last_name   = mysqli_real_escape_string($conn, trim($_POST['lname']));
    
    // Create the Combined Fullname
    $full_name   = $first_name . " " . $last_name;

    $school_id   = mysqli_real_escape_string($conn, $_POST['school_id']);
    $email       = mysqli_real_escape_string($conn, trim($_POST['email']));
    $college     = mysqli_real_escape_string($conn, $_POST['college']);
    $course      = mysqli_real_escape_string($conn, $_POST['course']);
    $year_level  = mysqli_real_escape_string($conn, $_POST['year_level']);
    $role_id     = (int)$_POST['role_id'];

    // 2. CHECK: Ensure the School ID isn't already used by someone else
    $check_sql = "SELECT user_id FROM users WHERE school_id = '$school_id' AND user_id != '$user_id'";
    $check_res = $conn->query($check_sql);

    if ($check_res->num_rows > 0) {
        echo "Error: This School ID is already registered to another user.";
        exit();
    }

    // 3. PREPARE THE UPDATE QUERY
    $sql = "UPDATE users SET 
            first_name  = '$first_name',
            middle_name = '$middle_name',
            last_name   = '$last_name',
            fullname    = '$full_name',
            school_id   = '$school_id',
            email       = '$email',
            college     = '$college',
            course      = '$course',
            year_level  = '$year_level',
            role_id     = '$role_id'
            WHERE user_id = '$user_id'";

    // 4. EXECUTION
    if ($conn->query($sql) === TRUE) {
        // Echo 'success' so the info.js alert triggers
        echo "success";
    } else {
        echo "Database Error: " . $conn->error;
    }
}

$conn->close();
?>
