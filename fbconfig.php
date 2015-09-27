<?php
ini_set('display_errors', 1);
require 'inc/src/facebook.php'; 
require 'inc/functions.php';  
$facebook = new Facebook(array(
  'appId'  => '377540852406533',   // Facebook App ID 
  'secret' => '644174ae1cd1069aeee159bacc72aa94',  // Facebook App Secret
  'cookie' => true,
));
$user = $facebook->getUser();

if ($user) {
  try {
    $user_profile = $facebook->api('/me');
    $fbid = $user_profile['id'];                 // To Get Facebook ID
    $fbuname = $user_profile['username'];  // To Get Facebook Username
    $fbfullname = $user_profile['name']; // To Get Facebook full name
    $femail = $user_profile['email'];    // To Get Facebook email ID

    $check = pg_query($connection,"select email from eburum.utenti where email='$femail'");
    $check = pg_num_rows($check);
    if ($check == 0) { 
     $query = "INSERT INTO eburum.utenti (utente, email, social) VALUES ('$fbfullname','$femail', $fbid)";
     $nu = pg_query($connection, $query);
     if(!$nu){die("utente non inserito: \n" . pg_last_error($connection));}
    } 
    $query = "INSERT INTO eburum.login (email) VALUES ('$femail');";
    $result = pg_query($connection, $query);
    if(!$result){die("accesso non registrato: \n" . pg_last_error($connection));}
    
/* ---- Session Variables -----*/
    $_SESSION['id'] = $fbid;           
    $_SESSION['username'] = $fbuname;
    $_SESSION['fullname'] = $fbfullname;
    $_SESSION['email'] =  $femail;
    

  } catch (FacebookApiException $e) {
    error_log($e);
    $user = null;
  }
}
if ($user) {
  header("Location: index.php");
} else {
 $loginUrl = $facebook->getLoginUrl(array('scope' => 'email', ));
 header("Location: ".$loginUrl);
}
?>
