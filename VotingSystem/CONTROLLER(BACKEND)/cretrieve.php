<?php
include ("../MODEL/connect.php");

// Fetch candidates joined with positions table for real position names
$sql = "SELECT c.*, p.position_name 
        FROM candidate c
        LEFT JOIN positions p ON c.position_id = p.position_id
        WHERE c.is_archived = 0
        ORDER BY p.priority_order ASC, c.candidate_name ASC";
$result = $conn->query($sql);

$rows = [];
if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $rows[] = $row;
    }
}

// Output as table rows grouped by position
if (empty($rows)) {
    echo '<tr class="empty-row"><td colspan="5" style="text-align:center; padding:20px; color:#666; font-style:italic;">No candidates registered yet.</td></tr>';
} else {
    foreach ($rows as $row) {
        $posName = htmlspecialchars($row['position_name'] ?? 'Unknown');
        $name    = htmlspecialchars($row['candidate_name']);
        $course  = htmlspecialchars($row['course']);
        $college = htmlspecialchars($row['college']);
        $id      = $row['candidate_id'];
        $posId   = $row['position_id'];

        echo '<tr>
            <td>' . $posName . '</td>
            <td>' . $name . '</td>
            <td>' . $course . '</td>
            <td>' . $college . '</td>
            <td style="text-align:center;">
                <button class="btn-edit-c edit-btn"
                    data-id="' . $id . '"
                    data-name="' . $name . '"
                    data-course="' . $course . '"
                    data-college="' . $college . '"
                    data-pos="' . $posId . '">Edit</button>
                <button class="btn-del delete-btn" data-id="' . $id . '">Archive</button>
            </td>
        </tr>';
    }
}
?>
