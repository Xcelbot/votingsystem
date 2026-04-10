<?php
// Mock a POST request to election_mgmt.php
$_POST['action'] = 'get_elections';
include("CONTROLLER(BACKEND)/election_mgmt.php");
?>
