<?php
session_start();
session_destroy();
header("Location: ../index.php"); // Adjust path to redirect to blog page
exit;
?>
