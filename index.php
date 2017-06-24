<?php
session_start();
require("inc/login_modal.php");
?>
<!DOCTYPE html>
<html lang="it">
    <head>
        <?php require("inc/head.php"); ?>
        <link href="css/mappa.css" rel="stylesheet" media="screen" />
    </head>
    <body>
        <header><?php require("inc/header.php"); ?></header>
        <section id="mappa"><?php require("inc/toolmap.php"); ?></section>
        <div id="modalWrap">

        </div>
        <footer><?php require("inc/footer.php"); ?></footer>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/openlayers/4.1.1/ol.js"></script>
        <?php require("inc/librerie.php"); ?>
        <script src="js/map.js"></script>
    </body>
</html>
