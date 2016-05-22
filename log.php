<?php
session_start();
require_once("inc/db.php");
if($_GET['t']=='out'){
  session_destroy();
  header("Location:index.php");
}
?>
