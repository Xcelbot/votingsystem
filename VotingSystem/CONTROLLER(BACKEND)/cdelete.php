<?php
include "../MODEL/connect.php";

// 1. Get the ID from the AJAX request
// Note: Ensure the key matches what you sent in candidate.js (candidate_id)
$CandidateID = isset($_POST['candidate_id']) ? $_POST['candidate_id'] : ''; 

if (!empty($CandidateID)) {
    
    // 2. TEMPORARY WORKAROUND: Delete the "Child" rows first
    // We do this because the database has a Foreign Key protecting the votes.
    // If we don't delete the votes first, the database blocks the candidate deletion.
    $sqlDeleteVotes = "DELETE FROM votes WHERE candidate_id = '$CandidateID'";
    $conn->query($sqlDeleteVotes);

    // 3. Now we can safely delete the "Parent" row
    $sqlDeleteCandidate = "DELETE FROM candidate WHERE candidate_id = '$CandidateID'";
    
    if ($conn->query($sqlDeleteCandidate)) { 
        echo "success"; 
    } else {
        // If it still fails, it will tell us exactly why
        echo "Error: " . $conn->error;
    }
} else {
    echo "No Candidate ID provided.";
}

$conn->close();
?>