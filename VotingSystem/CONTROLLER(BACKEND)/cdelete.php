<?php
include("../MODEL/connect.php");

if (isset($_POST['candidate_id'])) {
    $id = intval($_POST['candidate_id']);

    // Fetch full candidate data before deleting
    $fetch = $conn->prepare("SELECT candidate_name, position_id, course, college FROM candidate WHERE candidate_id = ?");
    $fetch->bind_param("i", $id);
    $fetch->execute();
    $result = $fetch->get_result()->fetch_assoc();

    if ($result) {
        $name    = $result['candidate_name'];
        $pos_id  = $result['position_id'];
        $course  = $result['course'];
        $college = $result['college'];

        // Store in archive: use election_title for name, election_id for position_id
        // Also store course and college in the title for later restoration display
        $label = "$name | $course | $college";
        $stmt = $conn->prepare("INSERT INTO archive (election_id, election_title, total_eligible_voters, actual_votes_cast) VALUES (?, ?, 0, 0)");
        $stmt->bind_param("is", $pos_id, $label);

        if ($stmt->execute()) {
            // Delete from candidate table only after archiving succeeded
            $delete = $conn->prepare("DELETE FROM candidate WHERE candidate_id = ?");
            $delete->bind_param("i", $id);
            if ($delete->execute()) {
                echo "success";
            } else {
                echo "error_deleting";
            }
        } else {
            echo "error_archiving: " . $conn->error;
        }
    } else {
        echo "not_found";
    }
}
?>