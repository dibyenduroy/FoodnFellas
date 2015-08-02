<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Stylish Portfolio - Start Bootstrap Theme</title>

    <!-- Bootstrap Core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <!-- Custom styles for this template -->
    <link href="../css/index.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../css/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src = "https://plus.google.com/js/client:platform.js" async defer></script>
</head>

<body>

<?php
// Session start.
session_start();
header('Content-Type: text/html; charset=utf-8'); 
// Hard-coding, change later.
// $_SESSION["user_id"] = 15;
//header('Cache-Control: no-cache');
//header('content-type: text/javascript;');


function SignIn($email_p,$password_p,$login_type_p)
{
  //starting the session for user profile page
  if(!empty($email_p) ) {
    //////////////////////
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

    /////////////////////////
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
        echo "Error Connecting to Database";
    }
    if($login_type_p==="1") {
      $sql = "SELECT user_id, is_provider, f_name, l_name  FROM user where email='".$email_p."'"."AND password='".$password_p."'";
      
    }

    if($login_type_p==="2") {
      $sql = "SELECT user_id, is_provider, f_name, l_name   FROM user where email='".$email_p."'";
    }

    if($login_type_p==="3") {
      $sql = "SELECT user_id, is_provider, f_name, l_name     FROM user where email='".$email_p."'";
    }

    //echo $sql;
    $result = $conn->query($sql);
    $num=$result->num_rows;

    $array_user_results = Array();
    $index = 0;


    //echo "Number of Rows ".$num;
    if ($result->num_rows > 0) {
      $row = $result->fetch_assoc();
      // Set the session.
      $_SESSION["user_id"] = $row["user_id"];
      echo "  Set session user id ";
      echo $_SESSION["user_id"];
      
      // Set the cookie.
      $array_user_results[$index] = $row;
      $cookie_variable=$row["f_name"]." ".$row["l_name"]." ".$row["user_id"]." ".$row["is_provider"];
      setcookie("FoodnFellas", $cookie_variable);
      $index++; 
      
    }
    echo $_GET['callback'].'('.json_encode($array_user_results).');';
    $conn->close();
  }
}

//if(isset($_POST['submit']))
//{
  $email_p=$_POST["email"];
  $password_p=md5($_POST["passwd"]);
  $login_type_p=$_POST['login_type'];

  SignIn($email_p,$password_p,$login_type_p);
//}

?>

 
<!-- Navigation -->
<nav class="navbar navbar-default navbar-static-top">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand" href="#">FoodnFellas</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
              if (isset($_SESSION["user_id"])) {
                Hello World
              } else {
                <li><a href="#" data-toggle="modal" data-target=".signupwith-email-modal">Sign Up</a></li>
                <li><a href="#" data-toggle="modal" data-target=".social-login-modal">Login</a></li>
              }
              <li> <button type="button" class="btn btn-info" onclick="providerBtnCallBack()">Become a provider</button> </li>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>

<!--&lt;!&ndash; Social Signup Modal &ndash;&gt;-->
<!--<div class="modal fade social-signup-modal" role="dialog" aria-labelledby="gridSystemModalLabel" aria-hidden="true">-->
    <!--<div class="modal-dialog modal-sm">-->
        <!--<div class="modal-content">-->
            <!--<div class="modal-body">-->
                <!--&lt;!&ndash;<div class="container-fluid">&ndash;&gt;-->
                <!--<div class="omb_login">-->
                    <!--<div class="row omb_socialButtons">-->
                        <!--<div class="fb-login-button col-xs-12" data-max-rows="1" data-size="large" data-show-faces="false"-->
                             <!--data-auto-logout-link="false" scope="public_profile,email" onlogin="checkLoginState();">-->
                        <!--</div>-->
                        <!--<div id="gConnect" class="google-button col-xs-12">-->
                            <!--<button class="g-signin"-->
                                    <!--data-scope="email"-->
                                    <!--data-clientid="214287020717-2nu6arauqkqb8ednahji6lc5ovdnnkcr.apps.googleusercontent.com"-->
                                    <!--data-callback="onSignInCallback"-->
                                    <!--data-theme="dark"-->
                                    <!--data-cookiepolicy="single_host_origin">-->
                            <!--</button>-->
                            <!--&lt;!&ndash; Textarea for outputting data &ndash;&gt;-->
                            <!--<div id="response" class="hide">-->
                                <!--<textarea id="responseContainer" style="width:100%; height:150px"></textarea>-->
                            <!--</div>-->
                        <!--</div>-->
                    <!--</div>-->
                    <!--<div class="row omb_loginOr">-->
                        <!--<div class="col-xs-12">-->
                            <!--<hr class="omb_hrOr">-->
                            <!--<span class="omb_spanOr">or</span>-->
                        <!--</div>-->
                    <!--</div>-->

                    <!--<div class="row">-->
                        <!--<div class="col-xs-12 email-signup">-->
                            <!--<li class="fa fa-envelope"></li>-->
                            <!--<a href="#" data-toggle="modal" data-target=".signupwith-email-modal">Sign up with email</a>-->
                        <!--</div>-->
                    <!--</div>-->
                    <!--</br>-->
                    <!--<div class="row signup-terms">-->
                        <!--By signing up, I agree to FoodnFella's-->
                        <!--<a href="#"> Terms of Service </a>,-->
                        <!--<a href="#"> Privacy Policy </a>, and-->
                        <!--<a href="#"> Refund Policy </a>.-->
                    <!--</div>-->
                <!--</div>-->
            <!--</div>-->
            <!--<div class="modal-footer">-->
                <!--Already a FoodnFellas member?-->
                <!--<a href="#" class="modal-link link-to-login-in-signup" data-modal-href="/login_modal" data-modal-type="login">-->
                    <!--Log in-->
                <!--</a>-->
            <!--</div>-->
        <!--</div>&lt;!&ndash; /.modal-content &ndash;&gt;-->
    <!--</div>&lt;!&ndash; /.modal-dialog &ndash;&gt;-->
<!--</div>&lt;!&ndash; /.modal &ndash;&gt;-->

<!-- Social Signup Modal -->
<div class="modal fade signupwith-email-modal" role="dialog" aria-labelledby="gridSystemModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-body">
                <!--<div class="container-fluid">-->
                <div class="omb_login">
                    <div class="row">
                        <div class="col-xs-12">
                            <form class="omb_loginForm" action="php/registration.php" autocomplete="off" method="post">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                    <input type="text" class="form-control" id = "firstName" name="FirstName" placeholder="First Name">
                                </div>
                                <span class="help-block"></span>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                    <input type="text" class="form-control" id = "lastName" name="LastName" placeholder="Last Name">
                                </div>
                                <span class="help-block"></span>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                    <input type="text" class="form-control" id = "email" name="Email" placeholder="email address">
                                </div>
                                <span class="help-block"></span>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                    <input type="password" class="form-control" id = "password" name="password" placeholder="Password">
                                </div>
                                <span class="help-block"></span>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                    <input type="text" class="form-control" id = "login_type" name="login_type" value="1" placeholder="login_type">
                                </div>
                                <span class="help-block"></span>
                                <button class="btn btn-lg btn-primary btn-block" type="submit" onclick="signupCallBack()">Sign up</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                Already a FoodnFellas member? <a href="/login"> Log in </a>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<!-- Social Login Modal -->
<div class="modal fade social-login-modal" role="dialog" aria-labelledby="gridSystemModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-body">
                <!--<div class="container-fluid">-->
                    <div class="omb_login">
                        <!--<div class="row omb_socialButtons">-->
                            <!--<div class="fb-login-button col-xs-12" data-max-rows="1" data-size="large" data-show-faces="false"-->
                                 <!--data-auto-logout-link="false" scope="public_profile,email" onlogin="checkLoginState();">-->
                            <!--</div>-->
                            <!--<div id="gConnect" class="google-button col-xs-12">-->
                                <!--<button class="g-signin"-->
                                        <!--data-scope="email"-->
                                        <!--data-clientid="214287020717-2nu6arauqkqb8ednahji6lc5ovdnnkcr.apps.googleusercontent.com"-->
                                        <!--data-callback="onSignInCallback"-->
                                        <!--data-theme="dark"-->
                                        <!--data-cookiepolicy="single_host_origin">-->
                                <!--</button>-->
                                <!--&lt;!&ndash; Textarea for outputting data &ndash;&gt;-->
                                <!--<div id="response" class="hide">-->
                                    <!--<textarea id="responseContainer" style="width:100%; height:150px"></textarea>-->
                                <!--</div>-->
                            <!--</div>-->
                        <!--</div>-->
                        <!--<div class="row omb_loginOr">-->
                            <!--<div class="col-xs-12">-->
                                <!--<hr class="omb_hrOr">-->
                                <!--<span class="omb_spanOr">or</span>-->
                            <!--</div>-->
                        <!--</div>-->
                        <div class="row">
                            <div class="col-xs-12">
                                <form class="omb_loginForm" action="php/login_v2.php" autocomplete="off" method="POST">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                        <input type="text" class="form-control" name="email" placeholder="email address">
                                    </div>
                                    <span class="help-block"></span>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                        <input type="password" class="form-control" name="passwd" placeholder="Password">
                                    </div>
                                    <span class="help-block"></span>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                        <input type="text" class="form-control" name="login_type" value="1" placeholder="login_type">
                                    </div>
                                    <span class="help-block"></span>
                                    <button class="btn btn-lg btn-primary btn-block" id="login-btn" type="submit" onclick="login_as_user()">Login</button>
                                </form>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <label class="checkbox" id="remember-me">
                                    <input type="checkbox" value="remember-me">Remember Me
                                </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <p class="omb_forgotPwd">
                                    <a href="#">Forgot password?</a>
                                </p>
                            </div>
                        </div>
                </div>
            </div>
            <div class="modal-footer">
                Don't have an account? <a href="/signup"> Sign up </a>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<!-- Header -->
<header id="top" class="header">
    <div class="text-vertical-center">
        <h1>Looking for home cooked food?</h1>
        <br>
        <a href="#about" class="btn btn-dark btn-lg">How it works</a>

        <form class="navbar-form search-form" role="search">
            <div class="form-group">
                <input type="text" id="where" class="form-control" placeholder="Where?">
                <input type="text" id="numPeople" class="form-control" placeholder="No of people">
                <input type="text" id="when" class="form-control" placeholder="When?">
            </div>
            <button type="button" class="btn btn-default" id="search-btn" onclick="searchBtnCallBack()">Search</button>
        </form>
    </div>
</header>

<!-- About -->
<section id="about" class="about">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2>FoodnFellas is an online marketplace and delivery service for home cooked food.</h2>
                <p class="lead">Instead of having to contend with commercially prepared food and the same menus day
                    in and day out, explore the joy of discovering authentic and healthy food from real people,
                    straight from their home kitchens.</p>
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container -->
</section>

<!-- Services -->
<!-- The circle icons use Font Awesome's stacked icon classes. For more information, visit http://fontawesome.io/examples/ -->
<section id="services" class="services bg-primary">
    <div class="container">
        <div class="row text-center">
            <div class="col-lg-10 col-lg-offset-1">
                <h2>Food Consumers</h2>
                <hr class="small">
                <div class="row">
                    <div class="col-md-4 col-sm-6">
                        <div class="service-item">
                                <span class="fa-stack fa-4x">
                                <i class="fa fa-circle fa-stack-2x"></i>
                                <i class="fa fa-stack-1x text-primary">1</i>
                            </span>
                            <h4>
                                <strong>DISCOVER AMAZING HOME COOKED FOOD</strong>
                            </h4>
                            <p>Scroll through numerous listings for delicious and healthy home cooked food of your chosen cuisine type.</p>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <div class="service-item">
                                <span class="fa-stack fa-4x">
                                <i class="fa fa-circle fa-stack-2x"></i>
                                <i class="fa fa-stack-1x text-primary">2</i>
                            </span>
                            <h4>
                                <strong>BOOK YOUR ORDER</strong>
                            </h4>
                            <p>Place your order with food provider of choice. Choose your delivery option. You can
                                also request customization.</p>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <div class="service-item">
                                <span class="fa-stack fa-4x">
                                <i class="fa fa-circle fa-stack-2x"></i>
                                <i class="fa fa-stack-1x text-primary">3</i>
                            </span>
                            <h4>
                                <strong>ENJOY DELICIOUS HOME COOKED FOOD</strong>
                            </h4>
                            <p>Enjoy the goodness of home cooked meals from the comfort of your home or office.</p>
                        </div>
                    </div>
                </div>
                <!-- /.row (nested) -->
                <h2>Food Providers</h2>
                <hr class="small">
                <div class="row">
                    <div class="col-md-4 col-sm-6">
                        <div class="service-item">
                                <span class="fa-stack fa-4x">
                                <i class="fa fa-circle fa-stack-2x"></i>
                                <i class="fa fa-stack-1x text-primary">1</i>
                            </span>
                            <h4>
                                <strong>LIST YOUR DISHES</strong>
                            </h4>
                            <p>Setup your posting with the dishes you cook and the date and times when you can provide the food.</p>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <div class="service-item">
                                <span class="fa-stack fa-4x">
                                <i class="fa fa-circle fa-stack-2x"></i>
                                <i class="fa fa-stack-1x text-primary">2</i>
                            </span>
                            <h4>
                                <strong>CONFIRM ORDERS</strong>
                            </h4>
                            <p>Confirm requested bookings from interested customers. Prepare the food to meet the order. </p>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <div class="service-item">
                                <span class="fa-stack fa-4x">
                                <i class="fa fa-circle fa-stack-2x"></i>
                                <i class="fa fa-stack-1x text-primary">3</i>
                            </span>
                            <h4>
                                <strong>PROVIDE FOOD</strong>
                            </h4>
                            <p>Based on the delivery option chosen, provide the food to the customers or delivery folks.</p>
                        </div>
                    </div>
                </div>
                <!-- /.row (nested) -->
            </div>
            <!-- /.col-lg-10 -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container -->
</section>

<!-- Footer -->
<footer>
    <div class="container">
        <div class="row">
            <div class="col-lg-10 col-lg-offset-1 text-center">
                <h4><strong>FoodnFellows</strong>
                </h4>
                <p>Carnegie Mellon University<br>Silicon Valley, CA 94043</p>
                <ul class="list-unstyled">
                    <li><i class="fa fa-phone fa-fw"></i> (123) 456-7890</li>
                    <li><i class="fa fa-envelope-o fa-fw"></i>  <a href="mailto:name@example.com">name@example.com</a>
                    </li>
                </ul>
                <br>
                <ul class="list-inline">
                    <li>
                        <a href="#"><i class="fa fa-facebook fa-fw fa-3x"></i></a>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-twitter fa-fw fa-3x"></i></a>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-dribbble fa-fw fa-3x"></i></a>
                    </li>
                </ul>
                <hr class="small">
                <p class="text-muted">Copyright &copy; Your Website 2014</p>
            </div>
        </div>
    </div>
</footer>


<!-- jquery and jquery ui-->
<script src="../external/jquery-ui-1.11.4.custom/external/jquery/jquery.js"></script>
<link href="../external/jquery-ui-1.11.4.custom/jquery-ui.min.css" rel="stylesheet">
<script src="../external/jquery-ui-1.11.4.custom/jquery-ui.min.js"></script>

<script src="../js/bootstrap.min.js"></script>

<!-- Custom Javascript -->
<!--<script src="js/social_login.js"></script>-->
<script src="../js/index_afterlaunch.js"></script>

<!-- Custom Theme JavaScript -->
<script>
    // Closes the sidebar menu
    $("#menu-close").click(function(e) {
        e.preventDefault();
        $("#sidebar-wrapper").toggleClass("active");
    });

    // Opens the sidebar menu
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#sidebar-wrapper").toggleClass("active");
    });

    // Scrolls to the selected menu item on the page
    $(function() {
        $('a[href*=#]:not([href=#])').click(function() {
            if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') || location.hostname == this.hostname) {

                var target = $(this.hash);
                target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
                if (target.length) {
                    $('html,body').animate({
                        scrollTop: target.offset().top
                    }, 1000);
                    return false;
                }
            }
        });
    });
</script>

</body>

</html>


