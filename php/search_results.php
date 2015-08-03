<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Carousel Template for Bootstrap</title>

    <!-- Bootstrap core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../css/meal_info.css" rel="stylesheet">
  </head>
<!-- NAVBAR
================================================== -->
  <body>

<?php
header('Content-Type: text/html; charset=utf-8');

// Delete this during integration cleanup.
$_SERVER['REQUEST_METHOD'] = "POST";

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
            //echo $array_meal_search_row;
            $index++; 
        }
 
    }

} else {
    echo "0 results";
}

$conn->close(); 
}
?>


  <!-- Navigation -->
    <nav class="navbar navbar-default navbar-static-top">
      <div class="container">
      <div class="row row-offcanvas row-offcanvas-right">

        <div class="navbar-header">
          <a class="navbar-brand" href="#">FoodnFellas</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="#" data-toggle="modal" data-target=".signupwith-email-modal">Sign Up</a></li>
            <li><a href="#" data-toggle="modal" data-target=".social-login-modal">Login</a></li>
            <li> <button type="button" class="btn btn-info" onclick="providerBtnCallBack()">Become a provider</button> </li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <!-- Carousel
    ================================================== -->
    <div id="myCarousel" class="carousel slide" data-ride="carousel">
      <!-- Indicators -->
      <ol class="carousel-indicators">
        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
        <li data-target="#myCarousel" data-slide-to="1"></li>
        <li data-target="#myCarousel" data-slide-to="2"></li>
      </ol>
      <div class="carousel-inner" role="listbox">
        <?php
        $lst_photo = explode(",", $array_selected_search['food_album']);
        $i=0;
        $array_slide = array("first-slide", "second-slide", "third-slide", "forth-slide", "fifth-slide");
        foreach($lst_photo as $item) {
            if($item) { 
              switch($i) {
                case 0: ?>
                  <div class="item active">
                    <img class="<?php echo $array_slide[$i];?>" src="<?php echo $item;?>" alt="<?php echo $i;?>">
                  </div>
                <?php 
                default: ?>
                <div class="item">
                  <img class="<?php echo $array_slide[$i];?>" src="<?php echo $item;?>" alt="<?php echo $i;?>">
                </div>
              <?php } 
              $i++;
            } 
        //echo "$item";
        }?>
      <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </a>
    </div><!-- /.carousel -->


    <!-- Marketing messaging and featurettes
    ================================================== -->
    <!-- Wrap the rest of the page in another container to center all the content. -->

    <div class="container marketing">

      <!-- Three columns of text below the carousel -->
      <div class="row">
        <div class="col-lg-4">
          <img class="img-circle" src="<?php echo $array_selected_search['photo'];?>" alt="Generic placeholder image" width="140" height="140">
          <h2> <?php echo $array_selected_search['f_name']; echo " "; echo $array_selected_search['l_name'];?></h2>
          <p> <?php echo $array_selected_search['about_me'];?></p>
          <p><a class="btn btn-default" href="#" role="button">View details &raquo;</a></p>
        </div><!-- /.col-lg-4 -->
        <div class="col-lg-4">
          <img class="img-circle" src="http://s3-us-west-2.amazonaws.com/foodnfellas/GoodFoodAward.png" width="140" height="140">
          <h2>Awards Won</h2>
          <p> <?php echo $array_selected_search['awards_won'];?></p>
          <p><output name="AwardsWon" id ="AwardsWon"></p>
        </div><!-- /.col-lg-4 -->

        <div class="col-lg-4" id="orderTransaction">
            <h4> Order Transaction Page <h>   
            <form action="OrderTransactionSubmit.php" method='post' enctype="multipart/form-data">
            <?php session_start();
            // Getting session variables.
            $user_id = $_SESSION["user_id"];
            $f_name = $_SESSION["f_name"];
            $l_name = $_SESSION["l_name"];
            $is_provider = $_SESSION["is_provider"];
            $cost=$array_selected_search['price_per_person'] *10;
            ?> 
               
  <br> <input type="hidden" name="provider_id" value="7" placeholder="provider_id" />  <br>
   <br> <input type="hidden" name="consumer_id" value="38" placeholder="consumer_id" />  <br>
   <br> <input type="hidden" name="meal_id" value="123" placeholder="meal_id" />  <br>
   <br> Cost <input type="text" name="cost" value="120" placeholder="cost" readonly/> <br>
   <br>  Delivery Method <input type="text" name="DeliveryMethod" value="PICKUP" placeholder="DeliveryMethod" readonly />  <br>
   <br> Number of Adults <input type="text" name="NumberofAdult" value="20" placeholder="NumberofAdult" readonly/>  <br>
   <br> NUmber of Kids <input type="text" name="NumberofKids" value="0" placeholder="NumberofKids"  readonly/>  <br>
   <br> Special Note <input type="text" id="SpecialNote" name="SpecialNote" value="" style="line-height: 5em;" placeholder="SpecialNote"/>  <br>
   <br> <input type="hidden" name="ReviewID" value="123" placeholder="ReviewID" />  <br>
    <button type="submit" class="btn btn-danger btn-lg btn-block" onClick="window.location.reload(true)">Order</button>           
  </form>   
        </div>

        <div class="col-lg-4">
          <img class="img-circle" src="http://s3-us-west-2.amazonaws.com/foodnfellas/BackgroundImages/Shukto.jpg" width="140" height="140">
          <h2>Cuisines I Cook</h2>
          <p><?php echo $array_selected_search['cuisine_type'];?></p>
          <p><a class="btn btn-default" href="#" role="button">View details &raquo;</a></p>
        </div><!-- /.col-lg-4 -->

        <div class="col-lg-4">
            <h3>Price per person:</h3> 
            <h4>$ <?php echo $array_selected_search['price_per_person'];?></h4>
        </div>
        <div class="col-lg-4">
            <h3>Delivery Method: </h3>
            <h4> <?php echo $array_selected_search['delivery_method'];?></h4>
        </div>
        <div class="col-lg-4">
            <h3>Cuisine Type: </h3> 
            <h4> <?php echo $array_selected_search['cuisine_type'];?> </h4>
        </div>
        <div class="col-lg-4">
            <h3> Available On: </h3>
            <h4> <?php echo $array_selected_search['available_on'];?> </h4>
        </div>
      </div><!-- /.row --> 
      <!-- FOOTER -->
      <footer>
        <p class="pull-right"><a href="#">Back to top</a></p>
        <p>&copy; 2014 Company, Inc. &middot; <a href="#">Privacy</a> &middot; <a href="#">Terms</a></p>
      </footer>
    </div><!-- /.container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- jquery and jquery ui-->
    <script src="../external/jquery-ui-1.11.4.custom/external/jquery/jquery.js"></script>
    <link href="../external/jquery-ui-1.11.4.custom/jquery-ui.min.css" rel="stylesheet">
    <script src="../external/jquery-ui-1.11.4.custom/jquery-ui.min.js"></script>

    <!-- Custom Javascript -->
    <script src="../js/search_results.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../js/bootstrap.min.js"></script>
  </body>
</html>
