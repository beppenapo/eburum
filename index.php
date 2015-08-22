<?php
session_start();
//require_once("inc/db.php");
?>
<!DOCTYPE html>
<html>
<head>
 <meta charset="utf-8" />
 <meta name="generator" content="Sublime Text2" >
 <meta name="author" content="Giuseppe Naponiello" >
 <meta name="robots" content="INDEX,FOLLOW" />
 <meta name="copyright" content="&copy;2015 Arc-Team" />
 <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=yes" />
 <meta name="description" content="Mappa di comunità libera e condivisa del territorio di Eboli e della valle del Sele" />
 <meta name="keywords"  content="webgis, comunity, storia, archeologia, ambiente, open source, open data" />
 <!-- Start Of Social Graph Protocol Meta Data -->
 <meta property="og:locale" content="it_IT" />
 <meta property="og:type" content="website" />
 <meta property="og:description" content="Eburum" />
 <meta property="og:title" content="Eburum" />
 <meta property="og:url" content="http://184.106.205.13/eburum/" />
 <meta property="og:site_name" content="Eburum" />
 <!--<meta property="fb:admins" content="833954272" />-->
 <!-- End Of Social Graph Protocol Meta Data -->

 <link href="css/reset.css" rel="stylesheet" media="screen" />
 <link href="css/style.css" rel="stylesheet" media="screen" />
 <link href="css/icofont/css/font-awesome.min.css" rel="stylesheet" media="screen" />

 <title>Eburum</title>
</head>
<body onload="init()">
 <div id="wrap">
  <header id="header">
   <div id="titleWrap" class="head">
    <h1 class="textShadow">Eburum</h1>
    <h2 class="textShadow">Mappa libera e condivisa delle evidenze storiche, archeologiche e naturalistiche del territorio di Eboli</h2>
   </div>
   <div id="headMenuWrap" class="head">
    <ul class="headmenu">
     <!--<li><a href="#" class="textShadow"><i class="fa fa-home"></i></a></li>-->
     <li><a href="#" class="openScheda textShadow"><i class="fa fa-map-marker"></i></a></li>
     <li><a href="#" class="openLogin textShadow"><i class="fa fa-user"></i></a></li>
     <!--<li><a href="#" class="textShadow"><i class="fa fa-question"></i></a></li>-->
     <li><a href="#" class="openSearch textShadow"><i class="fa fa-search"></i></a></li>
    </ul>
   </div> 
  </header>

  <div id="content">
   <section id="search">
     <div id="closeSearch" class="closeDiv"><a href="#"><i class="fa fa-times"></i></a></div>
   </section>
   <section id="scheda">
     <div id="closeScheda" class="closeDiv"><a href="#"><i class="fa fa-times"></i></a></div>
   </section>
   <section id="map">
    <div id="mapDiv"></div>
    <div id="geocoder">
     <input type="search" id="query" name="query" value="" placeholder="trova indirizzo"/>
     <input type="submit" name="find" id="geoSearch" value="cerca" />
     <div id="resultSearch"><ul id="resultSearchList"></ul><span id='hideSearch'>chiudi lista</span></div>
    </div>
   </section>
   <section id="login">
    <div id="loginForm" class="borderRadius">
     <div id="closeLogin" class="closeDiv borderRadiusTop"><a href="#"><i class="fa fa-times"></i></a></div>
     <?php if ($_SESSION['id']): ?> 
      <div class="span4">
       <ul class="nav nav-list">
        <li class="nav-header">Image</li>
        <li><img src='https://graph.facebook.com/<?php echo $_SESSION["id"]; ?>/picture?type=large' height="20"/></li>
        <li><?php echo $_SESSION['fullname']; ?></li>
        <div><a href="logout.php">Logout</a></div>
       </ul>
      </div>
     <?php else: ?>     <!-- Before login --> 
     <form action="" method="post" class="log">
       <h1 class="textShadow toggle">Utente registrato <span>Inserisci dati login.</span></h1>
       <div id="usrReg" class="toggled">
        <input id="email" type="email" name="email" placeholder="inserisci email" />
        <input id="pwd" type="password" name="pwd" placeholder="Inserisci password" />
        <a href="fbconfig.php" target="_top">Login with Facebook</a>
        <label>
         <span>&nbsp;</span> 
         <input type="button" class="button" value="login" /> 
        </label>
       </div>    
     </form>

     <form action="" method="post" class="log log2">
       <h1 class="textShadow toggle">Nuovo utente <span>I campi con l'asterisco sono obbligatori.</span></h1>
       <div id="newUsr" class="toggled">
        <textarea id="username" name="username" placeholder="*Username"></textarea>
        <input id="email" type="text" name="email" value='' placeholder="*Inserisci email" />
        <input id="pwd" type="password" name="pwd" value='' placeholder="*Inserisci password" />
        <input id="checkPwd" type="password" name="checkPwd" value='' placeholder="*Inserisci di nuovo la password" />
        <label for="radio1" class="inputLabel"><input type="radio" name="formUsrRadio" id="radio1" value="1" checked /> Voglio che la mia mail sia visibile a tutti gli utenti</label>
        <label for="radio2" class="inputLabel"><input type="radio" name="formUsrRadio" id="radio2" value="2" /> Voglio che la mia mail sia visibile solo agli utenti registrati</label>
        <label for="radio3" class="inputLabel"><input type="radio" name="formUsrRadio" id="radio3" value="3" /> Non voglio che la mia mail sia visibile</label>
        <textarea id="link" name="link" placeholder="Inserisci un link di riferimento"></textarea>
        <textarea id="descrUsr" name="descrUsr" placeholder="Inserisci una breve descrizione su di te e sul tuo lavoro" style="height:50px;"></textarea>
        <input type="button" class="button" name="signin" value="registrati!" /> 
        <div style="text-align:center; color:#CC4B1C;margin:5px auto;" class="errorDiv"></div>
       </div>    
     </form>
     <?php endif ?>
    </div>
   </section>
  </div>
 </div><!-- wrap -->
 <script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
 <script src="http://openlayers.org/api/OpenLayers.js" type="text/javascript"></script>
 <script src="lib/jq.js" type="text/javascript"></script>
 <script src="lib/map.js" type="text/javascript"></script>
</body>
</html>
