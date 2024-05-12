<?php
session_start(); 

$username = $_POST['username'];
$password = $_POST['password'];

$con = new mysqli("localhost", "root", "", "carpool");
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

$stmt = $con->prepare("SELECT * FROM user_info WHERE Username = ? AND Password = ?");
$stmt->bind_param("ss", $username, $password);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 1) {
    $_SESSION['username'] = $username;
    
    $insertStmt = $con->prepare("INSERT INTO login_info (Username, Password, Login_Time) VALUES (?, ?, NOW())");
    $insertStmt->bind_param("ss", $username, $password);
    $insertStmt->execute();

    header("Location: home2.html");
    exit();
} else {
    echo "Invalid username or password. Please try again.";
}

$stmt->close();
$con->close();
?>
