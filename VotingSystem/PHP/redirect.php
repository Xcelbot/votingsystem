<?php
session_start();
include("connect.php");
if (!isset($_SESSION['role_id'])) {
    echo "<script>window.location.href='../HTML/login.html'</script>";
    exit();
}

$role = (int)$_SESSION['role_id'];
$course = $_SESSION['course'];
$target = "";

// 1. Check ROLE (SuperAdmin is 1)
if ($role === 1) { 
    $target = "../HTML/dasboardADMIN.html"; 
} 
elseif ($role === 2) {
    $target = "../HTML/dasboardOFFICER.html";
}
elseif ($role === 4) {
    $target = "../HTML/dasboardAUDITOR.html";
}
elseif ($role === 3) {
    if ($course == "Bachelor of Science in Information Technology") {
        $target = "../HTML/dasboardBSIT.html";
    }
    elseif ($course == "Bachelor of Science in Information Systems") {
        $target = "../HTML/dasboardBSIS.html";
    }
    elseif ($course == "Bachelor of Library and Information Science") {
        $target = "../HTML/dasboardBLIS.html";
    }
}

// 3. Final Fallback
if ($target == "") {
    $target = "../HTML/login.html?error=invalid_access";
}

echo "<script>window.location.href='$target';</script>";
exit();
?>
