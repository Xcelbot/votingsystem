<?php
include("MODEL/connect.php");
$res = $conn->query("SELECT * FROM elections");
echo "Count: " . $res->num_rows . "\n";
while($row = $res->fetch_assoc()) {
    print_r($row);
}
?>
