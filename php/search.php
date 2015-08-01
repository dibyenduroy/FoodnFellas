<?php

header('Cache-Control: no-cache');
header('content-type: text/javascript;');

if($_SERVER['REQUEST_METHOD'] == "POST")
{


$return = $_POST;

$user_id = $return["user_id"];
//$user_id = 2;
// This will be used in Provider_address table.
$city = $return["city"];
//$city = "Sunnyvale";

// These fields will be used in Provider_food table.
$num_people = $return["num_people"];
$date = $return["date"];
$price_low = $return["price_low"];
$price_high = $return["price_high"];
$meal_type = $return["meal_type"];
$cuisine_type = $return["cuisine_type"];
$delivery_method = $return["delivery_method"];

//include 'foodnfellasDBConnection.php';
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

// Get the entries from Provider_address matching the city.
$sql1 = "SELECT pa.user_id as pui, pa.provider_food_id as pfi FROM Provider_address  as pa JOIN Provider_food as pf 
                                                ON pa.provider_food_id = pf.provider_food_id
                                                WHERE pa.city = '".$city."';"; 
//                                                AND pf.min_people <= ".$num_people." 
//                                                AND pf.max_people >= ".$num_people."
//                                                AND pf.price_per_person BETWEEN ".$price_low." AND ".$price_high." 
//                                                AND pf.meal_type = ".$meal_type." 
//                                                AND pf.cuisine_type = ".$cuisine_type." 
//                                                AND pf.delivery_method = ".$delivery_method." 
//if (($conn->query($sql1) === TRUE)) {
$result1 = $conn->query($sql1);
echo "$sql1";

$count = 0;
if ($result1->num_rows > 0) {	
	// Now, return the meal entries. 
	while($row = $result1->fetch_assoc()) {
			$provider_id = $row["pfi"];
    	$sql2 = "SELECT m.dish_name, m.meal_description, m.meal_id, p.about_me, p.awards_won, p.kitchen_photo, p.food_album, p.cuisine_i_cook FROM  Meal as m JOIN Provider as p ON m.user_id = p.user_id WHERE  m.provider_food_id = '".$provider_id."';";
     echo "$sql2";
      $array_meal_search_all = Array();
      $index = 0;
			$result2 = $conn->query($sql2);
      if ($result2->num_rows > 0) {
				while($array_meal_search_row = $result2->fetch_assoc()) {
          //print_r($array_meal_search_row);
          $array_meal_search_all[$index] = $array_meal_search_row;
          $index++;
          $count++;
          //$array_meal_search_all = array_merge($array_meal_search_all, $array_meal_search_row);
        }
			}
  }
} else {
    echo "0 results";
    echo "The is some issue in conn->query";
} 
 
$array_count_elem = array(
    "count"  => $count
    );
//$count;
$array_output = array_merge($array_count_elem, $array_meal_search_all);

// Test code.
//echo " Search Results ";
print_r($array_output); 

// At this point, we have all the information for the search query.
// wrap the data as with the callback
echo $_GET['callback'].'('.json_encode($array_output).');';


$conn->close();
}

?>