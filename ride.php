<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $from = $_POST["from"];
    $to = $_POST["to"];
    $date = date('Y-m-d', strtotime($_POST["date"])); 
    $time = $_POST["time"];
    $required_seats = $_POST["seats"];

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "carpool";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM drive WHERE from_location = ? AND to_location = ? AND date = ? AND time >= ? AND available_seats >= ?";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param("ssssi", $from, $to, $date, $time, $required_seats);

    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $rows = $result->fetch_all(MYSQLI_ASSOC);
        
        $query_params = http_build_query(array("rides" => json_encode($rows)));
        header("Location: ride1.php?$query_params");
        exit;

    } else {
        echo "No matching drives found for the specified details.";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request method. Please use a POST request.";
}
?>
