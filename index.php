<?php
session_start();
require("inc/db.php");
#get extent
$extq="select st_extent(geom) as ext from eburum.poi;";
$extres = pg_query($connection,$extq);
$extarr = pg_fetch_array($extres);
$ext = substr($extarr['ext'], 4, -1);
$ext = str_replace(" ", ",",$ext);

#select tipo
$tipo="select * from $schema.tipo order by tipo asc;";
$tipoquery = pg_query($connection, $tipo);
while ($tipi = pg_fetch_assoc($tipoquery)) { $tipoList .= '<option value="'.$tipi['id'].'">'.$tipi['tipo'].'</option>'; }
#select stato conservazione
$sc="select * from $schema.sc order by sc asc;";
$scquery = pg_query($connection, $sc);
while ($stato = pg_fetch_assoc($scquery)) { $scList .= '<option value="'.$stato['id'].'">'.$stato['sc'].'</option>'; }
#select accessibilità
$acc="select * from $schema.acc order by acc asc;";
$accquery = pg_query($connection, $acc);
while ($access = pg_fetch_assoc($accquery)) { $accList .= '<option value="'.$access['id'].'">'.$access['acc'].'</option>'; }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="generator" content="Atom" >
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
        <meta property="og:url" content="http://91.121.82.80/eburum/" />
        <meta property="og:site_name" content="Eburum" />
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet" media="all" >
        <link href="css/style.css" rel="stylesheet" media="screen" />
        <title>Eburum</title>
    </head>
    <body onload="init()">
        <div id="wrap">
            <input type="hidden" name="ext" value="<?php echo $ext; ?>" >
            <?php require('inc/header.php'); ?>
            <div id="content">
                <section id="search">
                    <div id="closeSearch" class="closeDiv" title="nascondi pannello"><i class="fa fa-arrow-right cursor"></i></div>
                    <header class="head"><h1></h1></header>
                    <section class='searchMain'>
                        <article>
                            <h2>Dati generali</h2>
                            <label id="tipo"><span></span></label>
                            <label id="stato">stato di conservazione <span></span></label>
                            <label id="acc"></label>
                            <label id="dis"></label>
                            <h2>Descrizione:</h2>
                            <div id="descrizione"></div>
                        </article>
                    </section>
                    <section class='searchComment'>
                        <header class="commentToggle">Commenti</header>
                        <div id="commentWrap">
                            <article></article>
                        </div>
                    </section>
                </section>
                <section id="scheda" class="aperto">
                    <div id="closeScheda" class="closeDiv" title="nascondi pannello"><i class="fa fa-arrow-left cursor"></i></div>
                    <section id="user">
                        <header>
                        <?php if(isset($_SESSION['id'])){ ?>
                            <span id="uPhoto"></span>
                            <span id="uName"><?php echo $_SESSION["utente"]; ?></span>
                        <?php }else{ ?>
                            <a href="#" class="openLogin textShadow" title="entra nell'area di lavoro"><i class="fa fa-user"></i> Effettua il login</a>
                        <?php } ?>
                        </header>
                    </section>
                    <?php if(isset($_SESSION['id'])){ ?>
                    <section class="menuContent">
                        <header class="mainMenu" data-sub="sub1">Menù personale</header>
                        <article id="sub1" class="subMenu">
                            <?php require("inc/usermenu.php"); ?>
                        </article>
                    </section>
                    <?php } ?>
                    <section id="lastPoi" class="menuContent">
                        <header class="mainMenu" data-sub="sub2">Ultimi punti inseriti</header>
                        <article id="sub2" class="subMenu">
                            <ul>
                                <?php
                                $lastq="select id, nome, st_x(geom) as lon, st_y(geom) as lat from eburum.poi order by id desc limit 5;";
                                $lastex = pg_query($connection,$lastq);
                                while($last = pg_fetch_array($lastex)){
                                    echo "<li class='lastPoi cursor' data-id='".$last['id']."' data-ll='".$last['lon'].",".$last['lat']."'>".$last['nome']."</li>";
                                }
                                ?>
                            </ul>
                        </article>
                    </section>
                    <section id="geocoder" class="menuContent">
                        <header class="mainMenu" data-sub="sub3">Cerca Indirizzo</header>
                        <article id="sub3" class="subMenu">
                            <input type="search" id="query" name="query" class="cercaButt" value="" placeholder="Es.: Eboli viale amendola" >
                            <input type="submit" name="find" id="geoSearch" class="fa fa-search cercaButt" value="&#xf002" >
                            <div id="resultSearch"><ul id="resultSearchList"></ul><span id='hideSearch'>chiudi lista</span></div>
                        </article>
                    </section>
                    <section id="filtri" class="menuContent">
                        <header class="mainMenu last" data-sub="sub4">Cerca punto</header>
                        <article id="sub4" class="subMenu">
                            <input type="text" name="nome" class="cercaButt" placeholder="cerca per nome">
                            <select name="tipo" class="cercaButt">
                                <option value="" selected>-- tipo --</option>
                                <?php  echo $tipoList; ?>
                            </select>
                            <select name="sc" class="cercaButt">
                                <option value="" selected>-- stato di conservazione --</option>
                                <?php  echo $scList; ?>
                            </select>
                            <select name="acc" class="cercaButt">
                                <option value="" selected>-- accessibilità --</option>
                                <?php  echo $accList; ?>
                            </select>
                            <label for="dis" class="cursor labelForm"><input id="dis" type="checkbox" name="dis"> Area accessibile ai disabili</label>
                            <button type="button" id="filtra" name="filtra">filtra risultati</button>
                        </article>
                    </section>
                    <!-- <section id="bottomScheda">
                        <footer>
                            <small>
                                <a rel="license" href="http://creativecommons.org/licenses/by-sa/4.0/" title="Creative Commons Attribuzione - Condividi allo stesso modo 4.0 Internazionale" alt="Creative Commons Attribuzione - Condividi allo stesso modo 4.0 Internazionale"><i class="fa fa-creative-commons"></i> CC-BY-SA</a> |
                                <a href="https://github.com/beppenapo/eburum" title="codice sorgente" alt="codice sorgente" target="_blank"><i class="fa fa-github"></i> sorgente</a> |
                                <a href="#" title="dettagli sulle licenze utilizzate"><i class="fa fa-question"></i> licenze</a>
                            </small>
                        </footer>
                    </section> -->
                </section>
                <section id="map">
                    <div id="mapDiv"></div>
                    <div id="baseLayer">
                        <label for="sat" class="checked"><i class="fa fa-globe"></i></label>
                        <label for="osm"><i class="fa fa-map"></i></label>
                        <input type="radio" name="base" id="sat" value="realvista" onclick="map.setBaseLayer(realvista)" checked>
                        <input type="radio" name="base" id="osm" value="osm" onclick="map.setBaseLayer(osm)">
                    </div>
                    <div id="panel" class="customEditingToolbar"></div>
                    <div id="switcher">
                        <ul>
                            <li class="area cursor transition">Area naturalistica</li>
                            <li class="edificio cursor transition">Edificio storico</li>
                            <li class="monumento cursor transition">Monumento</li>
                            <li class="sito cursor transition">Sito archeologico</li>
                        </ul>
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
            </div>
        </div>
        <?php require('inc/poiForm.php'); ?>
        <input type="hidden" id="sessione" value="<?php echo $_SESSION['id']; ?>">
        <script src="http://code.jquery.com/jquery-latest.min.js"></script>
        <script src="http://openlayers.org/api/OpenLayers.js"></script>
        <script src="lib/LoadingPanel.js"></script>
        <script src="lib/ckeditor/ckeditor.js"></script>
        <script src="lib/ckeditor/adapters/jquery.js"></script>
        <script src="lib/funzioni.js"></script>
        <script src="lib/map.js"></script>
        <script src="lib/jq.js"></script>
    </body>
</html>
