<?php
// MODEL/fetch_archive.php
include("connect.php");

// Fixed: positions table uses position_id as primary key, not 'id'
$sql = "SELECT 
            a.archive_id, 
            a.election_title AS candidate_name, 
            COALESCE(p.position_name, CONCAT('Position ID #', a.election_id)) AS position_name 
        FROM archive a
        LEFT JOIN positions p ON a.election_id = p.position_id
        ORDER BY a.archive_id DESC";

$result = $conn->query($sql);
?>