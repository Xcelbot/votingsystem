<?php
include("../MODEL/connect.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // 1. Get the Hidden ID
    $user_id = (int)$_POST['user_id'];

    // 2. Map 'fullname' from your form (instead of fname, mname, lname)
    $full_name = trim($_POST['fullname']);

    // Map the rest of the fields
    $school_id   =  $_POST['school_id'];
    $email       = trim($_POST['email']);
    $college     =  $_POST['college'];
    $course      =  $_POST['course'];
    $year_level  =  $_POST['year_level'];
    $role_id     = (int)$_POST['role_id'];

    // 3. CHECK: Ensure the School ID isn't used by someone else
    $check_sql = "SELECT user_id FROM users WHERE school_id = '$school_id' AND user_id != '$user_id'";
    $check_res = $conn->query($check_sql);

    if ($check_res->num_rows > 0) {
        echo "Error: This School ID is already registered to another user.";
        exit();
    }

    // 4. FIXED UPDATE: Only uses columns that exist in your DB (fullname)
    $sql = "UPDATE users SET 
            fullname    = '$full_name',
            school_id   = '$school_id',
            email       = '$email',
            college     = '$college',
            course      = '$course',
            year_level  = '$year_level',
            role_id     = '$role_id'
            WHERE user_id = '$user_id'";

    if ($conn->query($sql) === TRUE) {
        echo "success";
    } else {
        echo "Database Error: " . $conn->error;
    }
}
$conn->close();
?>
