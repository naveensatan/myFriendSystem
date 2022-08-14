<?php
    session_start(); //start/continue session
    session_destroy(); //destroy the session and variables
    header("location:index.php"); //redirect to index page
?>