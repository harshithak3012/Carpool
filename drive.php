<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "carpool";
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $from_location = $_POST['from'];
    $to_location = $_POST['to'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $available_seats = $_POST['seats'];
    $cost_per_person = $_POST['cost'];
    $car_model = $_POST['carm'];
    $car_company = $_POST['carc'];
    $car_number = $_POST['carno'];
    $car_details_sql = "INSERT INTO car_details (car_company, car_model, car_number) 
                        VALUES ('$car_company', '$car_model', '$car_number')";

    if ($conn->query($car_details_sql) === TRUE) {
        $car_id = $conn->insert_id;
        
        $drive_sql = "INSERT INTO drive (from_location, to_location, date, time, available_seats, cost_per_person, car_number) 
                      VALUES ('$from_location', '$to_location', '$date', '$time', $available_seats, $cost_per_person, '$car_number')";

        if ($conn->query($drive_sql) === TRUE) {
            header("Location: drive1.html");
            exit(); 
        } else {
            $message = "Error inserting into drive table: " . $conn->error;
        }
    } else {
        $message = "Error inserting into car_details table: " . $conn->error;
    }

    $conn->close();
}
?>
