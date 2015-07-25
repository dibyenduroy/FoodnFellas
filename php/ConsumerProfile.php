<?php
header("Access-Control-Allow-Origin: *");

session_start();
$_SESSION["user_id"] = $_GET["userid"];
#$session_user_id=$_SESSION["user_id"];
$session_user_id=4;

include('image_check.php');
header('Cache-Control: no-cache');
//

getConsumerphoto();
function getConsumerphoto() {

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
 $fetch_photo = "SELECT user_id,photo,about_me,my_fav_dish,phone_number,f_name,l_name,email  FROM user where user_id = '$session_user_id' ";
 $result = $conn->query($fetch_photo);
$array_user_address = mysql_fetch_row($result)
mysql_data_seek($result2, 0);

 if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $s3photo=$row["photo"];
        $fname=$row["f_name"];

        echo "<img style='TOP:35px; LEFT:170px; WIDTH:400px; HEIGHT:250px' SRC='$s3photo'> <br>" ;
        echo " The User ID is  : ".$row["user_id"] ."<br>";
        echo " First Name : ".$fname ."<br>";
        echo " Last Name : ".$row["l_name"] ."<br>";
        echo " About Me : ".$row["about_me"] ."<br>";
                echo " About Me : ".$row["about_me"] ."<br>";
        echo " Favourite Dish : ".$row["my_fav_dish"] ."<br>";
        echo " Phone Number : ".$row["phone_number"] ."<br>";
        echo " Email : ".$row["email"] ."<br>";
    }
} else {
    echo "0 results";
}
echo json_encode($all_user_info);
}
?>
