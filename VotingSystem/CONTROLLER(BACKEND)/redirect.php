<?php
session_start();
if (!isset($_SESSION['role_id'])) {
    header("Location: ../HTML/login.html");
    exit();
}

$role = (int)$_SESSION['role_id'];
$course = $_SESSION['course'] ?? ""; 
$target = "";

if ($role === 1) { 
    $target = "../VIEW/dasboardADMIN.html"; 
} 
elseif ($role === 2) {
    $target = "../VIEW/dasboardOFFICER.html";
}
elseif ($role === 3) {
    // Check for both full names and shorthand
    if (strpos($course, 'Information Technology') !== false || $course == "BSIT") {
        $target = "../VIEW/dasboardBSIT.html";
    }
    elseif (strpos($course, 'Information Systems') !== false || $course == "BSIS") {
        $target = "../VIEW/dasboardBSIS.html";
    }
    elseif (strpos($course, 'Library') !== false || $course == "BLIS") {
        $target = "../VIEW/dasboardBLIS.html";
    }
}

if ($target == "") {
    $target = "../HTML/login.html?error=invalid_access";
}

echo "<script>window.location.href='$target';</script>";
exit();
?>