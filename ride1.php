<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Matched Drive Details</title>
<link rel="stylesheet" href="login.css">
<link href="https://fonts.googleapis.com/css2?family=Bree+Serif&family=Caveat:wght@400;700&family=Lobster&family=Monoton&family=Open+Sans:ital,wght@0,400;0,700;1,400;1,700&family=Playfair+Display+SC:ital,wght@0,400;0,700;1,700&family=Playfair+Display:ital,wght@0,400;0,700;1,700&family=Roboto:ital,wght@0,400;0,700;1,400;1,700&family=Source+Sans+Pro:ital,wght@0,400;0,700;1,700&family=Work+Sans:ital,wght@0,400;0,700;1,700&display=swap" rel="stylesheet">
<style>
    
    body {
        font-size: 12px; 
    }
    .drive-details {
        position: absolute;
        width: 500px;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        text-align: center;
        background-color: rgba(255, 255, 255, 0.9);
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
    }
    h2 {
        font-size: 24px;
        margin-bottom: 10px;
    }
    p {
        font-size: 18px;
        margin-bottom: 5px;
    }
    button {
        margin-top: 20px;
        padding: 10px 20px;
        font-size: 18px;
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }
    button:hover {
        background-color: #0056b3;
    }
</style>
</head>
<body>
<div class="background">
        <div class="drive-details">
            <h2>Ride Details</h2>
            <?php
            
            if(isset($_GET['rides'])) {
                $rides = json_decode($_GET['rides'], true);

                foreach ($rides as $ride) {
                    echo "<p><strong>From:</strong> {$ride['from_location']}</p>";
                    echo "<p><strong>To:</strong> {$ride['to_location']}</p>";
                    echo "<p><strong>Cost per Person:</strong> {$ride['cost_per_person']}</p>";
                    echo "<p><strong>Starting time:</strong> {$ride['time']}</p>";
                    echo "<p><strong>Available Seats:</strong> {$ride['available_seats']}</p>";
                    echo "<button onclick=\"acceptRide()\">Accept Ride</button>";
                  
                    $servername = "localhost";
                    $username = "root";
                    $password = "";
                    $dbname = "carpool";

                  
                    $conn = new mysqli($servername, $username, $password, $dbname);

                   
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    
                    $insert_sql = "INSERT INTO ride (from_location, to_location, ride_date, ride_time, required_seats) VALUES (?, ?, ?, ?, ?)";

                    $insert_stmt = $conn->prepare($insert_sql);

                    
                    $insert_stmt->bind_param("ssssi", $ride['from_location'], $ride['to_location'], $ride['date'], $ride['time'], $ride['available_seats']);

                    
                    if ($insert_stmt->execute()) {
                        $ride_id = $insert_stmt->insert_id;

                        $insert_stmt->close();
                    } else {
                        echo "Error: " . $insert_stmt->error;
                    }

                    $conn->close();
                }
            } else {
                echo "No ride details found.";
            }
            ?>
        </div>
    </div>

    <script>
        function acceptRide() {
            window.location.href = 'ride2.html'; 
        }
    </script>
    </body>
    </html>