<?php
include("MODEL/connect.php");
$res = $conn->query("DESCRIBE elections");
while($row = $res->fetch_assoc()) {
    echo $row['Field'] . " (" . $row['Type'] . ")\n";
}
?>
