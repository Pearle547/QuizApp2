<?php
session_start();
if($_SERVER['REQUEST_METHOD']!=='POST'){ 
    die("Logout must be POST to prevent CSRF - GET can be triggered by <img> tag"); 
}
session_destroy();
header("Location: index.php");
?>