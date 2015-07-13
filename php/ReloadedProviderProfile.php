<?php
include('image_check.php');
header('Cache-Control: no-cache');
session_start();
$id=$_SESSION["user_id"];

//print_r($_SESSION);
//

//getConsumerphoto();
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
 
$fetch_photo = "SELECT photo  FROM user where user_id = '".$_SESSION["user_id"]."' ";
$result = $conn->query($fetch_photo);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
    	$s3photo=$row["photo"];
        
        echo "<img style='TOP:35px; LEFT:170px; WIDTH:400px; HEIGHT:250px' SRC='$s3photo'>";


    }
} else {
    echo "0 results";
}
}

function photoUploadfunction($name,$size,$tmp,$ext) {
$valid_formats = array("jpg", "png", "gif", "bmp","jpeg","PNG","JPG","JPEG","GIF","BMP");
if(strlen($name) > 0)
{

if(in_array($ext,$valid_formats))
{
 //echo "The $valid_formats is : ".$valid_formats;
if($size<(1024*1024))
{
include('s3_config.php');
//Rename image name. 
$actual_image_name = time().".".$ext;
if($s3->putObjectFile($tmp, $bucket , $actual_image_name, S3::ACL_PUBLIC_READ) )
{
$msg = "S3 Upload Successful."; 
$s3file='http://'.$bucket.'.s3.amazonaws.com/'.$actual_image_name;

return $s3file;

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


//===== Photo Upload Function Ends///////////////////////////
}

///
$msg='';
if($_SERVER['REQUEST_METHOD'] == "POST")
{

//===========Profile Pic=============
$name = $_FILES['file']['name'];
$size = $_FILES['file']['size'];
$tmp = $_FILES['file']['tmp_name'];
$ext = getExtension($name);

//*************************************

//===========Kictchen Pic=============
$kpname = $_FILES['kitchenphoto']['name'];
$kpsize = $_FILES['kitchenphoto']['size'];
$kptmp = $_FILES['kitchenphoto']['tmp_name'];
$kpext = getExtension($kpname);

//*************************************


//===========Food Pic=============
$fpname = $_FILES['Foodphoto']['name'];
$fpsize = $_FILES['Foodphoto']['size'];
$fptmp = $_FILES['Foodphoto']['tmp_name'];
$fpext = getExtension($fpname);

//*************************************


$return = $_POST;

$about_me = $return["AboutMe"];
$cuisine = $return["Cuisines"];
$awards = $return["Awards"];
$address_name = $return["AddressName"];
$house_no = $return["HouseNo"];
$street1 = $return["Street1"];
$street2 = $return["Street2"];
$city = $return["City"];
$state = $return["State"];
$zip = $return["Zip"];
//echo $name;



// Photo Upload Function  for Profile Starts//////////







//

// Update Profile Pic
$pps3file=photoUploadfunction($name,$size,$tmp,$ext);



$s3filekitchen=photoUploadfunction($kpname,$kpsize,$kptmp,$kpext);


$s3filefood=photoUploadfunction($fpname,$fpsize,$fptmp,$fpext);


//

include 'foodnfellasDBConnection.php';
 //$sql = "INSERT INTO user (f_name,photo) VALUES ('".$fname."','".$s3file."')";

 //$sql="UPDATE user SET photo='".$s3file."' WHERE user_id=5";



$sql1 = "UPDATE Provider SET food_album='".$s3filefood."', kitchen_photo='".$s3filekitchen."', about_me='".$about_me."' , cuisine_i_cook ='".$cuisine."', awards_won='".$awards."' WHERE user_id='".$_SESSION["user_id"]."'";
$sql2 = "UPDATE Provider_address SET  address_name='".$address_name."' , house_no='".$house_no."', street_1='".$street1."', street_2='".$street2."', city='".$city."' ,state ='".$state."' ,zip_code ='".$zip."'  WHERE user_id='".$_SESSION["user_id"]."'";
$sql0 = "UPDATE user SET photo='".$pps3file."' WHERE user_id='".$_SESSION["user_id"]."'";
//echo $sql;
if (($conn->query($sql1) === TRUE) and ($conn->query($sql2) === TRUE) and ($conn->query($sql0) === TRUE)) {
  $return["Status"] = "Success";
  getProviderInfo();
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
<?php
//echo $_SESSION["user_id"];
echo "<a href=../php/ProviderProfile.php.php?userid=".$_SESSION["user_id"].">  Provider Profile Update Page</a> <br>";    
?>


		

</body>
</html>
