<?php
$username = $_POST['username'];
$email = $_POST['email'];
$password = hash('sha1', $_POST['password']);
$errors = array();

$conn = new mysqli('localhost','root','adminas', 'test');
if ($conn->connect_error){
    die('Connection failed : '.$conn->connect_error);
}
else
{
    $stmt = $conn->prepare("SELECT *  FROM users WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $result = $stmt->get_result(); // get the mysqli result
    $user = $result->fetch_assoc();

    if (is_array($user) && count($user) > 0) { // if user exists
            array_push($errors, "User already exists");
        echo "User already exists";
    }
    else
    {
        $stmt = $conn->prepare("insert into users(username, email, password)
        values(?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $password);
        $stmt->execute();
        echo "registration successfully";
    }
}
    $stmt->close();

?>
