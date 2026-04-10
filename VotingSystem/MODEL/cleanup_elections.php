<?php
include("../MODEL/connect.php");
// Remove elections where title is empty or just whitespace
$sql = "DELETE FROM elections WHERE TRIM(title) = ''";
if ($conn->query($sql)) {
    echo "Cleanup successful. Removed " . $conn->affected_rows . " blank rows.\n";
} else {
    echo "Cleanup error: " . $conn->error . "\n";
}
?>
