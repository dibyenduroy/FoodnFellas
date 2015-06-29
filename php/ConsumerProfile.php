<?php
session_start();
$_SESSION["user_id"] = $_GET["userid"];
$session_user_id=$_SESSION["user_id"];

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
 $fetch_photo = "SELECT user_id,photo,about_me,my_fav_dish,phone_number,f_name,l_name,email  FROM user where user_id = '".$_SESSION["user_id"]."' ";
 $result = $conn->query($fetch_photo);

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
        echo " Favourite Dish : ".$row["my_fav_dish"] ."<br>";
        echo " Phone Number : ".$row["phone_number"] ."<br>";
        echo " Email : ".$row["email"] ."<br>";


      

    }
} else {
    echo "0 results";
}
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Upload Files to Amazon S3 PHP</title>
</head>

<body>
<form action="ReloadedConsumerProfile.php" method='post' enctype="multipart/form-data">
<h3>Upload your profile picture here</h3><br/>
<div style='margin:10px'><input type='file' name='file'/> 
	<br>
   <br> <input type="text" name="FirstName" value="" placeholder="First Name" />  ( * Blank Values will be Entered as Blank)<br>
   <br> <input type="text" name="Lastname" value="" placeholder="Last Name" /> ( * Blank Values will be Entered as Blank) <br>
   <br> <input type="text" name="AboutMe" value="" placeholder="About Me" /> ( * Blank Values will be Entered as Blank) <br>
   <br> <input type="text" name="FavouriteDish" value="" placeholder="Favourite Dish" /> ( * Blank Values will be Entered as Blank) <br>
   <br> <input type="text" name="PhoneNumber" value="" placeholder="Phone Number" /> ( * Blank Values will be Entered as Blank) <br>
   <br> <input type="text" name="Email" value="" placeholder="Email" /> ( * Blank Values will be Entered as Blank) <br>

    <br>
	<input type='submit' value='Update Details' onClick="window.location.reload(true)"/></div>
	                       
</form>
<?php 
echo $msg.'<br/>'; 
?>
		

</body>
</html>
