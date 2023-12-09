<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="serviceStyle.css" rel="stylesheet" type="text/css" />
    <title>Catalog</title>
    <style>
      body {
              background-color: rgb(115, 184, 208);
              color: rgb(255, 255, 255);
              text-align: center;
              font-size: 20px;
          }
    </style>
</head>
<body>
<div class="catalog-center">

<?php
    //storing the usernames and passwords
    $servername = "localhost";
    $username = "us9rh6dk7loi9";
    $password = "5m2Dm^1xo^2D";
    $dbname = "dbpaipqbnjfuel";
    
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    //store data in database
    $uname =  $_REQUEST['uname'];
    $psw = $_REQUEST['psw'];

    //Performing insert query execution
    $sql = "INSERT INTO login VALUES ('$uname', 
            '$psw')";
         
    if(mysqli_query($conn, $sql)){
        echo "User created sucessfully! Welcome ". $uname;
    } else{
        echo "ERROR: Hush! Sorry $sql. " . mysqli_error($conn);
    }
    $conn->close();
?>

</div>
</body>
</html>
