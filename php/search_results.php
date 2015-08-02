<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Portfolio Item - Start Bootstrap Template</title>

    <!-- Bootstrap Core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <!-- jquery and jquery ui-->
    <script src="../external/jquery-ui-1.11.4.custom/external/jquery/jquery.js"></script>
    <link href="../external/jquery-ui-1.11.4.custom/jquery-ui.min.css" rel="stylesheet">
    <script src="../external/jquery-ui-1.11.4.custom/jquery-ui.min.js"></script>

    <!-- custom javascript -->
    <script src="../js/provider_listing.js"></script>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

<?php session_start();
// Getting session variables.
$user_id = $_SESSION["user_id"];
$f_name = $_SESSION["f_name"];
$l_name = $_SESSION["l_name"];
$is_provider = $_SESSION["is_provider"];

?>
<!-- Navigation -->
    <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <a class="navbar-brand" href="#">FoodnFellas</a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav navbar-right" id="userNameOrLogin">
                    <li> <button type="button" class="btn btn-info">Add Food Listing</button> </li>
                </ul>
            </div><!--/.nav-collapse -->
        </div>
    </nav>
<h1>Nidhi</h1>

<?php

//header('Cache-Control: no-cache');
//header('content-type: text/javascript;');
header('Content-Type: text/html; charset=utf-8');

// Delete this during integration cleanup.
$_SERVER['REQUEST_METHOD'] = "POST";

   $array_meal_search_all = array();
   $index=0;

if($_SERVER['REQUEST_METHOD'] == "POST")
{

$return = $_POST;

$provider_food_id = $return["food_provider_id"];

// Delete this hardcoding during final cleanup.
$provider_food_id = 4; 

include 'foodnfellasDBConnection.php';

$sql1 = "SELECT u.user_id, u.f_name, u.l_name, u.photo, p.about_me, p.kitchen_photo, p.food_album, p.awards_won, p.cuisine_i_cook, pf.price_per_person, pf.delivery_method, pf.meal_type, pf.cuisine_type,
                pf.available_start, pf.available_end, pa.street_1, pa.city, pa.state, pa.zip_code, pa.country   
                                 FROM Provider_address as pa 
                                 JOIN Provider_food as pf 
                                 ON pa.provider_food_id = pf.provider_food_id
                                 JOIN Provider as p
                                 ON pf.user_id = p.user_id
                                 JOIN user as u 
                                 ON p.user_id = u.user_id
                                 WHERE pf.provider_food_id = '".$provider_food_id."';";


$meal_details = "SELECT dish_name, meal_description FROM Meal where provider_food_id = '".$provider_food_id."';";

// Delte these debug echos during integration.
//echo "  sql1  ";
//echo $sql1;

$result1 = $conn->query($sql1);
if ($result1->num_rows > 0) {
        // Delte these debug echos during integration.
        //echo "  if successful  ";
	$array_selected_search = $result1->fetch_assoc(); 
    $meal_details_results = $conn->query($meal_details);
    if ($meal_details_results->num_rows >0 ) {
        while($array_meal_search_row = $meal_details_results->fetch_assoc()) { 
            $array_meal_search_all[$index] = $array_meal_search_row;
            echo $array_meal_search_row;
            $index++; 
        }
 
    }

} else {
	echo "0 results";
}



// Delte these debug echos during integration.
//echo "  Selected search output  ";
//print_r($array_selected_search);

// At this point, we have all the information for the search query.
// wrap the data as with the callback
//echo $_GET['callback'].'('.json_encode($array_selected_search).');';

$conn->close(); 

}

?>




<!-- Page Content -->
<div class="container">
    <!-- Portfolio Item Row -->
        <!--// This is provider information. No looping required. -->
                    <br></br>
            <div class="container-fluid">
                <?php 
                   print_r($array_meal_search_all);
                $lst_photo = explode(",", $array_selected_search['food_album']);
                foreach($lst_photo as $item) { ?>
                <div class="col-md-3">
                    <?php if($lst_photo): ?>
                        <img class="img-responsive" id="food_album" src="<?php echo $item;?>" alt="" width="200" height="200">
                    <?php endif; ?>
                </div>
                <?php 
                //echo "$item";
                }
                ?>
                <br>
            <div class="col-md-12">
                <h2> Meal listings of <?php echo $array_selected_search['f_name']; echo " "; echo $array_selected_search['l_name'];?></h3>
            </div>  
            <div class="col-md-3">
                <label for="profile_image">Profile Photo : </label>
                <img class="img-responsive" id="profile_image" src="<?php echo $array_selected_search['photo'];?>" alt="" width="200" height="200">
            </div>
            <div class="col-md-3">
                <label for="AboutMe">About Me:  <?php echo $array_selected_search['about_me'];?></label>
                <output name="AboutMe" id ="AboutMe">
            </div>
            <div class="col-md-3">
                <label for="AwardsWon">Awards Won: <?php echo $array_selected_search['awards_won'];?></label>
                <output name="AwardsWon" id ="AwardsWon">
            </div>
            <div class="col-md-3">
                <label for="Cuisine_I_Cook">Cuisines I Cook: <?php echo $array_selected_search['cuisine_type'];?></label>
                <output name="Cuisine_I_Cook" id ="Cuisine_I_Cook">
            </div>
            <div class="col-md-3 ">
                <label for="price_per_person">Price per person: <?php echo $array_selected_search['price_per_person'];?></label>
                <output name="price_per_person" id ="price_per_person">
            </div>
            <div class="col-md-3">
                <label for="delivery_method">Delivery Method : <?php echo $array_selected_search['delivery_method'];?></label>
                <output name="delivery_method" id ="delivery_method">
            </div>
            <div class="col-md-3 ">
                <label for="meal_type">Cuisine Type : <?php echo $array_selected_search['cuisine_type'];?> </label>
                <output name="meal_type" id ="meal_type">
            </div>
            <div class="col-md-3 ">
                <label for="available_on">Available On : <?php echo $array_selected_search['available_on'];?> </label>
                <output name="available_on" id ="available_on">
            </div>
            <div class="col-md-3 ">
                <dl>
                    <label for="dish_name">Dish Name: <?php echo $array_selected_search['dish_name'];?></label>
                    <dt><output name="dish_name" id ="dish_name" value="<?php echo $array_selected_search['dish_name'];?>"></dt>
                    <label for="meal_description">Dish Description : <?php echo $array_selected_search['meal_description'];?></label>
                    <dt><output name="meal_description" id ="meal_description"></dt>
                </dl>
            </div>

            <div class="col-md-12">
                <label for="profile_image">Kitchen Photo:  </label>
                <img class="img-responsive" id="kitchen_photo" src="<?php echo $array_selected_search['kitchen_photo'];?>" alt="" width="200" height="200">
            </div>

<h4> Order Transaction Page <h>   
<form action="OrderTransactionSubmit.php" method='post' enctype="multipart/form-data">


<br>
<br><br>
<br>
<br>

     <b> Order Input Details </b>   

  <form action="OrderTransactionSubmit.php" method='post' enctype="multipart/form-data">   
   <br> <input type="hidden" name="provider_id" value="7" placeholder="provider_id" />  <br>
   <br> <input type="hidden" name="consumer_id" value="38" placeholder="consumer_id" />  <br>
   <br> <input type="hidden" name="meal_id" value="123" placeholder="meal_id" />  <br>
   <br> <input type="hidden" name="cost" value="100" placeholder="cost" /> <br>
   <br> <input type="hidden" name="DeliveryMethod" value="PICKUP" placeholder="DeliveryMethod" />  <br>
   <br> <input type="text" name="NumberofAdult" value="" placeholder="NumberofAdult" />  <br>
   <br> <input type="text" name="NumberofKids" value="" placeholder="NumberofKids" />  <br>
   <br> <input type="text" name="SpecialNote" value="" placeholder="SpecialNote" style="width: 500px;" />  <br>
   <br> <input type="hidden" name="ReviewID" value="123" placeholder="ReviewID" />  <br>
   
<br>
<div class="col-md-12">
                
<input type='submit' class="btn btn-info btn-large" value='Order' onClick="window.location.reload(true)"/></div>
<div>

</form>   


 
    <!--// This is provider's Meal information.  looping required. -->
 

            

        <!--input type='submit' class="btn btn-primary save" value='Save' onClick="window.location.reload(true)"/>

</div>
<!-- /.container -->

<!-- Bootstrap Core JavaScript -->
<script src="../js/bootstrap.min.js"></script>

</body>

</html>
