<?php

function OpenDatabase($DBHost, $DbUser, $DbPass, $DbName) {

	$dbh = mysql_connect($DBHost, $DbUser, $DbPass) or die("Keine Verbindung möglich: " . mysql_error());
	mysql_select_db($DbName) or die("Auswahl der Datenbank fehlgeschlagen");
	return $dbh;

}

?>

