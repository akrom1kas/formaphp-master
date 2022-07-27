<?php

if($_POST !=null)
{

$server="localhost";
$user="root";
$password="adminas";
$dbname="test";


// prisijungti
$conn = new mysqli($server, $user, $password, $dbname);
if ($conn->connect_error) die("Negaliu prisijungti:" . $conn->connect_error);

    $vardas = $_POST['vardas'];
    $epastas = $_POST['epastas'];
    $zinute = $_POST['zinute'];

    $sql = 'INSERT INTO mindaugas (vardas, epastas, zinute, ip, laikas)
    VALUES ("'.$vardas.'", "'.$epastas.'", "'.$zinute.'", "'.$_SERVER['REMOTE_ADDR'].'", NOW())';

if (!$result = $conn->query($sql)) die("Negaliu irasyti:" . $conn->error);



    $conn->close();
}

?>