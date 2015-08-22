<?php
session_start();
//require_once("inc/db.php");
?>
<!DOCTYPE html>
<html>
<head>
 <meta charset="utf-8" />
 <meta name="generator" content="gedit" >
 <meta name="author" content="Giuseppe Naponiello" >
 <meta name="robots" content="INDEX,FOLLOW" />
 <meta name="copyright" content="&copy;2014 Arc-Team" />
 <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=yes" />
 <meta name="description"  content="WebGis e bibliografia condivisa sugli scavi e sugli studi di antropolgia fisica rilasciati con licenze open data" />
 <meta name="keywords"  content="webgis, antropologia, bioarcheologia, archeologia, medicina, paleopatologia, osteometria, open data, " />
 <!-- Start Of Social Graph Protocol Meta Data -->
 <meta property="og:locale" content="it_IT" />
 <meta property="og:type" content="website" />
 <meta property="og:description" content="OpenBones" />
 <meta property="og:title" content="OpenBones" />
 <meta property="og:url" content="http://www.openbones.it" />
 <meta property="og:site_name" content="OpenBones" />
 <!--<meta property="fb:admins" content="833954272" />-->
 <!-- End Of Social Graph Protocol Meta Data -->

 <link href='http://fonts.googleapis.com/css?family=Maven+Pro:400,700' rel='stylesheet' type='text/css' />
 <link href="css/reset.css" rel="stylesheet" media="screen" />
 <link href="css/style.css" rel="stylesheet" media="screen" />
 <link href="css/icofont/css/font-awesome.min.css" rel="stylesheet" media="screen" />

 <script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
 <script src="http://openlayers.org/api/OpenLayers.js" type="text/javascript"></script>

 <title>OpenBones</title>
</head>
<body onload="init()">
 <div id="wrap">
  <header id="header">
   <h1 class="head textShadow"><a href="#">#OpenBones</a></h1>
   <ul class="headmenu">
    <li><a href="#" class="textShadow"><i class="fa fa-home"></i></a></li>
    <li><a href="#" class="openScheda textShadow"><i class="fa fa-map-marker"></i></a></li>
    <li><a href="#" class="openLogin textShadow"><i class="fa fa-user"></i></a></li>
    <li><a href="#" class="textShadow"><i class="fa fa-question"></i></a></li>
    <li><a href="#" class="openSearch textShadow"><i class="fa fa-search"></i></a></li>
   </ul>
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
    <div id="geocoder" class="opacity">
     <form name="input" action="javascript: submitform();" method="post" class="geocoder">
      <input type="text" id="query" name="query" value="" placeholder="trova indirizzo"/>
      <input type="submit" name="find" value="cerca" />
     </form>
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

<script type="text/javascript">
//JQUERY//
  $(document).ready(function() {
   $('#closeSearch a').click(function(){
    $('#search').removeClass('aperto');
    $('#search, #map').animate({right:'-=16%'});
   });
   $('.openSearch').click(function(){
    $('#search').toggleClass('aperto');
    if($('#search').hasClass('aperto')){
     $('#search, #map').animate({right:'+=16%'});
    }else{
     $('#search, #map').animate({right:'-=16%'});
    }    
   });

   $('#closeScheda a').click(function(){
    $('#scheda').removeClass('aperto');
    $('#scheda, #map').animate({left:'-=20%'});
   });
   $('.openScheda').click(function(){
    $('#scheda').toggleClass('aperto');
    if($('#scheda').hasClass('aperto')){
     $('#scheda, #map').animate({left:'+=20%'});
    }else{
     $('#scheda, #map').animate({left:'-=20%'});
    }    
   });
   
   $('#login').hide();
   $('.openLogin').click(function(){$('#login').fadeIn("fast");});
   $('#closeLogin a').click(function(){$('#login').fadeOut("fast");});

   $('#newUsr').hide();
   $('.toggle').click(function(){$('.toggled').slideToggle('fast');});

   $('#query').focus(function(){$(this).addClass('focus');}).blur(function(){$(this).removeClass('focus');});
   $('#geocoder').hover(
    function(){$(this).stop().fadeTo('slow', 1);},
    function(){$(this).stop().fadeTo('slow', 0.5);}
   );

   $('input[name="signin"]').click(function(){
     var username = $('#username').val();
     var email = $('#email').val();
     var checkPwd = $('#checkPwd').val();
     var pwd = $('#pwd');
     var privacy = $("input[name='formUsrRadio']:checked").val();
     var link = $('#link').val();
     var descrUsr = $('#descrUsr').val();
     console.log(username+' '+email+' '+pwd);
     //controllo i campi obbligatori
     if(!username){
       $('#username').addClass('error');
       //$('.errorDiv').text('Inserisci uno username, il tuo nome vero o il nome dell\'azienda');
       return false;
     }else{
       $('#username').removeClass('error');
       //$('.errorDiv').text('');
     }
     if(!email){
       $('#email').addClass('error');
       //$('.errorDiv').text('Inserisci un indirizzo email valido');
       return false;
     }else{
       $('#email').removeClass('error');
       //$('.errorDiv').text('');
     }
     if(!pwd){
       $('#pwd').addClass('error');
       //$('.errorDiv').text('Devi digitare una password!');
       return false;
     }else{
       $('#pwd').removeClass('error');
       //$('.errorDiv').text('');
     }
     if(pwd && !checkPwd){
       $('#checkPwd').addClass('error');
       //$('.errorDiv').text('Devi ridigitare la password appena inserita!');
       return false;
     }else{
       $('#checkPwd').removeClass('error');
       //$('.errorDiv').text('');
     }
   });
  });

//OPENLAYERS//
var map,format,extent;

function init() {
 OpenLayers.ProxyHost = "/cgi-bin/proxy.cgi?url=";
 format = 'image/png';

 map = new OpenLayers.Map('mapDiv', {
      projection: new OpenLayers.Projection("EPSG:3857"),
      displayProjection: new OpenLayers.Projection("EPSG:4326"),
      units: "m",
      maxResolution: "auto",
      controls: [
       new OpenLayers.Control.Navigation(),
       new OpenLayers.Control.MousePosition(),
       new OpenLayers.Control.Zoom(),
       new OpenLayers.Control.TouchNavigation({dragPanOptions: {enableKinetic: true}})
      ]
 });

 var arrayOSM = ["http://otile1.mqcdn.com/tiles/1.0.0/map/${z}/${x}/${y}.jpg",
            "http://otile2.mqcdn.com/tiles/1.0.0/map/${z}/${x}/${y}.jpg",
            "http://otile3.mqcdn.com/tiles/1.0.0/map/${z}/${x}/${y}.jpg",
            "http://otile4.mqcdn.com/tiles/1.0.0/map/${z}/${x}/${y}.jpg"];
            
 var osm = new OpenLayers.Layer.OSM("MapQuest-OSM Tiles", arrayOSM, {
                attribution: "Data, imagery and map information provided by <a href='http://www.mapquest.com/'  target='_blank'>MapQuest</a>, <a href='http://www.openstreetmap.org/' target='_blank'>Open Street Map</a> and contributors, <a href='http://creativecommons.org/licenses/by-sa/2.0/' target='_blank'>CC-BY-SA</a>  <img src='http://developer.mapquest.com/content/osm/mq_logo.png' border='0'>",
                transitionEffect: "resize"
 });
 map.addLayer(osm);
 /*
 var realvista = new OpenLayers.Layer.WMS("real", "http://213.215.135.196/reflector/open/service?", {
        layers: 'rv1',
        format: 'image/jpeg',
        attribution: "RealVista1.0 WMS OPEN di e-GEOS SpA - CC BY SA"
 });
 map.addLayer(realvista);
 */

 
 extent = new OpenLayers.Bounds(712648.863, 4351392.688, 2245377.457, 5967512.923);
 if (!map.getCenter()) {map.zoomToExtent(extent);}
}

function submitform() {
   var queryString = document.forms[0].query.value;
   OpenLayers.Request.POST({
       url: "http://www.openrouteservice.org/php/OpenLSLUS_Geocode.php",
       scope: this,
       failure: this.requestFailure,
       success: this.requestSuccess,
       headers: {"Content-Type": "application/x-www-form-urlencoded"},
       data: "FreeFormAdress=" + encodeURIComponent(queryString) + "&MaxResponse=1"
   });
}

function requestSuccess(response) {
   var format = new OpenLayers.Format.XLS();
   var output = format.read(response.responseXML);
   if (output.responseLists[0]) {
       var geometry = output.responseLists[0].features[0].geometry;
       var foundPosition = new OpenLayers.LonLat(geometry.x, geometry.y).transform(
               new OpenLayers.Projection("EPSG:4326"),
               map.getProjectionObject()
               );
       map.setCenter(foundPosition, 16);
   } else {
       alert("Nessun indirizzo trovato!");
   }
}

function requestFailure(response) {
   alert("Errore di comunicazione con il server, riprova!");
} 
</script>
</body>
</html>
