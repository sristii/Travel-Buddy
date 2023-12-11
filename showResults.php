<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $first_name = $_POST['fname'];
    $last_name = $_POST['lname'];
    $email = $_POST['email'];
    $card = $_POST['card'];
    $package = $_POST['package'];

    $data_map = array();

    $skipKeys = array('fname', 'lname', 'email', 'card', 'package');

    foreach ($_POST as $key => $value) {
        if (!in_array($key, $skipKeys)) {
            $data_map[$key] = $value;
        }
    }

    // get values to be stored in database
    $data_arr = array_values($data_map);
    $tripInfo = implode('', $data_arr);
} else {
    // redirect if accessed directly without submitting the form
    // header('Location: catalog.php');
    // exit();
}

//storing the required for data
//read data from the form
$servername = "localhost";
$username = "uldx2rdrq1961";
$password = "2*b4$4p^J77C";
$dbname = "db22duqcno8ssd";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$tripInfoText = htmlspecialchars($tripInfo, ENT_QUOTES, 'UTF-8');

// Performing insert query execution
$sql = "INSERT INTO users  VALUES ('$first_name', 
        '$last_name','$email','$card', '$package', '$tripInfoText')";
        
if (!mysqli_query($conn, $sql)){
    echo "ERROR: Sorry $sql. " . mysqli_error($conn);
}
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Results</title>
    <script src="https://code.jquery.com/jquery-3.7.1.slim.js" integrity="sha256-UgvvN8vBkgO0luPSUl2s8TIlOSYRoGFAX4jlCIm9Adc=" crossorigin="anonymous"></script>
    <link href="style.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=PT-Serif">
    <style type="text/css">
        body {
            width: 100%;
            background-color: #1C6B80;
        }
        .page-title {
            margin-top: 50px;
            color: #FFA85C;
            text-align: center;
        }
        .all-containers h2 {
            margin: 10px 0px;
            color: #1C6B80;
            text-align: center;
            width: 100%;
        }


        #cats-container {
            display: block;
            width: 100%;
            margin: 0 auto;
            padding: 0px;
        }
        .catResults {
            width: 100%;
            padding: 10px 0px 30px 0px;
            margin: 0px;
            margin-bottom: 80px;
        }
        .catResults input[type='button'] {
            padding: 10px; /* Adjust the padding as needed */
            display: inline-block;
            border-radius: 0; 
            border: 1px solid grey;
            background-color: white;
        }
        .catResults input[type='button']:hover {
            cursor: pointer;
        }

        .panes {
            display: flex;
            flex-wrap: wrap;
            font-size: 20px;
            width: 100%;
            margin: 0 auto;
            overflow: scroll;
            overflow-x: hidden;
            height: 400px;
        }
        #activity-container {
            background-color: #79ADC0;
        }
        #commercial-container {
            background-color: #79ADC0;
        }
        #natural-container {
            background-color:#79ADC0;
        }
        #cultural-container {
            background-color: #79ADC0;
        }
        #entertain-container {
            background-color: #79ADC0;
        }
        /* hotels */
        #hotels {
            display: block;
            width: 100%;
            margin: 0 auto;
            padding: 0px;
        }
        #hotel-container {
            background-color: #79ADC0;
            width: 100%;
            padding: 10px 0px 30px 0px;
            margin: 0px;
            display: block;
            margin-bottom: 80px;
        }
        /* flights */
        #flights {
            display: block;
            width: 100%;
            margin: 0 auto;
            padding: 0px;
        }
        #flight-container {
            background-color: #79ADC0;
            width: 100%;
            padding: 10px 0px 30px 0px;
            margin: 0px;
            margin-bottom: 80px;
            display: block;
        }

        .place-info {
            text-align: left;
            display: block;
            font-size: 18px;
            padding: 10px;
            padding-bottom: 0px;
            border-radius: 5px;
            line-height: 1.5em;
            margin: 6px;
            width: 300px;
            display: block;
            background-color: white;
            pointer-events: all;
        }

        .all-containers a {
            text-decoration: none;
        }
        .all-containers a:hover {
            cursor: pointer;
            color: #b6a75e;
        }
        .all-containers ul {
            line-height: 1.8em;
            padding-left: 0px;
        }
        .all-containers ul li {
            margin: 20px 0px;
            list-style: none;
            line-height: 1.3em;
        }
        .place-name {
            font-weight: bold;
        }
        .all-containers b {
            font-family: 'Courier New', Courier, monospace;
        }

        /* tag icon with text for labeling results */
        .tag-container {
            position: relative;
            display: inline-block;
        }

        .tag-container img {
            width: 100px;
        }

        .tag-container .tag-text {
            position: absolute;
            top: 40%;
            left: 60%;
            transform: translate(-50%, -50%);
            color: black;
            font-size: 16px;
            text-align: center;
        }        
    </style>
</head>
<body>
<nav class="navbar">
    <ul class="nav-links">
      <li><a href="services.html">Our Services</a></li>
      <li><a href="catalog.php">Plan Your Trip</a></li>
      <li><a href="index.html" class="logo"></a></li>
      <li><a href="story.html">Our Story</a> </li>
      <li><a href="contact.html">Contact Us</a></li>
    </ul>
    <div class="user-icon">
      <a href="login.php"><i class="fa fa-user" style="font-size:36px; color:white;"></i></a>
    </div>
  </nav>
  <div class="dropdown">
        <button onclick="toggleDropdown()" class="dropbtn">☰ Menu</button>
        <div id="dropdownContent" class="dropdown-content">
          <a href="index.html">Home</a>
          <a href="services.html">Our Services</a>
          <a href="catalog.php">Plan Your Trip</a>
          <a href="story.html">Our Story</a>
          <a href="contact.html">Contact Us</a>
          <a href="login.php">Login</a>
        </div>
    </div>
    <div id="user-info"></div>

    <div id="flights">
        <div id='flight-container' class="all-containers">
            <h2>Flights you saved</h2>
            <div class="panes"></div>
        </div>
    </div>

    <div id="hotels">
        <div id='hotel-container' class="all-containers">
            <h2>Hotels you saved</h2>
            <div class="panes"></div>
        </div>
    </div>

    <div id="cats-container" class="all-containers">
        <div class='catResults' id='activity-container'>
            <h2>Activities you saved</h2>
            <div class="panes"></div>
        </div>
    </div>
    <script>
        const savedPanes = <?php echo json_encode($data_map); ?>;

        const package = <?php echo json_encode($package); ?>;
        
        const flightsArr = [];
        const hotelsArr = [];
        const activitiesArr = [];

        console.log(savedPanes);

        for (const key in savedPanes) {
            console.log(key);
            const value = savedPanes[key];

            if (key.startsWith("hotel")) {
                hotelsArr.push(value);
            } else if (key.startsWith("flight")) {
                flightsArr.push(value);
            } else if (key.startsWith("activity")) {
                activitiesArr.push(value);
            }
        }

        $(document).ready(function () {
            const userInfo = `<h1 class='page-title'>Your Saved Trip Ideas</h1>`;
            $("#user-info").html(userInfo);

            if (flightsArr.length == 0) {
                $(`#flight-container .panes`).html("You didn't save any flights."); 
            } else {
                const flightsHtml = flightsArr.join('');
                $(`#flight-container .panes`).html(flightsHtml); 
            }

            if (hotelsArr.length == 0) {
                $("#hotel-container .panes").html("You didn't save any hotels."); 
            } else {
                const hotelsHtml = hotelsArr.join('');
                $("#hotel-container .panes").html(hotelsHtml);
            }

            if (activitiesArr.length == 0) {
                if (package == 'Basic') {
                    $("#activity-container .panes").html("Activities are available on the gold or premium plan."); 
                } else {
                    $("#activity-container .panes").html("You didn't save any activities."); 
                }
            } else {
                const activitiesHtml = activitiesArr.join('');
                $("#activity-container .panes").html(activitiesHtml); 
            }
        });
    </script>
    <footer class="footer">
      <div class="left">
        <!-- Contact Information -->
        <p>Contact Us</p>
        <p>Email: contact@travelbuddy.com</p>
        <p>Phone: +123456789</p>
      </div>
      <div class="social-icons">
        <!-- Social Media Icons -->
        <a href="https://www.instagram.com/" class="icon instagram"><i class="fa fa-instagram"></i></a>
        <a href="https://www.facebook.com/" class="icon facebook"><i class="fa fa-facebook"></i></a>
      </div>
      <div class="right">
        <!-- Copyright Statement -->
        <p>&copy; 2023 </p>
        <p>Travel Buddy</p>
        <p>All rights reserved.</p>
      </div>
    </footer>
</body>
</html>