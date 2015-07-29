<?php

test_function();

//Function to check if the request is an AJAX request
function is_ajax() {
  return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
}

function test_function() {
    $return = $_POST;
    // login_type : if login_type =1 (It means it comes from Form login) , if login_type =2 (It means it comes from FB)
    //if login_type =3 (It means it comes from Form Google)

    $fname = $return["FirstName"];
    $lname = $return["LastName"];
    $email = $return["Email"];
    $user_password = md5($return["password"]);
    $login_type = $return["login_type"];


    $return["Status"] = (strcmp($fname, "") != 0)  ;

    if (strcmp($fname, "") != 0 ){
      $return["Status"] = "hello";
    }

    if (strcmp($fname, "") != 0 && strcmp($lname, "") != 0 ) {
      $return["Status"] = "hello0";
      include 'foodnfellasDBConnection.php';
      if($login_type==="1") {
        $sql = "INSERT INTO user (f_name,l_name,email,password) VALUES ('".$fname."', '".$lname."',  '".$email."', '".$user_password."')";
      }// login_type : if login_type =1 (It means it comes from Form login) , if login_type =2 (It means it comes from FB)
     //if login_type =3 (It means it comes from Form Google)
      if ($login_type==="2") {
        $sql = "INSERT INTO user (f_name,l_name,email,fb_login) VALUES ('".$fname."',  '".$lname."',  '".$email."','".$email."')";
      }
      // login_type : if login_type =1 (It means it comes from Form login) , if login_type =2 (It means it comes from FB)
      //if login_type =3 (It means it comes from Form Google)
      if ($login_type==="3") {
        $sql = "INSERT INTO user (f_name,l_name,email,google_login) VALUES ('".$fname."',  '".$lname."',  '".$email."','".$email."')";
      }
      if ($conn->query($sql) === TRUE) {
        $return["Status"] = "Success";
      }else {
        $return["Status"] = "hello4";
        $return["Status"] = "Error";
        $return["Error"] = $conn->error;
      }
      $conn->close();
    }
    $return["json"] = json_encode($return);
    echo json_encode($return);
}

?>