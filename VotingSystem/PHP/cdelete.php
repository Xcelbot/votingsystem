<?php
include "connect.php";
$CandidateID = $_POST['CandidateID'];

$sql = "DELETE FROM candidate WHERE CandidateID = '$CandidateID'";
if ($conn->query($sql)) { 
    echo "success"; 
    }else {
    echo "Error: " . $conn->error;
}
$conn->close();
?>