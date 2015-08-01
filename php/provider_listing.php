<?php

// Delete this during final integration.
$_SERVER['REQUEST_METHOD'] = "POST";

header('Cache-Control: no-cache');
header('content-type: text/javascript;');

if($_SERVER['REQUEST_METHOD'] == "POST")
{
	$return = $_POST;
	$user_id = $return["user_id"];

	// Delete this during final integration.
	$user_id = 5;

	include 'foodnfellasDBConnection.php';

	$sql1 = "SELECT u.user_id, u.is_provider, u.f_name, u.l_name, u.photo, u.about_me, p.kitchen_photo, p.awards_won, p.cuisine_i_cook 
	                FROM user as u 
	                JOIN Provider as p 
	                ON u.user_id = p.user_id
	                WHERE u.user_id = '".$user_id."';";

    // Delete these echos during final integration.
	//echo " SQL1    ";
	//echo $sql1;

	$result1 = $conn->query($sql1);
	if ($result1->num_rows > 0) {
		// Delete these echos and print_r during final integration.
	//	echo "  if1 success   ";
		$array_unique_result = $result1->fetch_assoc();
	//	echo "  sql1 result  ";
	//	echo "  Printing array_unique_result  "."<br>";
	//	print_r($array_unique_result);
	} else {
		echo "0 results1";
	}

	$sql2 = "SELECT p.food_album, m.dish_name, m.meal_description, pf.price_per_person, pf.delivery_method, pf.meal_type, 
	                pf.cuisine_type, pf.available_start, pf.available_end   
                                 FROM Meal as m 
                                 JOIN Provider_food as pf
                                 ON m.user_id = pf.user_id
                                 JOIN Provider as p
                                 ON pf.user_id = p.user_id
                                 WHERE m.user_id = '".$user_id."';";
    // Delete these echos during final integration.
    //echo "<br>"."  SQL2   ";
    //echo $sql2;

    $array_repeated_results = Array();
    $index = 0;

	$result2 = $conn->query($sql2);
	if ($result2->num_rows > 0) {
		// Delete these echos and print_r during final integration.
	//	echo "<br>"." if2 success ";
	//	if ($row = $result2->fetch_assoc()) {
		while ($row = $result2->fetch_assoc()) {
			$array_row = $result2->fetch_assoc();
	//		echo "<br>"."printing each repeated result";
	//		print_r($array_row);
			$array_repeated_results[$index] = $array_row;
			$index++;	
		} 
		
	} else {
		echo "0 results2";
	}

	// Get the count. 
	$count_array_elem = Array();
	$count_array_elem[0] = $index;
//	echo "<br>"."  Printing array_repeated_results  ";
//	print_r($array_repeated_results);

	$provider_listings = array_merge($count_array_elem, $array_unique_result, $array_repeated_results);
	// Delete these echos and print_r during final integration.
//	echo "<br>"."  printing provider listings    ";
	// Test echos.
	echo "  Provider Listing results ";
	print_r($provider_listings);

	// At this point, we have all the information for the search query.
	// wrap the data as with the callback
    echo $_GET['callback'].'('.json_encode($provider_listings).');';

	$conn->close();
}

?>