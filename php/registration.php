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

    $array_user_info = Array();
    $index = 0;
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
        $sql2 = "SELECT user_id, is_provider, f_name, l_name FROM user where email = '".$email."' AND password = '".$user_password."'";
        $user_info = $conn->query($sql2);
        $num=$user_info->num_rows; 
        //echo "Number of Rows ".$num;
        if ($user_info->num_rows > 0) {
          while ($row = $user_info->fetch_assoc()) {
            $array_user_info[$index] = $row;
            $cookie_variable=$row["f_name"]." ".$row["l_name"]." ".$row["user_id"]." ".$row["is_provider"];
            setcookie("FoodnFellas", $cookie_variable);
            $index++; 
          }
        }
      }else {
        $return["Status"] = "Error";
        $return["Error"] = $conn->error;
      }

    //echo $_GET['callback'].'('.json_encode($array_user_info).');';
    $conn->close();
    }
    $return["json"] = json_encode($return);

    $merged_array = array_merge($result, $array_user_info);
    //echo json_encode($return);
    echo $_GET['callback'].'('.json_encode($merged_array).');';
}

?>