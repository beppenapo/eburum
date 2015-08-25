<?php
$dbhost = '184.106.205.13';
$dbusername = 'beppe';
$password='alfaomega';
$database_name = 'arcteam';
$schema = 'eburum';
$connection = pg_connect("host=$dbhost user=$dbusername password=$password dbname=$database_name")
	or die ("Impossibile connettersi al server \n" . pg_last_error($connection));

?>
