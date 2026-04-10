<?php
include("../MODEL/connect.php");

// Fetch all registered voters (role_id = 3)
$sql = "SELECT user_id, school_id, fullname, course, year_level, email 
        FROM users 
        WHERE role_id = 3 
        ORDER BY fullname ASC";

$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['school_id']) . "</td>";
        echo "<td><strong>" . htmlspecialchars($row['fullname']) . "</strong><br><small style='color:#888; font-size:9px;'>" . htmlspecialchars($row['email']) . "</small></td>";
        echo "<td>" . htmlspecialchars($row['course']) . " - " . htmlspecialchars($row['year_level']) . "</td>";
        echo "<td style='text-align:center;'>";
        // Edit Button with data attributes for quick population
        echo "<button class='btn-sm edit-btn' 
                data-id='" . $row['user_id'] . "' 
                data-schoolid='" . htmlspecialchars($row['school_id']) . "' 
                data-fullname='" . htmlspecialchars($row['fullname']) . "' 
                data-email='" . htmlspecialchars($row['email']) . "' 
                data-course='" . htmlspecialchars($row['course']) . "' 
                data-year='" . htmlspecialchars($row['year_level']) . "' 
                style='margin-right:5px; background: #2a3a3a;'>Edit</button>";
        echo "<button class='btn-sm delete-btn' data-id='" . $row['user_id'] . "' data-name='" . htmlspecialchars($row['fullname']) . "'>Remove</button>";
        echo "</td>";
        echo "</tr>";
    }
} else {
    echo "<tr class='empty-row'><td colspan='4'>No registered voters found.</td></tr>";
}

$conn->close();
?>
