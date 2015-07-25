<?php
if($_SERVER['REQUEST_METHOD'] == "POST")
{


$return = $_POST;
$id=5;
$provider_food_id=4; // Meal Table
//@ The provider_food_id needs to be integrated into Provider_food and Meal tables at the same time
$photo="s3 url";
$dishName = $return["dishName"];   // Meal table
$description = $return["description"]; // Meal table
////////////////////////////////////////////////////////////////
$price = $return["price"]; // Provider_Food table
$cuisineType = "Bengali" ;//$return["cuisineType"]; // Provider_Food
$mealSpec ="Veg" ; //$return["mealSpecification"]; // Provider_Food (meal_type)
$deliveryMethod ="Pick up" ; //$return["deliveryMethod"]; // Provider_food



/*echo $dishName;
echo $description;
echo $price;
echo $cuisineType;
echo $mealSpec;
echo $deliveryMethod ;*/




include 'foodnfellasDBConnection.php';

$sql1 = "insert into foodnfellas.Meal (user_id,provider_food_id,dish_name,meal_description,photo) values (".$id.",".$provider_food_id.",'".$dishName."',"."'".$description."', '".$photo."')";

$sql2 = "insert into foodnfellas.Provider_food (user_id,price_per_person,meal_type,delivery_method) values(".$id.",".$price.","."'".$mealSpec."', ' ".$deliveryMethod."')";

//echo $sql1;

//echo $sql2;


//echo $sql1;
if (($conn->query($sql1) === TRUE)  and ($conn->query($sql2) === TRUE) ) {
  $return["Status"] = "Success";
  echo "Meals Added Sucessfully";
}else {
  
  echo "There is some issue while adding meals.";
}

$conn->close(); 



}

?>