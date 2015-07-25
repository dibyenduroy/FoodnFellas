header('content-type: application/json; charset=utf-8');
$array_user_address = array(1,2,3,4);
echo $_GET['callback'].'('.json_encode($array_user_address).');';