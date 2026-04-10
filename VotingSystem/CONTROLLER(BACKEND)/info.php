<?php
include("../MODEL/connect.php");

// 1. Handle Search Input (Sanitized for safety)
$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';
$whereClause = "";
if (!empty($search)) {
    $whereClause = " WHERE school_id LIKE '%$search%' OR fullname LIKE '%$search%' ";
}

// 2. Map Role IDs to readable names and styles (Aligns with your 'roles' table)
$roleSettings = [
    1 => ["name" => "SUPER ADMIN", "color" => "#007bff", "showCourse" => false],
    2 => ["name" => "ELECTION OFFICER", "color" => "#555555", "showCourse" => true],
    4 => ["name" => "AUDITOR", "color" => "#800000", "showCourse" => true],
    3 => ["name" => "VOTERS", "color" => "#333333", "showCourse" => true]
];

$usersByRole = [];

// 3. Fetch users based on search
$sql = "SELECT * FROM users $whereClause ORDER BY fullname ASC";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $roleId = $row['role_id'];
        $usersByRole[$roleId][] = $row;
    }
}

// 4. LOAD THE VIEW TEMPLATE
include("../VIEW/info_template.php");
?>