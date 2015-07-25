<?php
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
//echo $sql1;
if (($conn->query($sql1) === TRUE)) {
  $return["Status"] = "Success";
  echo "Order Sucessfully Placed";
}else {
  $return["Status"] = "hello4";
  $return["Status"] = "Error";
  $return["Error"] = $conn->error;
  echo "The is some issue in Order Placement";
}

$conn->close();

}

?>