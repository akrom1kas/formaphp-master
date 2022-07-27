
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html"; charset="UTF-8">
    <title>Laboratorinis darbas</title>
</head>
<body>
    <table border="2px";>
        <tr>
            <td>Vardas</td>
            <td>E.pastas</td>
            <td>zinute</td>
            <td>ip</td>
            <td>laikas</td>
        </tr>
        <?php
        $server="localhost";
        $user="root";
        $password="adminas";
        $dbname="test";


        // prisijungti
        $conn = new mysqli($server, $user, $password, $dbname);
        if ($conn->connect_error) die("Negaliu prisijungti:" . $conn->connect_error);

        // nuskaityti
        $sql = "SELECT * FROM mindaugas";
        if (!$result = $conn->query($sql)) die("Negaliu prisijungti:" . $conn->error);

        // parodyti
        while($row = $result-> fetch_assoc()){
            echo "<tr>
                    <td>".$row['vardas']."</td>
                    <td>".$row['epastas']. "</td>
                    <td>".$row["zinute"]. "</td>
                    <td>".$row["ip"]. "</td>
                    <td>".$row["laikas"]. "</td>
                    </tr>";

        }
        $conn->close();
        ?>
    </table>
    <a href="index.php">Rasyti</a>
</body>

</html>