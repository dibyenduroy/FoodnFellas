<html>
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

<?php
    // Session start.
    session_start();
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
      <ul class="nav navbar-nav navbar-right">
        <li><a href="/signup" data-toggle="modal" data-target=".social-signup-modal"></a></li>
        <li><a href="/login" data-toggle="modal" data-target=".social-login-modal"> <?php  echo  "     ".$f_name; ?> </a></li>
        <li> <button type="button" class="btn btn-info" disabled>Become a provider</button> </li>
      </ul>
    </div><!--/.nav-collapse -->
  </div>
</nav>
<h1>Nidhi</h1>

<div class ="container">
  <div class="starter-template">
          <div class="container-fluid">

         <h3> All Meal listings</h3>

    <?php
    // Session start.
    //session_start();
    // Getting session variables.
    //$user_id = $_SESSION["user_id"];
    //$f_name = $_SESSION["f_name"];
    //$l_name = $_SESSION["l_name"];
    //$is_provider = $_SESSION["is_provider"];

    // header('Cache-Control: no-cache');
    //header('content-type: text/javascript;');
    header('Content-Type: text/html; charset=utf-8');

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
    $array_meal_search_all = array();

    // Get the entries from Provider_address matching the city.
    $sql1 = "SELECT pa.user_id as pui, pa.provider_food_id as pfi FROM Provider_address  as pa JOIN Provider_food as pf
                                                    ON pa.provider_food_id = pf.provider_food_id
                                                    WHERE pa.city = 'Livermore';";
    //                                                AND pf.min_people <= ".$num_people."
    //                                                AND pf.max_people >= ".$num_people."
    //                                                AND pf.price_per_person BETWEEN ".$price_low." AND ".$price_high."
    //                                                AND pf.meal_type = ".$meal_type."
    //                                                AND pf.cuisine_type = ".$cuisine_type."
    //                                                AND pf.delivery_method = ".$delivery_method."
    //if (($conn->query($sql1) === TRUE)) {
    $result1 = $conn->query($sql1);
    //echo "$sql1";
    $counter = 0;
    if ($result1->num_rows > 0) {
        // Now, return the meal entries.
        while($row = $result1->fetch_assoc()) {
                $provider_id = $row["pfi"];
            $sql2 = "SELECT m.provider_food_id,m.meal_id, u.f_name, u.user_id, 
       u.l_name, pf.price_per_person, u.photo
       FROM Meal as m JOIN user as u ON u.user_id = m.user_id 
       JOIN Provider_food as pf ON pf.provider_food_id = m.provider_food_id
            WHERE m.provider_food_id = '".$provider_id."';";
         //echo "$sql2";
          $index = 0;
          $result2 = $conn->query($sql2);
          if ($result2->num_rows > 0) {
              while($array_meal_search_row = $result2->fetch_assoc()) { 
                $array_meal_search_all[$index] = $array_meal_search_row;
                $index++; 
                //print_r($array_meal_search_row);
                $counter++; 
                $pfid = $array_meal_search_row['provider_food_id'];
                echo $pfid;
                /*echo("<div>".$array_meal_search_row['photo']."</div>");
                  echo ("<div class='col-md-6'><img class='img-responsive' id='photo' src=".$array_meal_search_row['photo']." alt=''></div><div class='col-md-3'>");
                  echo ("<label for='Name'>By: ".$array_meal_search_row['f_name']." ".$array_meal_search_row['l_name']."  "."</label>");
                  echo ("<label for='price_per_person'>Price per person: ".$array_meal_search_row['price_per_person']."</label></div>");*/
                  ?>
              <div class="col-md-6">
      
                
                <a href="../php/search_results.php?pfid=<?php $pfid?>"><img class="img-responsive" id="photo" src="<?php echo $array_meal_search_row['photo'];?>" alt=""></a>
                <label for="Name">By:<?php echo $array_meal_search_row['f_name']." ".$array_meal_search_row['l_name']."  "; ?> </label>
                <label for="price_per_person">Price per person: <?php echo $array_meal_search_row['price_per_person'] ?> </label>
              </div>
<?php
            /*     <input type="hidden" name="provider_food_id" value="<?php echo $array_meal_search_row['provider_food_id']; ?>">
            <a data-toggle="modal" data-userid="<?php echo $array_meal_search_row['provider_food_id']; ?>" href="../php/search_results.php#myModal" class="btn btn-warning">*/
              //print_r($array_meal_search_row);
              //$array_meal_search_all = array_merge($array_meal_search_all, $array_meal_search_row);
            }
        //echo "\n";
            //print_r($array_meal_search_all);
          }
      }
    } else {
        echo "0 results";
        echo "The is some issue in conn->query";
    }
    $array_count_elem = array(
        "counter"  => $counter
        );
    //$count;
    //echo $_GET['callback'].'('.json_encode($array_output).');';
    $conn->close();
    }


?>

            
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
