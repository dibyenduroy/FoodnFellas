<?php
session_start();
// Getting session variables.
$user_id = $_SESSION["user_id"];
$f_name = $_SESSION["f_name"];
$l_name = $_SESSION["l_name"];
$is_provider = $_SESSION["is_provider"];

// Hardcode the Request method here.
$_SERVER['REQUEST_METHOD'] = "POST";

if($_SERVER['REQUEST_METHOD'] == "POST")
{


$return = $_POST;

$provider_id = $return["provider_id"];
$consumer_id = $return["consumer_id"];
$meal_id = $return["meal_id"];
$cost = $return["cost"];
$DeliveryMethod = $return["DeliveryMethod"];
$NumberofAdult = $return["NumberofAdult"];
$NumberofKids = $return["NumberofKids"];
$ReviewID=$return["ReviewID"];
$SpecialNote=$return["SpecialNote"];


include 'foodnfellasDBConnection.php';

$sql1 = "insert into foodnfellas.Transaction(review_id,user_id_c,user_id_p,meal_id,tran_time,cost,delivery_method,no_of_adult,no_of_kids,special_note) values (".$ReviewID.",".$consumer_id.",".$provider_id.",".$meal_id.",CURRENT_TIMESTAMP(),".$cost.","."'".$DeliveryMethod."',".$NumberofAdult.",".$NumberofKids.", '".$SpecialNote."');" ;
$provider_email = "select email,f_name, l_name , phone_number from foodnfellas.user where user_id=".$provider_id;
$consumer_email = "select email ,f_name, l_name ,phone_number from foodnfellas.user where user_id=".$consumer_id;
$result_provider = $conn->query($provider_email);
$result_consumer = $conn->query($consumer_email);

//echo $sql1;
if (($conn->query($sql1) === TRUE)  and ($result_provider->num_rows > 0) and ($result_consumer->num_rows > 0) ) {
  
  $return["Status"] = "Success";
  //echo "Order Sucessfully Placed";
  //echo "Sending Email to Provider and Consumer";
  $row_provider = $result_provider->fetch_assoc();
  $row_consumer = $result_consumer->fetch_assoc();
  
  //====================================

// multiple recipients
$to  = $row_provider["email"] . ', '; // note the comma
$to .= $row_consumer["email"];

// subject
$subject = 'FoodnFellas Email';

// message
$message = '
<html>
<head>
  <title>FoodnFellas Order Submission </title>
</head>
<body img src="http://s3-us-west-2.amazonaws.com/foodnfellas/FoodAlbum/Veg/LittiChokha.jpg">
  <p>Order Details are as below : </p>
  
  <br>

  <b> Provider </b> : '.$row_provider["f_name"].' '.$row_provider["l_name"].' <br> <br>

  <b> Consumer   </b> : '.$row_consumer["f_name"].' '.$row_consumer["l_name"].' <br> <br> 

 <b>  Special Notes   </b>: '.$SpecialNote.' <br> <br>

<br>

   Dear  '.$row_consumer["f_name"].' '.$row_consumer["l_name"].' , <br> <br>  Please contact our provider '.$row_provider["f_name"].' '.$row_provider["l_name"].' at  his/her number : <b> '.$row_provider["phone_number"].'  </b> to get the delivery details on the Order

    
    <br>


    <br>

    Regards,  <br>
    FoodnFellas Team.


</body>
</html>
';

echo $message;

// To send HTML mail, the Content-type header must be set
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers .= 'From: FoodnFellas <FoodnFellas@example.com>' . "\r\n";

// Additional headers
//$headers .= 'To: Mary <mary@example.com>, Kelly <kelly@example.com>' . "\r\n";
//$headers .= 'From: Birthday Reminder <birthday@example.com>' . "\r\n";
//$headers .= 'Cc: birthdayarchive@example.com' . "\r\n";
//$headers .= 'Bcc: birthdaycheck@example.com' . "\r\n";

// Mail it
mail($to, $subject, $message, $headers);




  //=================================
}else {
  $return["Status"] = "hello4";
  $return["Status"] = "Error";
  $return["Error"] = $conn->error;
  echo "The is some issue in Order Placement";
}

$conn->close();

}

?>