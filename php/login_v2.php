<?php
// Session start.
session_start();
// Hard-coding, change later.
// $_SESSION["user_id"] = 15;
//header('Cache-Control: no-cache');
//header('content-type: text/javascript;');

function test() {
  header("content-type: text/javascript");
  $obj->name = "Mary";
  $obj->message = "Hello World";
  echo $_GET['callback'].'('.json_encode($obj).');';
}


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
      //echo "  Set session user id ";
      //echo $_SESSION["user_id"];
      
      // Set the cookie.
      $array_user_results[$index] = $row;
      $cookie_variable=$row["f_name"]." ".$row["l_name"]." ".$row["user_id"]." ".$row["is_provider"];
      setcookie("FoodnFellas", $cookie_variable);
      $index++; 
      
    }
    echo $_GET['callback'].'('.json_encode($array_user_results).');';
    //echo json_encode($array_user_results);
    $conn->close();
  }
}

//if(isset($_POST['submit']))
//{
  $email_p=$_POST["email"];
  $password_p=md5($_POST["passwd"]);
  $login_type_p=$_POST['login_type'];

  //SignIn($email_p,$password_p,$login_type_p);
  test();
//}

?>
