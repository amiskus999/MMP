<?php 
/**
 * File: Logout.php
 * Description: Logs out the current user by destroying the session and redirects to the index page.
 */
    session_start();
    session_destroy();
    header('Location: index.php');
    exit();
?>