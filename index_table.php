
<html>
    <meta charset="UTF-8">
	<title>Suche</title>
</head>

	<body>
    <nav>
        <div>
            <ul>
                <li><a href="index_search.php">Suche</a></li>
                <li><a href="index_table.php">Ausgabe Tabelle</a></li>
            </ul>
        </div>
    </nav>
    
	<br>

    <?php

    $hostname = "localhost";
    $username = "root";
    $password = "";
    $db = "autoverleih";

    $mysqli = new mysqli($hostname, $username, $password, $db);
    if ($mysqli->connect_errno) {
        echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    }
    //echo $mysqli->host_info . "\n";
    // Datenbank abfragen
	$sql = 'SELECT fahrzeuge.Model, fahrzeuge.Hersteller,  kunde.idKunde FROM fahrzeug_verleih';
	$sql .= ' INNER JOIN fahrzeuge ON fahrzeuge.FahrzeugID=fahrzeug_verleih.Fahrzeuge_FahrzeugID';
    $sql .= ' INNER JOIN kunde ON kunde.idKunde=fahrzeug_verleih.Kunde_idKunde';
	$sql .= ' WHERE fahrzeug_verleih.Fahrzeug_Zuerueckgabe IS NULL;';

    // wenn Kundenid nicht LEER und einen Zahl (SQL-Injection) dann anfügen
	//if (!empty($idKunde) && is_numeric($KundenID)) $sql .= ' AND kunden.KundenID='.$KundenID;
	// wenn BuchID nicht LEER und einen Zahl (SQL-Injection) dann anfügen
	//if (!empty($BuchID) && is_numeric($BuchID)) $sql .= ' AND buecher.BuchID='.$BuchID;


    $result = $mysqli-> query($sql);
   
    echo '<table border="1">';
	echo '<tr><td>Model</td><td>Hersteller</td><td>Kunde</td></tr>';
    if ($result-> num_rows >0 ){
        while ($row = $result->fetch_assoc()) 
        {
            echo "<tr><td>" . $row['Model'] .'</td><td>'. $row['Hersteller']. '</td><td>'.$row['idKunde'].'</td></tr>';
        }
    }echo '</table>';


	$mysqli->close();
    ?>

        </table>
    </body>
</html>