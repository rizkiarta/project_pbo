<?php
session_start();
session_unset();
session_destroy();

// Redirect ke welcome.php
header("Location: welcome.php");
exit;
?>