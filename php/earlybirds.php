<html>
<body bgcolor="#D8D8D8">

<b>Thanks <?php echo $_POST["fname"]." ".$_POST["lname"]; ?> for being an evangilist of our product!!!!!</b><br>



<br> <br>
<?php
$servername = "fm1s2t7e010rjki.cnn0dbzvr04c.us-west-2.rds.amazonaws.com";
$username = "fnfsandbox";
$password = "greatfood123";
$dbname = "myDatabase";

$fname = $_POST['fname'];
$lname = $_POST['lname'];
$email = $_POST['email'];

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "INSERT INTO earlysignups (firstname,lastname,  email) VALUES ('".$fname."','".$lname."',  '".$email."')";

if ($conn->query($sql) === TRUE) {
    echo "We will Invite you during our launch this Fall , stay tuned!!!!!!";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
     }

$conn->close();?>

</body>

</html>
