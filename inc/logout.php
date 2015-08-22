<?php 
session_start();
session_unset();
    $_SESSION['id'] = NULL;
    $_SESSION['username'] = NULL;
    $_SESSION['name'] = NULL;
    $_SESSION['email'] =  NULL;
    $_SESSION['logout'] = NULL;
header("Location: ../index.php");        
?>
