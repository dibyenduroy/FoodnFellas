<?php

header('Cache-Control: no-cache');
header('content-type: text/javascript;');

// Delete this during integration cleanup.
$_SERVER['REQUEST_METHOD'] = "POST";

if($_SERVER['REQUEST_METHOD'] == "POST")
{

$return = $_POST;

$provider_food_id = $return["food_provider_id"];

// Delete this hardcoding during final cleanup.
$provider_food_id = 5; 

include 'foodnfellasDBConnection.php';

$sql1 = "SELECT u.f_name, u.l_name, u.photo, u.about_me, p.kitchen_photo, p.food_album, p.awards_won, p.cuisine_i_cook, m.dish_name, 
                m.meal_description, pf.price_per_person, pf.delivery_method, pf.meal_type, pf.cuisine_type,
                pf.available_start, pf.available_end, pa.street_1, pa.city, pa.state, pa.zip_code, pa.country   
                                 FROM Meal as m 
                                 JOIN Provider_address as pa                            
                                 ON m.provider_food_id = pa.provider_food_id
                                 JOIN Provider_food as pf 
                                 ON pa.provider_food_id = pf.provider_food_id
                                 JOIN Provider as p
                                 ON pf.user_id = p.user_id
                                 JOIN user as u 
                                 ON p.user_id = u.user_id
                                 WHERE pf.provider_food_id = '".$provider_food_id."';";

// Delte these debug echos during integration.
//echo "  sql1  ";
//echo $sql1;

$result1 = $conn->query($sql1);
if ($result1->num_rows > 0) {
        // Delte these debug echos during integration.
        //echo "  if successful  ";
	$array_selected_search = $result1->fetch_assoc(); 
} else {
	echo "0 results";
}

// Delte these debug echos during integration.
//echo "  Selected search output  ";
//print_r($array_selected_search);

// At this point, we have all the information for the search query.
// wrap the data as with the callback
echo $_GET['callback'].'('.json_encode($array_selected_search).');';

$conn->close(); 

}

?>