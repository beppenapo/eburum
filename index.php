<?php
session_start();
require("inc/dbconfig.php");

$_SESSION['username'] = 'beppenapo';


#select tipo
$tipo="select * from $schema.tipo order by tipo asc;";
$tipoquery = pg_query($connection, $tipo);
#select stato conservazione
$sc="select * from $schema.sc order by sc asc;";
$scquery = pg_query($connection, $sc);
#select accessibilità
$acc="select * from $schema.acc order by acc asc;";
$accquery = pg_query($connection, $acc);

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
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

 <title>Eburum</title>
</head>
<body onload="init()">
 <div id="wrap">
 <?php require('inc/header.php'); ?>

  <div id="content">
   <section id="search">
     <div id="closeSearch" class="closeDiv"><a href="#"><i class="fa fa-times"></i></a></div>
   </section>
   
   <section id="scheda" class="aperto">
     <div id="closeScheda" class="closeDiv"><a href="#"><i class="fa fa-times"></i></a></div>
     <section id="user">
      <header>
       <span id="uPhoto"><img src=""></span>
       <span id="uName">Giuseppe Naponiello</span>
      </header>
     </section>
     <section id="lastPoi">
      <header>Ultimi punti inseriti</header>
      <article>
      
      </article>
     </section>
     <section id="filtri">
      <header>Cerca punto</header>
      <article>
       <input type="text" id="cercaNome" name="cerca" placeholder="cerca per nome">
       <select name="cerca" id="cercaTipo" required>
        <option value="" selected>-- tipo --</option>
        <?php
         while ($tipi = pg_fetch_assoc($tipoquery)) {
          echo '<option value="'.$tipi['id'].'">'.$tipi['tipo'].'</option>';
         }
        ?>
       <select>
       <select name="cerca" id="cercaSc" required>
        <option value="" selected>-- stato di conservazione --</option>
        <?php
         while ($stato = pg_fetch_assoc($scquery)) {
          echo '<option value="'.$stato['id'].'">'.$stato['sc'].'</option>';
         }
        ?>
       <select>
       <select name="cerca" id="cercaAcc" required>
        <option value="" selected>-- accessibilità --</option>
        <?php
         while ($access = pg_fetch_assoc($accquery)) {
          echo '<option value="'.$access['id'].'">'.$access['acc'].'</option>';
         }
        ?>
       <select>
       <label for="dis" class="pointer"><input id="dis" type="checkbox" name="dis"> Area accessibile ai disabili</label>
       <button type="button" id="filtra" name="filtra">filtra risultati</button>
       <span>Sess: <?php if(isset($_SESSION['email'])){echo $_SESSION['email'];}else{echo "no session";} ?></span>
      </article>
     </section>
     
     <section id="bottomScheda">
      <footer>
       <small>
        <a rel="license" href="http://creativecommons.org/licenses/by-sa/4.0/" title="Creative Commons Attribuzione - Condividi allo stesso modo 4.0 Internazionale" alt="Creative Commons Attribuzione - Condividi allo stesso modo 4.0 Internazionale"><i class="fa fa-creative-commons"></i> CC-BY-SA</a> |
        <a href="https://github.com/beppenapo/eburum" title="codice sorgente" alt="codice sorgente" target="_blank"><i class="fa fa-github"></i> sorgente</a> |
        <a href="#" title="dettagli sulle licenze utilizzate"><i class="fa fa-question"></i> licenze</a>
       </small>
      </footer>
     </section>
   </section>
   <section id="map">
    <div id="mapDiv"></div>
    <div id="geocoder">
     <input type="search" id="query" name="query" value="" placeholder="trova indirizzo"/>
     <input type="submit" name="find" id="geoSearch" class="fa fa-search" value="&#xf002" />
     <div id="resultSearch"><ul id="resultSearchList"></ul><span id='hideSearch'>chiudi lista</span></div>
    </div>
    <div id="baseLayer">
     <label for="sat" class="checked">Satellite</label>
     <label for="osm">Cartina</label>
     <input type="radio" name="base" id="sat" value="sat" onclick="map.setBaseLayer(realvista)" checked>
     <input type="radio" name="base" id="osm" value="osm" onclick="map.setBaseLayer(osm)">
    </div>
   </section>

   <section id="login"> 
    <div id="loginForm" class="borderRadius">
     <div id="closeLogin" class="closeDiv borderRadiusTop"><a href="#"><i class="fa fa-times"></i></a></div>
      <div id="usrReg">
        <h1>Se hai intenzione di fare il login è perché vuoi collaborare a migliorare la mappa di comunità...e per questo ti ringraziamo!!!</h1>
        <p>In questa prima fase di sperimentazione non ti verrà chiesto di creare alcun account, se sei qui è perché sicuramente hai già effettuato una regstrazione da qualche parte nella rete, a noi basta, quindi clicca su uno dei social presenti per accedere all'area di lavoro</p>
        <p>Per il momento è possibile accedere solo tramite facebook, un po' di pazienza e ne verranno aggiunti anche altri!</p>
        <a href="fbconfig.php" id="fbLog" class="button" target="_top"><i class="fa fa-facebook"></i> Facebook</a>
       </div>
    </div>
   </section>

  </div><!--content-->
 </div><!-- wrap -->
 
 <input type="hidden" id="sessione" value="<?php echo $_SESSION['id']; ?>">
 <script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
 <script src="http://openlayers.org/api/OpenLayers.js" type="text/javascript"></script>
 <script src="http://dev.openlayers.org/addins/loadingPanel/trunk/lib/OpenLayers/Control/LoadingPanel.js" type="text/javascript"></script>
 <script src="lib/jq.js" type="text/javascript"></script>
 <script src="lib/map.js" type="text/javascript"></script>
</body>
</html>
