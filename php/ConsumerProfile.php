<?php header('content-type: application/json; charset=utf-8');

session_start();
$_SESSION["user_id"] = $_GET["userid"];
#$session_user_id=$_SESSION["user_id"];
$session_user_id=4;

include('image_check.php');
header('Cache-Control: no-cache');
//

getConsumerphoto();
function getConsumerphoto() {

$array_user_address = array(
    'hello' => 'world'
);

echo $_GET['callback'].'('.json_encode($array_user_address).');';
}
?>
