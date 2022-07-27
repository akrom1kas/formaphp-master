<?php

if(isset($_POST['search']))
{
    $valueToSearch = $_POST['valueToSearch'];
    // search in all table columns
    // using concat mysql function
    $query = "SELECT * FROM `mindaugas` WHERE CONCAT (`vardas`, `epastas`, `zinute`, `ip`, `laikas`) LIKE '%".$valueToSearch."%'";
    $search_result = filterTable($query);

}
else {
    $query = "SELECT * FROM `mindaugas`";
    $search_result = filterTable($query);
}

// function to connect and execute the query
function filterTable($query)
{
    $connect = mysqli_connect("localhost", "root", "adminas", "test");
    $filter_Result = mysqli_query($connect, $query);
    return $filter_Result;
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>PHP HTML TABLE DATA SEARCH</title>
    <style>
        table,tr,th,td
        {
            border: 1px solid black;
        }
    </style>
</head>
<body>

<form action="index.php" method="post">
    <input type="text" name="valueToSearch" placeholder="Value To Search"><br><br>
    <input type="submit" name="search" value="Filter"><br><br>

    <table>
        <tr>
            <th>id</th>
            <th>Vardas</th>
            <th>epastas</th>
            <th>zinute</th>
            <th>ip</th>
            <th>laikas</th>
        </tr>

        <!-- populate table from mysql database -->
        <?php while($row = mysqli_fetch_array($search_result)):?>
            <tr class='lentele'>
                <td><?php echo $row['id'];?></td>
                <td><?php echo $row['vardas'];?></td>
                <td><?php echo $row['epastas'];?></td>
                <td><?php echo $row['zinute'];?></td>
                <td><?php echo $row['ip'];?></td>
                <td><?php echo $row['laikas'];?></td>
            </tr>
        <?php endwhile;?>
    </table>
</form>

</body>
</html>