<?php
require 'inc/dbconfig.php';
function checkuser($ffname,$femail){
  $check = pg_query($connection,"select email from eburum.utenti where email='$femail'");
  $check = pg_num_rows($check);
  if ($check == 0) { 
    $query = "INSERT INTO utenti (utente, email, social) VALUES ('$ffname','$femail', 1)";
    pg_query($connection, $query);
  } 
  $query = "INSERT INTO eburum.login (fbmail) VALUES ('$femail');";
  $result = pg_query($connection, $query);
  if(!$result){	die("Errore nella query: \n" . pg_last_error($connection));}	
}
?>
