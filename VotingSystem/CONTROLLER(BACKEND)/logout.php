<?php
session_start();
session_unset();
session_destroy();
header("Location: ../VIEW/HTML/login.html");
exit();
?>
