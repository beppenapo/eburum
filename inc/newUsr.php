<?php
session_start();
require 'dbconfig.php';
$utente=pg_escape_string($_POST['cognome'])." ".pg_escape_string($_POST['nome']);
$email=pg_escape_string($_POST['email']);



?>
