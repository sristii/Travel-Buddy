<?php
        // Initialize the session
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
         echo "<h1 class=my-5>Here are your previous trips!</h1>";

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
            echo "You have no records with us. Plan a trip today!<br>";
        }
    ?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Account</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; text-align: center; }
    </style>
</head>
<body>
<br>
    <p>
        <a href="logout.php" class="btn btn-danger ml-3">Sign Out of Your Account</a>
    </p>
</body>
</html>
