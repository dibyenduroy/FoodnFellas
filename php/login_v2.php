<?php
session_start();





function SignIn($email_p,$password_p,$login_type_p)
{
   //starting the session for user profile page
if(!empty($email_p) )  
{

include 'foodnfellasDBConnection.php';

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    echo "Error Connecting to Database";
  }
 
if($login_type_p==="1") {

$sql = "SELECT *  FROM user where email='".$email_p."'"."AND password='".$password_p."'";

}

if($login_type_p==="2") {

$sql = "SELECT *  FROM user where email='".$email_p."'";

}

if($login_type_p==="3") {

$sql = "SELECT *  FROM user where email='".$email_p."'";

}


//echo $sql;
$result = $conn->query($sql);
$num=$result->num_rows;

//echo "Number of Rows ".$num;



if ($result->num_rows > 0) {
  echo "You are Sucessfully Logged in";
}else {

  echo "Your Username or Password  is Incorrect";
}

$conn->close();
}
}
if(isset($_POST['submit']))
{
   //echo "Password is ".$_POST["passwd"];

  $email_p=$_POST["email"];

  $password_p=md5($_POST["passwd"]);

  $login_type_p=$_POST['login_type'];



  SignIn($email_p,$password_p,$login_type_p);
}

?>