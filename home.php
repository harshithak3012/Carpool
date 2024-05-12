<?php
$servername = "localhost";
$username = "root";
$password = ""; 
$dbname = "carpool";
$con = mysqli_connect($servername, $username, $password, $dbname);
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    $sql = $con->prepare("INSERT INTO contact_email (email) VALUES (?)");
    $sql->bind_param("s", $email); 

    if ($sql->execute()) {
        echo "Email address saved successfully";
    } else {
        echo "Error: " . $sql->error;
    }
    $sql->close();
}
mysqli_close($con);
?>
