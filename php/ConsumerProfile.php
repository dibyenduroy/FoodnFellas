<?php

session_start();
$_SESSION["user_id"] = $_GET["userid"];
#$session_user_id=$_SESSION["user_id"];
$session_user_id = 4;

include('image_check.php');
header('Cache-Control: no-cache');
header('content-type: text/javascript;');

getConsumerphoto();
function getConsumerphoto() {
    //$array_user_address = array(1,2,3,4);
    $servername = "fm1s2t7e010rjki.cnn0dbzvr04c.us-west-2.rds.amazonaws.com";
    $username = "fnfsandbox";
    $password = "greatfood123";
    $dbname = "foodnfellas";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
        echo "Error Connecting to Database";
    }

    $queryUserInfo = "SELECT user_id, photo,about_me, my_fav_dish, phone_number, f_name, l_name,email FROM user WHERE user_id = '4';"; 
    //echo "$queryUserInfo";
    $result1 = $conn->query($queryUserInfo);

    $array_user_info = Array();
    $index = 0;

    if ($result1->num_rows > 0) {  
        while ($row = $result1->fetch_assoc()){
            $array_user_info[$index] = $row;
            $index++;
        }
        // wrap the data as with the callback
        echo $_GET['callback'].'('.json_encode($array_user_info).');';
        }

    $conn->close();
}
?>
