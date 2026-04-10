<?php
include("../MODEL/connect.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['archive_id'])) {
    $archive_id = intval($_POST['archive_id']);
    $action = $_POST['action'];

    if ($action == 'restore') {
        // Fetch from archive
        $stmt = $conn->prepare("SELECT * FROM archive WHERE archive_id = ?");
        $stmt->bind_param("i", $archive_id);
        $stmt->execute();
        $data = $stmt->get_result()->fetch_assoc();

        if ($data) {
            // Parse the label "name | course | college"
            $parts = explode(' | ', $data['election_title']);
            $name    = trim($parts[0] ?? $data['election_title']);
            $course  = trim($parts[1] ?? 'Unknown');
            $college = trim($parts[2] ?? 'Unknown');
            $pos_id  = intval($data['election_id']);

            // Re-insert candidate
            $rest = $conn->prepare("INSERT INTO candidate (candidate_name, course, college, position_id, election_id, user_id) VALUES (?, ?, ?, ?, 1, 0)");
            $rest->bind_param("sssi", $name, $course, $college, $pos_id);

            if ($rest->execute()) {
                $conn->query("DELETE FROM archive WHERE archive_id = $archive_id");
                echo "success";
            } else {
                echo "error_restoring: " . $conn->error;
            }
        } else {
            echo "not_found";
        }

    } elseif ($action == 'permanent_delete') {
        $del = $conn->prepare("DELETE FROM archive WHERE archive_id = ?");
        $del->bind_param("i", $archive_id);
        echo $del->execute() ? "success" : "error: " . $conn->error;
    }
}
?>
