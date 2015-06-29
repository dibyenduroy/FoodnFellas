<?php
include('image_check.php');
header('Cache-Control: no-cache');
session_start();
$id=$_SESSION["user_id"];

//print_r($_SESSION);
//

//getConsumerphoto();
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
 $fetch_photo = "SELECT photo  FROM user where user_id = '".$_SESSION["user_id"]."' ";
 $result = $conn->query($fetch_photo);

 if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
    	$s3photo=$row["photo"];
        //echo  "The Photo URL is :".$row["photo"]. "<br>";
        //echo '<b>S3 File URL:</b>'.$row["photo"];
        //echo "<img src='$s3photo' style='max-width:400px'/><br/>";
        echo "<img style='TOP:35px; LEFT:170px; WIDTH:400px; HEIGHT:250px' SRC='$s3photo'>";


    }
} else {
    echo "0 results";
}
}

///
$msg='';
if($_SERVER['REQUEST_METHOD'] == "POST")
{

$name = $_FILES['file']['name'];
$size = $_FILES['file']['size'];
$tmp = $_FILES['file']['tmp_name'];
$ext = getExtension($name);
$return = $_POST;
$fname = $return["FirstName"];
$lname = $return["Lastname"];
$about_me = $return["AboutMe"];
$fav_dish = $return["FavouriteDish"];
$phone = $return["PhoneNumber"];
$email = $return["Email"];

echo $name;



if(strlen($name) > 0)
{

if(in_array($ext,$valid_formats))
{
 
if($size<(1024*1024))
{
include('s3_config.php');
//Rename image name. 
$actual_image_name = time().".".$ext;
if($s3->putObjectFile($tmp, $bucket , $actual_image_name, S3::ACL_PUBLIC_READ) )
{
$msg = "S3 Upload Successful.";	
$s3file='http://'.$bucket.'.s3.amazonaws.com/'.$actual_image_name;
//echo "<img src='$s3file' style='max-width:400px'/><br/>";
//echo '<b>S3 File URL:</b>'.$s3file;
 
 


}
else
$msg = "S3 Upload Fail.";


}
else
$msg = "Image size Max 1 MB";

}
else
$msg = "Invalid file, please upload image file.";

}
else
$msg = "Please select image file.";


include 'foodnfellasDBConnection.php';
 //$sql = "INSERT INTO user (f_name,photo) VALUES ('".$fname."','".$s3file."')";

 //$sql="UPDATE user SET photo='".$s3file."' WHERE user_id=5";

if (isset($s3file)) {

$sql="UPDATE user SET photo='".$s3file."' , about_me='".$about_me."' , my_fav_dish='".$fav_dish."', phone_number='".$phone."' , f_name='".$fname."' , l_name='".$lname."',email='".$email."' WHERE user_id='".$_SESSION["user_id"]."'";
 
} else {

$sql="UPDATE user SET  about_me='".$about_me."' , my_fav_dish='".$fav_dish."', phone_number='".$phone."' , f_name='".$fname."' , l_name='".$lname."',email='".$email."' WHERE user_id='".$_SESSION["user_id"]."'";
}


 //echo $sql;
 if ($conn->query($sql) === TRUE) {
  $return["Status"] = "Success";
  getConsumerphoto();
}else {
  $return["Status"] = "hello4";
    $return["Status"] = "Error";
    $return["Error"] = $conn->error;
}

$conn->close();


  

}




?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Upload Files to Amazon S3 PHP</title>
</head>

<body>
<br>
<br>
<h>You Profile View Now <h>
<br> To Update Go Back to Update Page  
<?
//echo $_SESSION["user_id"];
echo "<a href=../php/ConsumerProfile.php?userid=".$_SESSION["user_id"].">  Profile Update Page</a> <br>";    
?>


		

</body>
</html>
