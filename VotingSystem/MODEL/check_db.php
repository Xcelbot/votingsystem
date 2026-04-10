<?php
include("MODEL/connect.php");
$res = $conn->query("DESCRIBE positions");
while($row = $res->fetch_assoc()) {
    echo $row['Field'] . " (" . $row['Type'] . ")\n";
}
?>
