<?php
session_start();
include("../MODEL/connect.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['votes'])) {
    $user_id = $_SESSION['user_id'] ?? 0; 
    $election_id = 1; 

    // 1. Save individual votes
    foreach ($_POST['votes'] as $posId => $candidateId) {
        if ($candidateId !== 'abstain') {
            $sql = "INSERT INTO votes (voter_id, election_id, position_id, candidate_id) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("iiii", $user_id, $election_id, $posId, $candidateId);
            $stmt->execute();
        }
    }

    // 2. Record the voter
    $voterSql = "INSERT INTO voter (user_id, election_id) VALUES (?, ?)";
    $voterStmt = $conn->prepare($voterSql);
    $voterStmt->bind_param("ii", $user_id, $election_id);
    
    // 3. Final Redirect
    $voterStmt->execute();
    header("Location: ../VIEW/logout.html");
    exit();
}
?>