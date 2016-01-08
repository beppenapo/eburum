<?php
    require("dbconfig.php");
    $q="SELECT poi.id, poi.nome, tipo.tipo, sc.sc, acc.acc, dis.dis, poi.descrizione
            FROM eburum.poi, eburum.tipo, eburum.sc, eburum.acc, eburum.dis
            WHERE poi.tipo = tipo.id AND poi.sc = sc.id AND poi.acc = acc.id AND poi.dis = dis.id AND poi.id = ".$_POST['id'];
    $e=pg_query($connection,$q);
    $r = pg_fetch_array($e);
    $poi = array();
    $poi['id'] = $r['id'];
    $poi['nome'] = $r['nome'];
    $poi['tipo'] = $r['tipo'];
    $poi['sc'] = $r['sc'];
    $poi['acc'] = $r['acc'];
    $poi['dis'] = $r['dis'];
    $poi['descrizione'] = $r['descrizione'];
    echo json_encode($poi);
?>