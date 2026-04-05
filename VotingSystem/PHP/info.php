<?php
include("connect.php");

// Map your role IDs based on your latest message:
$roles = [
    ["id" => 1, "name" => "SUPER ADMIN", "color" => "#007bff"],
    ["id" => 2, "name" => "ELECTION OFFICER", "color" => "#555"], // Dark Gray
    ["id" => 4, "name" => "AUDITOR", "color" => "#800000"],         // Maroon
    ["id" => 3, "name" => "VOTERS", "color" => "#333"]           // Black/Dark
];

foreach ($roles as $role) {
    $role_id = $role['id'];
    $role_name = $role['name'];
    $color = $role['color'];

    // Determine if we show the course column (Admin usually doesn't have one in your UI)
    $showCourse = ($role_id != 1);

    echo "<div style='margin-bottom: 30px; font-family: sans-serif; background: white; padding: 10px; border-radius: 4px;'>
            <div style='background: $color; color: white; padding: 10px; font-weight: bold; width: 150px; margin-bottom: 5px; font-size: 0.9em;'>$role_name</div>
            <table style='width: 100%; border-collapse: collapse; background: white;'>
                <thead>
                    <tr style='background: #f8f9fa; text-align: left; font-size: 0.85em; color: #666; border-bottom: 1px solid #ddd;'>
                        <th style='padding: 10px; font-weight: normal;'>User ID</th>
                        <th style='font-weight: normal;'>Full Name</th>
                        <th style='font-weight: normal;'>Email</th>";
    
    if ($showCourse) echo "<th style='font-weight: normal;'>Course</th>";
    
    echo "              <th style='font-weight: normal;'>Action</th>
                    </tr>
                </thead>
                <tbody>";

    $sql = "SELECT * FROM users WHERE role_id = '$role_id' ORDER BY fullname ASC";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
       while($row = $result->fetch_assoc()) {
    echo "<tr>
            <td>{$row['school_id']}</td>
            <td>{$row['fullname']}</td> <!-- FIXED: Changed from fname/lname to fullname -->
            <td>{$row['email']}</td>
            <td>{$row['course']}</td>
            <td>
                <button class='view-btn' data-id='{$row['user_id']}'>View</button>
                <button class='del-btn' data-id='{$row['user_id']}'>Delete</button>
            </td>
          </tr>";
}
    } else {
        $cols = $showCourse ? 5 : 4;
        echo "<tr><td colspan='$cols' style='text-align:center; padding: 20px; color: #ccc;'>No records found.</td></tr>";
    }

    echo "</tbody></table></div>";
}
?>

