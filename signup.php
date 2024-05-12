<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $con = new mysqli("localhost", "root", "", "carpool");
    if ($con->connect_error) {
        die("Connection failed: " . $con->connect_error);
    }

    $username = $_POST['username'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $number = $_POST['phn_number'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];

    if ($password == $cpassword) {
        $username = $con->real_escape_string($username);
        $firstname = $con->real_escape_string($firstname);
        $lastname = $con->real_escape_string($lastname);
        $number = $con->real_escape_string($number);
        $email = $con->real_escape_string($email);
        $password = $con->real_escape_string($password);

        $sql = "INSERT INTO user_info (Username, First_Name, Last_Name, Phone_No, Email, Password) 
                VALUES ('$username', '$firstname', '$lastname', '$number', '$email', '$password')";

        if ($con->query($sql) === TRUE) {
            header("Location: home2.html");
            exit;
        } else {
            echo "Error: " . $sql . "<br>" . $con->error;
        }
    } else {
        echo "<p>Password and Confirm Password do not match.</p>";
    }
    $con->close();
} else {
    echo "Invalid request method";
}
?>
