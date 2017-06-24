<?php
session_start();
require("../class/login.class.php");
$email=filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
$log = new Login;
$log->newUsr($email);
echo $log->msg;
?>
