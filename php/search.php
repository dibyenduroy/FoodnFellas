<?php

header('Cache-Control: no-cache');
header('content-type: text/javascript;');

if($_SERVER['REQUEST_METHOD'] == "POST")
{


$return = $_POST;

$user_id = $_SESSION["user_id"];
//$user_id = 2;
// This will be used in Provider_address table.
$city = $return["where"];
echo $city;
//$city = "Sunnyvale";

// These fields will be used in Provider_food table.
$num_people = $return["num_people"];
$date = $return["when"];
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
$array_meal_search_all = Array();


// Get the entries from Provider_address matching the city.
$sql1 = "SELECT pa.user_id as pui, pa.provider_food_id as pfi FROM Provider_address  as pa JOIN Provider_food as pf 
                                                ON pa.provider_food_id = pf.provider_food_id
                                                WHERE pa.city = 'Sunnyvale';"; 
//                                                AND pf.min_people <= ".$num_people." 
//                                                AND pf.max_people >= ".$num_people."
//                                                AND pf.price_per_person BETWEEN ".$price_low." AND ".$price_high." 
//                                                AND pf.meal_type = ".$meal_type." 
//                                                AND pf.cuisine_type = ".$cuisine_type." 
//                                                AND pf.delivery_method = ".$delivery_method." 
//if (($conn->query($sql1) === TRUE)) {
$result1 = $conn->query($sql1);
//echo "$sql1";

$count = 0;
if ($result1->num_rows > 0) {	
	// Now, return the meal entries. 
	while($row = $result1->fetch_assoc()) {
			$provider_id = $row["pfi"];
    	$sql2 = "SELECT m.dish_name, m.meal_description, m.meal_id, p.about_me, p.awards_won, p.kitchen_photo, p.food_album, p.cuisine_i_cook FROM  Meal as m JOIN Provider as p ON m.user_id = p.user_id WHERE  m.provider_food_id = '".$provider_id."';";
      //echo "$sql2";
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
//print_r($array_output); 

// At this point, we have all the information for the search query.
// wrap the data as with the callback
//echo $_GET['callback'].'('.json_encode($array_output).');';


$conn->close();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
  <meta name="description" content="">
  <meta name="author" content="">

  <title>FoodnFellas</title>

  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>

<body>

<!-- Navigation -->
<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
  <div class="container">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">FoodnFellas</a>
    </div>
    <div id="navbar" class="navbar-collapse collapse">
      <ul class="nav navbar-nav navbar-right">
        <li><a href="/signup" data-toggle="modal" data-target=".social-signup-modal"></a></li>
        <li><a href="/login" data-toggle="modal" data-target=".social-login-modal">MarySmith001</a></li>
        <li> <button type="button" class="btn btn-info" disabled>Become a provider</button> </li>
      </ul>
    </div><!--/.nav-collapse -->
  </div>
</nav>

<div class ="container">
  <div class="starter-template">

    <!-- pre-filled from db info-->
    <div class="row">
      <div class="col-md-4"><label class="search-label"> Where </label> <input type="text" id="where" class="form-control" placeholder="Where?"></div>
      <div class="col-md-4"> <label class="search-label"> Number of People </label><input type="text" id="numPeople" class="form-control" placeholder="No. of people"></div>
      <div class="col-md-4"><label class="search-label">When?</label> <input type="text" id="when" class="form-control" placeholder="Date / Time"></div>
    </div>
    </br>

    <form class="navbar-form" role="search">
      <div class="row-fluid">
        <div class="row">
          <!-- range slider -->
          <div class="col-md-12 price-slider">
            <label for="amount" id="price-slider-label">Price range (per person):</label>
            <input type="text" id="amount" readonly style="border:0; color:#f6931f; font-weight:bold;">
            <div id="slider-range"></div>
          </div>
        </div>


      <div class="container-fluid">
          <h3> All Meal listings</h3>
            <div class="col-md-3">
                <img class="img-responsive" id="photo" src="http://placehold.it/150x150" alt="">
            </div>
            <div class="col-md-3">
                <label for="Name">By: </label>
                <output name="AboutMe" id ="AboutMe">
                <label for="price_per_person">Price per person: $</label>
                <output name="price_per_person" id ="price_per_person" value="<?php echo $count;?>">
            </div>
            <div class="col-md-3">
                <img class="img-responsive" id="photo" src="http://placehold.it/150x150" alt="">
            </div>
            <div class="col-md-3">
                <label for="Name">By: </label>
                <output name="Name" id ="Name">
                <label for="price_per_person">Price per person: $</label>
                <output name="price_per_person" id ="price_per_person">
            </div>
      </div> 

      <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-3"></div>
        <div class="col-md-3">
        </div>
      </div>
    </form>
    </div>
  </div>

<!-- jquery and jquery ui-->
<script src="../external/jquery-ui-1.11.4.custom/external/jquery/jquery.js"></script>
<link href="../external/jquery-ui-1.11.4.custom/jquery-ui.min.css" rel="stylesheet">
<script src="../external/jquery-ui-1.11.4.custom/jquery-ui.min.js"></script>

<!-- Bootstrap Core CSS -->
<link href="../css/bootstrap.min.css" rel="stylesheet">

<!-- Custom styles for this template -->
<link href="../css/search.css" rel="stylesheet">

<!-- Custom Javascript -->
<script src="../js/search_results.js"></script>

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="../js/bootstrap.min.js"></script>
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>

</body>
</html>
