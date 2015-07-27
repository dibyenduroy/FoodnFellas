<?php
session_start();
#$_SESSION["user_id"] = $_GET["userid"];
#$session_user_id=$_SESSION["user_id"];
$session_user_id=4;

include('image_check.php');
header('Cache-Control: no-cache');
//

getProviderInfo();
function getProviderInfo() {

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

$fetch_provider_info = "select u.user_id as user_id,u.photo as photo,p.about_me as about_me,p.kitchen_photo as kitchen_photo,p.food_album as food_album,p.awards_won as awards_won,p.cuisine_i_cook as cuisine_i_cook FROM Provider p , user u where p.user_id=u.user_id and u.user_id = '5';";
$result = $conn->query($fetch_provider_info);
//$array_user_info = $result->fetch_assoc();
//mysql_data_seek($result, 0);
$array_info_address = Array();
$index = 0;

 if ($result->num_rows > 0) {
    //echo "i am inside if               -";
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $array_info_address[$index] = $row;
        $index++;
        //echo "I am inside while             -;";
        $s3_kitchen_photo=$row["kitchen_photo"];
        $s3_food_photo=$row["food_album"];
        $s3_provider_photo=$row["photo"];

 /*   echo " The User ID is  : ".$row["user_id"] ."<br>";
    echo " About Me : ".$row["about_me"] ."<br>";
    echo " Cuisines I cook : ".$row["cuisine_i_cook"] ."<br>";
    echo " Awards won : ".$row["awards_won"] ."<br><br>";
    echo " Provider Photo URL  : ".$row["photo"]."<br><br>";
    echo " Provider Kitchen URL  : ".$row["kitchen_photo"]."<br><br>";
    echo " Provider Food URL  : ".$row["food_album"]."<br><br>";
    echo " Provider Image : <img  float:left' SRC='$s3_provider_photo'> <br>" ;
    echo " Provider KItchen : <img  float:left' SRC='$s3_kitchen_photo'> <br>" ;
    echo " Food Served Today :<img  SRC='$s3_food_photo'> <br>" ;
    */
    }
} else {    
    echo "0 results";
}
//print_r($array_info_address);
$fetch_provider_address = "SELECT address_id, country, state, zip_code, city, street_1, street_2, house_no, address_name  FROM Provider_address where user_id = '5';";
$result2 = $conn->query($fetch_provider_address);
//$array_user_address = mysql_fetch_row($result2)
//mysql_data_seek($result2, 0);

if ($result2->num_rows > 0) {
//echo "I am inside if 2            -";
  // output data of each row
  while($row2 = $result2->fetch_assoc()) {

    $array_info_address[$index] = $row2;
    $index++;
   /* echo "I am insdie while 2           -";
    echo " The Provider Address Details are  :" ."<br>";
    echo " Address_ID  : ".$row2["address_id"] ."<br>";
    echo " Country : ".$row2["country"] ."<br>";
    echo " State : ".$row2["state"] ."<br>";
    echo " City : ".$row2["city"] ."<br>";
    echo " Street1 : ".$row2["street_1"] ."<br>";
    echo " Street2 : ".$row2["street_2"] ."<br>";
    echo " house_no : ".$row2["house_no"] ."<br>";
    echo " address_name : ".$row2["address_name"] ."<br>";
    */
    }
} else {
    echo "0 results";
}
//print_r($array_info_address);
//$all_user_info = array_merge($array_user_info, $array_user_address);
echo $_GET['callback'].'('.json_encode($array_info_address).');';
}
?>
