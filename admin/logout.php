<?php
require('../inc/essential.php');
ob_start();
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Debugging: Check session status and variables
if (!empty($_SESSION)) {
    echo "Session variables before unset: ";
    print_r($_SESSION);
}

// Destroy session
session_unset();
session_destroy();

// Debugging: Confirm session destruction
if (empty($_SESSION)) {
    echo "Session destroyed successfully.";
} else {
    echo "Failed to destroy session.";
}

// Redirect
header("Location: index.php");
exit;
?>