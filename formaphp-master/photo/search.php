<?php
error_reporting(0);
$conn = mysqli_connect("localhost","root","adminas","test");
if(count($_POST)>0) {
    $mindaugas=$_POST[mindaugas];
    $result = mysqli_query($conn,"SELECT * FROM mindaugas where mindaugas='$mindaugas' ");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title> Retrive data</title>
    <style>
        table, th, td {
            border: 1px solid black;
        }
    </style>
</head>
<body>
    <?php
    $i=0;
    while($row = mysqli_fetch_array($result)) {
        ?>
        <tr>
            <td><?php echo $row["vardas"]; ?></td>
            <td><?php echo $row["epastas"]; ?></td>
            <td><?php echo $row["zinute"]; ?></td>
        </tr>
        <?php
        $i++;
    }
    ?>
</table>
</body>
</html>