<?php
$dbhost = 'localhost';
$dbusername = 'beppe';
$password='alfaomega';
$database_name = 'arcteam';
$connection = pg_connect("host=$dbhost user=$dbusername password=$password dbname=$database_name")
	or die ("Impossibile connettersi al server \n" . pg_last_error($connection));

?>
