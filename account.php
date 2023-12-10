<?php
        session_start();
        
        // Check if the user is logged in, if not then redirect him to login page
        if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === false){
            header("location: login.php");
            exit;
        }

        //pulling information from storage database by checking if emails match
        $servername = "localhost";
        $username = "us9rh6dk7loi9";
        $password = "5m2Dm^1xo^2D";
        $dbname = "dbwalyrbstfogx";
        
        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $email = $_SESSION["username"];
        $sql = "SELECT * FROM users";
        $result = $conn->query($sql);

        //printing out basic html first
         echo '<nav class="navbar">
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

                   </nav><br><h1 class=my-5>Here are your previous trips!</h1>';

        //check to see if the emails match
        $count = 0;
        if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            if ($row["email"] == $email){
                echo "Name: ". $row["first_name"]. " ".$row["last_Name"]. " <br>Email: ". $row["email"]. "<br> Card: ". $row["card"]. "<br> Package: ". $row["package"]."<br><br>"; 
                $count = $count+1;
            }
        }
        }
       if($count==0){
            echo 'You have no records with us. <a href="catalog.php">Plan a trip today!</a>';
        }
    ?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Account</title>
     <link href="style.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=PT-Serif">
    <style>
        body{text-align: center; }
    </style>
</head>
<body>
<br>
    <p>
        <a href="logout.php" class="btn btn-danger ml-3">Sign Out of Your Account</a>
    </p>
</body>
</html>
