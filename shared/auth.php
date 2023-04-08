<?php
// authentication check for all private pages

// do we have an active session var called 'user'?
session_start();
if (empty($_SESSION['user'])) {
    // if not, redirect to login
    header('location:login.php');

    // stop all other processing on this page
    exit();
}
?>