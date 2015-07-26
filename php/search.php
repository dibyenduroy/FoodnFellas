<?php
if($_SERVER['REQUEST_METHOD'] == "POST")
{


$return = $_POST;

$user_id = $return["user_id"];
// This will be used in Provider_address table.
$city = $return["city"];

// These fields will be used in Provider_food table.
$num_people = $return["num_people"];
$date = $return["date"];
$price_low = $return["price_low"];
$price_high = $return["price_high"];
$meal_type = $return["meal_type"];
$cuisine_type = $return["cuisine_type"];
$delivery_method = $return["delivery_method"];

include 'foodnfellasDBConnection.php';

// Get the entries from Provider_address matching the city.
$sql1 = "SELECT `pa.user_id`, `pa.provider_food_id` FROM `Provider_address`  as pa JOIN `Provider_food` as pf 
                                                ON `pa.provider_food_id` = `pf.provider_food_id` 
                                                WHERE `city` = '".$city."';"; 
//                                                AND pf.min_people <= ".$num_people." 
//                                                AND pf.max_people >= ".$num_people."
//                                                AND pf.price_per_person BETWEEN ".$price_low." AND ".$price_high." 
//                                                AND pf.meal_type = ".$meal_type." 
//                                                AND pf.cuisine_type = ".$cuisine_type." 
//                                                AND pf.delivery_method = ".$delivery_method." 

$result1 = $conn->query($sql1);
echo "HI";
echo $result1;
if ($result1->num_rows > 0) {	
	// Now, return the meal entries. 
	while($row = $result1->fetch_assoc()) {
			$provider_id = $row["pa.provider_food_id"];

    	$sql2 = "SELECT m.dish_name, m.meal_description, m.meal_id, p.about_me, p.awards_won, p.kitchen_photo, p.food_album, p.cuisine_i_cook
    								FROM  Meal as m JOIN Provider as p 
    								ON m.user_id = p.user_id
									WHERE  m.provider_food_id = ".$provider_id.";";

			$result2 = $conn->query($sql2);
			if ($result2->num_rows > 0) {
				$array_meal_search_row = mysql_fetch_row($result2);
			}

			$array_meal_search_all = array_merge($array_meal_search_all, $array_meal_search_row);
  }
} else {
    echo "0 results";
}

// At this point, we have all the information for the search query.
//echo json_encode($array_meal_search_all);


$conn->close();
}

?>