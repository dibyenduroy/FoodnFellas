<?php
header('content-type: text/javascript;');
$array_user_address = array(1,2,3,4);

// wrap the data as with the callback
echo $_GET['callback'] . "(".$array_user_address.");";
?>