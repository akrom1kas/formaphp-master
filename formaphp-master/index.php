
<?php
$server="localhost";
$user="root";
$password="adminas";
$dbname="test";

SESSION_START();

//prideta paieska


// function to connect and execute the query
function filterTable($query)
{
    $connect = mysqli_connect("localhost", "root", "adminas", "test");
    $filter_Result = mysqli_query($connect, $query);
    return $filter_Result;
}
////////
///
$conn = new mysqli($server, $user, $password, $dbname);
if ($conn->connect_error) die("Negaliu prisijungti:" . $conn->connect_error);


$logged = false;

if (isset($_SESSION['user']))
{
    $logged = true;
}
else
{
    if(isset($_POST['login']))
    {
        if(!empty($_POST['username']) && !empty($_POST['password']))
        {
            $sql = "SELECT * FROM users where username ='".$_POST['username']."' and password = '".hash('sha1', $_POST['password'])."'";
            $result = mysqli_query($conn, $sql);
            while ($row = mysqli_fetch_array($result))
            {
                $_SESSION['user'] = $row;
                header('Location: index.php');
                exit();
            }

        }
    }
}


if ($logged) {

//    print_r($_SESSION);
    if($_POST !=null)
    {
        if (!empty($_POST['zinute'])) {

//            $vardas = $_POST['vardas'];
//            $epastas = $_POST['epastas'];
            $zinute = $_POST['zinute'];

            $sql = "INSERT INTO mindaugas (vardas, epastas, zinute, ip, laikas)
    VALUES ('".$_SESSION['user']['username']."','".$_SESSION['user']['email']."','".$_POST['zinute']."','".$_SERVER['REMOTE_ADDR']."',NOW())";

            if (!$result = $conn->query($sql)) die("Negaliu irasyti:" . $conn->error);
            header("Location: index.php");
            die();
        }
    }
}
// Delete post //
include "connection.php";

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];
    $delete = mysqli_query($connection, "DELETE FROM `mindaugas` WHERE id= '$id' and epastas = '".$_SESSION['user']['email']."'");

}
$select="SELECT * FROM `mindaugas`";
$query=mysqli_query($connection, $select);

///////////////////////////////// Puslapiavimas

        if (isset($_GET['valueToSearch'])) {
            $valueToSearch = $_GET['valueToSearch'];
            $WHERE = "WHERE CONCAT (`vardas`, `epastas`, `zinute`, `ip`, `laikas`) LIKE '%" . $valueToSearch . "%'";
        }

else
{
    $WHERE = "";
}
$conn=mysqli_connect($server,$user,$password,"$dbname");
if(!$conn){
    die('Could not Connect My Sql:' .mysql_error());
}
$limit = 10;
if (isset($_GET["page"])) {
    $page  = $_GET["page"];
}
else{
    $page=1;
};
$start_from = ($page-1) * $limit;
$result = mysqli_query($conn,"SELECT * FROM mindaugas $WHERE ORDER BY id ASC LIMIT $start_from, $limit");

?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html"; charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <title>Laboratorinis darbas</title>
</head>
<body>

<?php
if ($logged)
{
    ?>
    <nav class="navbar navbar-dark bg-dark">
        <ul>
            <li><a href="#">Admin</a></li>
            <li><a href="#">News</a></li>
            <li><a href="logout.php">Logout</a></a></li>
            <li><span><a href="#">Welcome <?php echo $_SESSION['user']['username']; ?></a></span></li>
            <br><br>

            <form action="index.php" class="paieska" method="get">
                <input type="text" name="valueToSearch" placeholder="" value="<?php if (isset($_GET['valueToSearch'])) echo $_GET['valueToSearch']; ?>">
                <?php
                if (isset($_GET['page']))
                {
                    echo '<input type="hidden" name="page" value="'.$_GET['page'].'">';
                }
                ?>

                <input type="submit" name="search" value="Search"><br></form
        </ul>
    </nav>
    <?php
}
?>
<?php

if ($logged)
{
?>
<table class="table table-striped table-dark">
    <tr>
        <th><a>id</a></th>

        <th><a href="?s=<?php echo (isset($_GET['s']) && $_GET['s']=='v' ? '-v' : 'v'); ?>">Vardas</a></th>
        <th><a href="?s=<?php echo (isset($_GET['s']) && $_GET['s']=='e' ? '-e' : 'e'); ?>">E.pastas</a></th>
        <th><a href="?s=<?php echo (isset($_GET['s']) && $_GET['s']=='z' ? '-z' : 'z'); ?>">Zinute</a></th>
        <th><a href="?s=<?php echo (isset($_GET['s']) && $_GET['s']=='i' ? '-i' : 'i'); ?>">Ip</a></th>
        <th><a href="?s=<?php echo (isset($_GET['s']) && $_GET['s']=='l' ? '-l' : 'l'); ?>">Laikas</a></th>
        <th>Istrinti</th>
    </tr>
    <?php
    }
    ?>
    <?php
    if ($logged) {
        $conn = new mysqli($server, $user, $password, $dbname);
// Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $order_by = '';
        if (isset($_GET['s'])) {
            switch ($_GET['s']) {
                case 'v':
                    $order_by = "order by vardas ASC";
                    break;
                case '-v':
                    $order_by = "order by vardas DESC";
                    break;
                case 'e':
                    $order_by = "order by epastas ASC";
                    break;
                case '-e':
                    $order_by = "order by epastas DESC";
                    break;
                default:
                    $order_by = "order by id ASC";
                    break;
                case 'z':
                    $order_by = "order by vardas ASC";
                    break;
                case '-z':
                    $order_by = "order by vardas DESC";
                    break;
                case 'i':
                    $order_by = "order by vardas ASC";
                    break;
                case '-i':
                    $order_by = "order by vardas DESC";
                    break;
                case 'l':
                    $order_by = "order by vardas ASC";
                    break;
                case '-l':
                    $order_by = "order by vardas DESC";
                    break;
            }
        }

//        $sql = "SELECT * FROM `mindaugas` " . $order_by;
//        $result = $conn->query($sql);
//
            while ($row = mysqli_fetch_array($result)) {
                echo "  
                 <tr class='lentele'>
                    <td>" . $row['id'] . " </td>
                    <td>" . $row['vardas'] . " </td>
                    <td>" . $row['epastas'] . " </td>
                    <td>" . $row["zinute"] . "</td>
                    <td>" . $row["ip"] . "</td>
                    <td>" . $row["laikas"] . "</td>
                    <td>" . ($row['epastas'] == $_SESSION['user']['email'] ? "<a href='index.php?id=" . $row['id'] . "'>Delete</a>" : "") . "</td>
                    </tr>";
            }
        }
            ?>
<!--    Upload foto to db-->

    <?php
    include "connection.php";
    $error = "";

    if (isset($_POST["btn_upload"]))
    {

        $file_tmp = $_FILES["fileImg"]["tmp_name"];
        $file_name = $_FILES["fileImg"]["name"];

        $image_name = $_POST["img-name"];

        $file_path = "photo/".$file_name;

        if($image_name == "")
        {
            $error = "Please enter Image name.";
        }
        else
        {
            if(file_exists($file_path))
            {
                $error = "Sorry,The <b>".$file_name."</b> image already exist.";
            }
            else
            {
                $result = mysqli_connect('localhost','root','adminas','test') or die("Connection error: ". mysqli_error());
                mysqli_select_db($result, 'test') or die("Could not Connect to Database: ". mysqli_error());
                mysqli_query($result,"INSERT INTO image_table(img_name,img_path)
				VALUES('$image_name','$file_path')") or die ("image not inserted". mysqli_error());
                move_uploaded_file($file_tmp,$file_path);
                $error = "<p>File ".$_FILES["fileImg"]["name"].""."<br />Image saved into Table.</p>";
            }
        }
    }

    ?>

</table>

<?php
if ($logged)
{
    ?>

    <?php
//    valueToSearch=benas
    if (isset($_GET['valueToSearch']))
    {
        $search = '&valueToSearch='.$_GET['valueToSearch'];
    }
    else
    {
        $search = '';
    }

    $result_db = mysqli_query($conn,"SELECT COUNT(id) FROM mindaugas $WHERE ");
    $row_db = mysqli_fetch_row($result_db);
    $total_records = $row_db[0];
    $total_pages = ceil($total_records / $limit);
    /* echo  $total_pages; */
    echo  "<ul class='pagination'>";

    if($page>1)
    {
        echo "<a href='index.php?page=".($page-1).$search."' class='btn btn-primary'>&#x2190;</a>";
    }

    for($i=1;$i<=$total_pages;$i++)
    {
        echo "<a href='index.php?page=".$i.$search."' class='btn btn-".($page==$i?"danger":'primary')."'>$i</a>";
    }

    if($page<$total_pages)
    {
        echo "<a href='index.php?page=".($page+1).$search."' class='btn btn-primary'>&rarr;</a>";
    }
    echo  "</ul>";

    ?>
    <form action='index.php' method='Post' class="card-body py-5 px-md-5" >
        Zinute:<br> <textarea name="zinute"> </textarea><br><br>
        <input type="submit" class="btn btn-primary" value="Submit">
        <input type="reset" class="btn btn-secondary ml-2" value="Reset">
    </form>

        <div class="image-box">
            <form method="POST" name="upfrm" action="" enctype="multipart/form-data" class="card-body py-5 px-md-5">
                <div>
                    <input type="text" placeholder="Enter image name" name="img-name" class="tb" />
                    <input type="file" name="fileImg" class="file_input" /><br><br>
                    <button type="submit" value="Upload" name="btn_upload" class="btn btn-secondary ml-2" </button>Upload
                </div>
                <p>
                    Watch full photo gallery <a href="show.php">Gallery</a>
                </p>
            </form>
            </div>
        </div>
    </div>

    <?php
}
else
{
    ?>
    <!-- Section: Design Block -->
    <section class="vh-100" style="background-color: #eee;">
        <div class="container h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="card-body p-md-5">
                    <style>
                        .rounded-t-5 {
                            border-top-left-radius: 0.5rem;
                            border-top-right-radius: 0.5rem;
                        }

                        @media (min-width: 992px) {
                            .rounded-tr-lg-0 {
                                border-top-right-radius: 0;
                            }

                            .rounded-bl-lg-5 {
                                border-bottom-left-radius: 0.5rem;
                            }
                        }
                    </style>
                    <div class="card mb-3">
                        <div class="row g-0 d-flex align-items-center">
                            <div class="col-lg-4 d-none d-lg-flex">
                                <img src="https://mdbootstrap.com/img/new/ecommerce/vertical/004.jpg" alt="Trendy Pants and Shoes"
                                     class="w-100 rounded-t-5 rounded-tr-lg-0 rounded-bl-lg-5" />
                            </div>
                            <div class="col-lg-8">
                                <div class="card-body py-5 px-md-5">

                                    <form method="post" name="signin-form">
                                        <!-- username input -->
                                        <div class="form-outline mb-4">
                                            <input type="username" name="username" id="form2Example1" class="form-control" />
                                            <label class="form-label" for="form2Example1">Username</label>
                                        </div>

                                        <!-- Password input -->
                                        <div class="form-outline mb-4">
                                            <input type="password" name="password" id="form2Example2" class="form-control" />
                                            <label class="form-label" for="form2Example2">Password</label>
                                        </div>

                                        <!-- 2 column grid layout for inline styling -->
                                        <div class="row mb-4">
                                            <div class="col d-flex justify-content-center">
                                                <!-- Checkbox -->
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="" id="form2Example31" checked />
                                                    <label class="form-check-label" for="form2Example31"> Remember me </label>
                                                </div>
                                            </div>

                                            <div class="col">
                                                <!-- Simple link -->
                                                <a href="#!">Forgot password?</a>
                                            </div>
                                        </div>

                                        <!-- Submit button -->
                                        <button type="submit" class="btn btn-primary btn-block mb-4"name="login" value="login">Log In</button>

                                        <p>
                                            Not yet a member? <a href="register.php">Sign up</a>
                                        </p>

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
    </section>
    <!-- Section: Design Block -->
    <?php
}
?>
</body>

</html>
