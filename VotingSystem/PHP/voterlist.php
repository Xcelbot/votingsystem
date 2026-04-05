<?php
include("connect.php");

// Added vote_time to the SELECT query
$sql = "SELECT user_id, school_id, fullname, email, vote_time FROM users WHERE role_id = 3";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        
        // --- LOGIC: Check if voted ---
        if ($row['vote_time'] !== NULL) {
            $status = "<span style='color: #28a745; font-weight: bold;'>Voted</span>";
            $row_style = "background-color: #f8fff9;"; // Light green tint for voted rows
        } else {
            $status = "<span style='color: #6c757d; font-style: italic;'>Pending</span>";
            $row_style = "";
        }

        echo "<tr style='$row_style'>
                <td>" . $row['school_id'] . "</td>
                <td>" . $row['fullname'] . "</td>
                <td>" . $row['email'] . "</td>
                <td>" . $status . "</td> <!-- Display the Status here -->
                <td style='text-align:center;'>
                    <button class='btn btn-danger btn-sm delete-btn' 
                            data-id='" . $row['user_id'] . "' 
                            data-name='" . $row['fullname'] . "'>
                        Delete
                    </button>
                </td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='5' style='text-align:center; padding:20px;'>No voters found.</td></tr>";
}
?>