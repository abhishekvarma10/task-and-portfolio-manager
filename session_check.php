<?php
session_start(); // Start the session

// Check if the user is logged in and registered
$isLoggedIn = isset($_SESSION['user_id']);
$isRegistered = isset($_SESSION['userRegistered']) && $_SESSION['userRegistered'];
?>
