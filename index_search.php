
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

    <main>
        <form method="POST" action="">
            <div>
                <input type="text" name="kunde" placeholder="KundenID" id="kunde">
                <br>
                <input type="radio" id="all" name="all" value="Alle Monate" checked="checked">
                <label for="all">Alle Monate</label>
                <br>
                <input type="radio" id="now" name="now" value="now">
                <label for="now">Aktuelles Monat</label>
                <br>
                <input value="Search" type="submit" name="submit">
            </div>
        </form>
    </main>

<?php

$KundenID = $_POST['kunde'];
$AllMonth = $_POST['all'];
//$NowMonth = $_POST['now'];

$hostname = "localhost";
$username = "root";
$password = "";
$db = "autoverleih";

$mysqli = new mysqli($hostname, $username, $password, $db);
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
    

if (isset($_POST["submit"])){
    $query = mysqli_query($mysqli, "Select fahrzeuge.Model, fahrzeuge.Hersteller, Fahrzeug_Ausgabe, Fahrzeug_Zuerueckgabe ,kunde.idKunde FROM fahrzeug_verleih
    INNER JOIN fahrzeuge ON fahrzeuge.FahrzeugID=fahrzeug_verleih.Fahrzeuge_FahrzeugID
    INNER JOIN kunde ON kunde.idKunde=fahrzeug_verleih.Kunde_idKunde
    WHERE fahrzeug_verleih.Kunde_idKunde LIKE '%{$KundenID}%';")
    or die (mysqli_error($mysqli));

    echo '<table border="1">';
	echo '<tr><td>Model</td><td>Hersteller</td><td>Ausgabe</td><td>Zurückgabe</td><td>Kunde</td></tr>';
    while($row = mysqli_fetch_array($query)) {
    echo
    "<tr>
        <td>{$row['Model']}</td>
        <td>{$row['Hersteller']}</td>
        <td>{$row['Fahrzeug_Ausgabe']}</td>
        <td>{$row['Fahrzeug_Zuerueckgabe']}</td>
        <td>{$row['idKunde']}</td>
    </tr>\n";
    }
}
$mysqli->close();
?>

        </table>
    </body>
</html>