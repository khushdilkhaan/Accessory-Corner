<?php
// Start the session
session_start();

// Destroy the session data
session_destroy();

// Redirect the user to the index page
header("Location: ../index.php");
exit;
?>