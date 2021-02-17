<html>
	<meta charset="utf8">
	<head>
	<title>Beispiel Bücherei</title>
	</head>
	<body>
	Aktuelle Verleihvorgänge<br>
	
<?php
	// Werte aus Formular abfragen
	// var_dump($_GET);
	// var_dump($_POST);
	
	$KundenID	= $_POST['kunde'];
	$BuchID		= $_POST['buch'];
	
	// Werte prüfen
	// empty($KundenID)	=> true, wenn null, '', 0
	// is_numeric($KundenID) => true, wenn Zahl
	
	// Datenbank Verbindung aufbauen
	$DB_Server = 'localhost';
	$DB_User = 'root';
	$DB_Pass = '';
	$DB_Name = 'mydb';
	// DB-Verbindung aufbauen
	$mysqli = new mysqli($DB_Server, $DB_User, $DB_Pass, $DB_Name);
	if ($mysqli->connect_errno) {
		echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}
	// echo $mysqli->host_info . "\n";

	// Datenbank abfragen
	$sql = 'SELECT buecher.*, verleih.*, kunden.* FROM verleih';
	$sql .= ' INNER JOIN kunden ON verleih.KUNDEN_KundenID=kunden.KundenID';
	$sql .= ' INNER JOIN buecher ON verleih.BUECHER_BuchID=buecher.BuchID';
	$sql .= ' WHERE 1';
	// wenn Kundenid nicht LEER und einen Zahl (SQL-Injection) dann anfügen
	if (!empty($KundenID) && is_numeric($KundenID)) $sql .= ' AND kunden.KundenID='.$KundenID;
	// wenn BuchID nicht LEER und einen Zahl (SQL-Injection) dann anfügen
	if (!empty($BuchID) && is_numeric($BuchID)) $sql .= ' AND buecher.BuchID='.$BuchID;

	// SELECT * FROM buecher INNER JOIN verleih ON verleih.BUECHER_BuchID=buecher.BuchID 
	// WHERE verleih.RetourDatum is NULL 
	
	// Query an DB senden
	$res = $mysqli->query($sql);

	// Ergebnis als Tabelle formatiert ausgeben
	echo '<table border="1">';
	echo '<tr><td>Kunde</td><td>Buch</td></tr>';
	while ($row = $res->fetch_assoc()) 
	{
		echo "<tr><td>" . $row['Nachname'] .' '. $row['Vorname']. '</td><td>'.$row['Titel'].'</td></tr>';
	}
	echo '</table>';
	// Datenbank schliessen
	$mysqli->close();
?>
	</body>
</html>
