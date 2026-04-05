<?php
include("connect.php");

// 1. Updated SQL with New Date Formats
// %M %e, %Y -> April 1, 2026
// %h:%i %p   -> 10:12 PM
$sql = "SELECT school_id, email, 
               DATE_FORMAT(vote_time, '%h:%i %p') as v_time, 
               DATE_FORMAT(vote_time, '%M %e, %Y') as v_date 
        FROM users 
        WHERE vote_time IS NOT NULL 
        ORDER BY vote_time DESC LIMIT 10";

$result = $conn->query($sql);

// 2. Safety Check (Prevents the "bool" error)
if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . htmlspecialchars($row['school_id']) . "</td>
                <td>" . htmlspecialchars($row['email']) . "</td>
                <td>" . $row['v_time'] . "</td>
                <td>" . $row['v_date'] . "</td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='4' style='text-align:center;'>No voting history found.</td></tr>";
}
?>      