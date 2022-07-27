<?php

/*-- we included connection files--*/
include "connection.php";

$result = mysqli_connect('localhost','root','adminas','test') or die("Could not connect to database." .mysqli_error());
mysqli_select_db($result, 'test') or die("Could not select the databse." .mysqli_error());
$image_query = mysqli_query($result,"select img_name,img_path from image_table");
while($rows = mysqli_fetch_array($image_query))
{
    $img_name = $rows['img_name'];
    $img_src = $rows['img_path'];
    ?>

<div class="row">
    <div class="col-lg-4 col-md-12 mb-4 mb-lg-0">
        <img src="<?php echo $img_src; ?>"  alt="" title="<?php echo $img_name; ?>" class="img-responsive" />
        <p><strong><?php echo $img_name; ?></strong></p>
    </div>

    <?php
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, intial-scale=1.0"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <title>Show Image in PHP</title>
</head>

<body>
<!-------------------Main Content------------------------------>
<div class="container main">
    <div class="img-box">

    </div>
</div>
</body>
</html>
