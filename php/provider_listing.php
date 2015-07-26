<?php
if($_SERVER['REQUEST_METHOD'] == "POST")
{
	$return = $_POST;
	$user_id = $return["user_id"];

	include 'foodnfellasDBConnection.php';

	$sql1 = "SELECT u.f_name, u.l_name, u.photo, p.about_me, p.kitchen_photo, p.awards_won, p.cuisines_i_cook 
	                FROM User as u 
	                JOIN Provider as p 
	                ON u.user_id = p.user_id
	                WHERE u.user_id = ".$user_id.";";

	$result1 = $conn->query($sql1);
	if ($result1->num_rows > 0) {
		$array_unique_result = $result1->fetch_assoc();
	} else {
		echo "0 results";
	}

	$sql2 = "SELECT p.food_album, m.dish_name, m.meal_description, pf.price_per_person, pf.delivery_method, pf.meal_type, 
	                pf.cuisine_type, pf.available_start, pf.available_end   
                                 FROM Meal as m 
                                 JOIN Provider_food as pf
                                 ON m.user_id = pf.user_id
                                 JOIN Provider as p
                                 ON pf.user_id = p.user_id
                                 WHERE m.user_id = ".$user_id.";";

	$result2 = $conn->query($sql2);
	if ($result2->num_rows > 0) {
		while ($row = $result2->fetch_assoc()) {
			$array_row = mysql_fetch_row($result2);
		} 
		$array_repeated_results = array_merge($array_repeated_results, $array_row);
	} else {
		echo "0 results";
	}

	$provider_listings = array_merge($array_unique_result, $array_repeated_results);

	// At this point, we have all the information for the search query.
	echo json_encode($provider_listings);

	$conn->close();
}

?>