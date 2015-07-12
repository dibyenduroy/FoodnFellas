<?php
session_start();
$_SESSION["user_id"] = $_GET["userid"];
$session_user_id=$_SESSION["user_id"];

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
 
$fetch_provider_info = "select u.user_id as user_id,u.photo as photo,p.about_me as about_me,p.kitchen_photo as kitchen_photo,p.food_album as food_album,p.awards_won as awards_won,p.cuisine_i_cook as cuisine_i_cook FROM Provider p , user u where p.user_id=u.user_id and u.user_id = '".$_SESSION["user_id"]."' ";
$result = $conn->query($fetch_provider_info);


/*if ($result->num_rows > 0) {
    $s3_kitchen_photo=$row["kitchen_photo"];
    $s3_food_photo=$row["food_album"];
    echo " The User ID is  : ".$row["user_id"] ."<br>";
    echo " About Me : ".$row["about_me"] ."<br>";
    echo " Cuisines I cook : ".$row["cuisine_i_cook"] ."<br>";
    echo " Awards won : ".$row["awards_won"] ."<br>";
    echo "<img style='TOP:35px; LEFT:170px; WIDTH:400px; HEIGHT:250px' SRC='$s3_kitchen_photo'> <br>" ;
    echo "<img style='TOP:35px; LEFT:170px; WIDTH:400px; HEIGHT:250px' SRC='$s3_kitchen_photo'> <br>" ;    
} else {
    echo "0 results";
}*/

 if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
      $s3_kitchen_photo=$row["kitchen_photo"];
      $s3_food_photo=$row["food_album"];
      $s3_provider_photo=$row["photo"];
        
    echo " The User ID is  : ".$row["user_id"] ."<br>";
    echo " About Me : ".$row["about_me"] ."<br>";
    echo " Cuisines I cook : ".$row["cuisine_i_cook"] ."<br>";
    echo " Awards won : ".$row["awards_won"] ."<br><br>";
    //echo " Provider Photo URL  : ".$row["photo"]."<br><br>";
    //echo " Provider Kitchen URL  : ".$row["kitchen_photo"]."<br><br>";
    //echo " Provider Food URL  : ".$row["food_album"]."<br><br>";
    
    
    
    echo " Provider Image : <img  float:left' SRC='$s3_provider_photo'> <br>" ;
    echo " Provider KItchen : <img  float:left' SRC='$s3_kitchen_photo'> <br>" ;
    echo " Food Served Today :<img  SRC='$s3_food_photo'> <br>" ; 
    

    

    }
} else {
    echo "0 results";
}


$fetch_provider_address = "SELECT address_id, country, state, zip_code, city, street_1, street_2, house_no, address_name  FROM Provider_address where user_id = '".$_SESSION["user_id"]."' ";
$result2 = $conn->query($fetch_provider_address);
if ($result2->num_rows > 0) {
  // output data of each row
  while($row2 = $result2->fetch_assoc()) {  
    echo "<br>";
    echo "<br>";
    echo "<br>";
    echo "<br>";echo "<br>";
    
    echo " The Provider Address Details are  :" ."<br>";
    echo " Address_ID  : ".$row2["address_id"] ."<br>";
    echo " Country : ".$row2["country"] ."<br>";
    echo " State : ".$row2["state"] ."<br>";
    echo " City : ".$row2["city"] ."<br>";
    echo " Street1 : ".$row2["street_1"] ."<br>";
    echo " Street2 : ".$row2["street_2"] ."<br>";
    echo " house_no : ".$row2["house_no"] ."<br>";
    echo " address_name : ".$row2["address_name"] ."<br>";



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

<h4> Provider Profile Update <h>   
<form action="ReloadedProviderProfile.php" method='post' enctype="multipart/form-data">
<h3>Upload your profile picture here</h3><br/>
<div style='margin:10px'><input type='file' name='file'/> 

	<br>
   <br> <input type="text" name="AboutMe" value="" placeholder="About Me" /> ( * Blank Values will be Entered as Blank) <br>
   <br> <input type="text" name="Cuisines" value="" placeholder="Cuisines I can cook" /> ( * Blank Values will be Entered as Blank) <br>
   <br> <input type="text" name="Awards" value="" placeholder="Awards won" /> ( * Blank Values will be Entered as Blank) <br>
   <br> <input type="text" name="AddressName" value="" placeholder="Address Name" /> ( * Blank Values will be Entered as Blank) <br>
   <br> <input type="text" name="HouseNo" value="" placeholder="House number" /> ( * Blank Values will be Entered as Blank) <br>
   <br> <input type="text" name="Street1" value="" placeholder="Street Address1" /> ( * Blank Values will be Entered as Blank) <br>
   <br> <input type="text" name="Street2" value="" placeholder="Street Address2" /> ( * Blank Values will be Entered as Blank) <br>
   <br> <input type="text" name="City" value="" placeholder="City" /> ( * Blank Values will be Entered as Blank) <br>
   <br> <input type="text" name="State" value="" placeholder="State" /> ( * Blank Values will be Entered as Blank) <br>
   <br> <input type="text" name="Zip" value="" placeholder="Zip" /> ( * Blank Values will be Entered as Blank) <br>
    <br>
<h3>Upload Kitchen Photo</h3>
<div style='margin:10px'><input type='file' name='kitchenphoto'/>
<h3>Upload Food Photo</h3>
<div style='margin:10px'><input type='file' name='Foodphoto'/> 
<input type='submit' value='Update Details' onClick="window.location.reload(true)"/></div>
</form>
<?php 
echo $msg.'<br/>'; 
?>
		

</body>
</html>
