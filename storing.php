<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="serviceStyle.css" rel="stylesheet" type="text/css" />
    <title>Catalog</title>
    <style>
        .btn {
            background-color: rgb(36, 125, 155);
            color: white;
            padding: 12px;
            margin: 10px 0;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            font-size: 17px;
        }

        .btn:hover {
            background-color: rgb(65, 153, 183);
        }
      body {
              background-color: rgb(115, 184, 208);
              color: rgb(255, 255, 255);
              text-align: center;
              font-size: 20px;
          }

        .container {
        padding: 16px;
        }

        /* Full-width input fields */
        input[type=text], input[type=password] {
            width: 100%;
            padding: 12px 20px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }
        /* The Modal (background) */
        .modal {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 1; /* Sit on top */
            left: 0;
            top: 0;
            width: 100%;
            height: 100%; 
            overflow: auto; /* Enable scroll if needed */
            background-color: rgb(0,0,0); /* Fallback color */
            background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
            padding-top: 60px;
        }

        /* Modal Content/Box */
        .modal-content {
            background-color: #fefefe;
            margin: 5% auto 15% auto; /* 5% from the top, 15% from the bottom and centered */
            border: 1px solid #888;
            width: 80%; 
        }

        /* The Close Button (x) */
        .close {
            position: absolute;
            right: 25px;
            top: 0;
            color: #000;
            font-size: 35px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: red;
            cursor: pointer;
        }
    </style>
</head>
<body>
<div class="catalog-center">

<?php
    //storing the required for data
    //read data from the form
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

    //store data in database
    $first_name =  $_REQUEST['first'];
    $last_name = $_REQUEST['last'];
    $email = $_REQUEST['email'];
    $card = $_REQUEST['cnum'];
    $package = $_REQUEST['package'];

    // Performing insert query execution
    $sql = "INSERT INTO users  VALUES ('$first_name', 
            '$last_name','$email','$card', '$package')";
         
    if(mysqli_query($conn, $sql)){
        echo "Thank you ". $first_name . " for your purchase! Would you like to create an account?<br>
            <button class=btn onclick=document.getElementById('login').style.display='block' style=width:auto;> yes </button> <button class=btn> no </button>";
    } else{
        echo "ERROR: Hush! Sorry $sql. " . mysqli_error($conn);
    }
    $conn->close();
?>

<div id="login" class="modal">
  
  <form class="modal-content animate" action="login.php" method="post">
    <div class="imgcontainer">
      <span onclick="document.getElementById('login').style.display='none'" class="close" title="Close Modal">&times;</span>
    </div>

    <div class="container">
    <form onSubmit="return validateUser()" method="GET">
      <label for="uname"><b style="color:black">Username</b></label>
      <input type="text" placeholder="Enter Username" id="uname" name="uname" required>
      <label for="psw"><b style="color:black">Password</b></label>
      <input type="password" placeholder="Enter Password" id="psw" name="psw" required>
      <button type="submit" class="btn">Login</button>  
       <button type="button" onclick="document.getElementById('login').style.display='none'" class="btn">Cancel</button>
    </form>
    </div>
  </form>
</div>

<script>
    // Get the modal
    var modal = document.getElementById('login');

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>

<script>
        //checking the login databse to make sure that the username is new
        function validateUser(){
            var name = document.getElementById("uname").value;
            <?php
                $servername = "localhost";
                $username = "us9rh6dk7loi9";
                $password = "5m2Dm^1xo^2D";
                $dbname = "dbpaipqbnjfuel";

                $name = name;
                
                // Create connection
                $conn = new mysqli($servername, $username, $password, $dbname);
                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }
                
                $result = mysql_query("SELECT * FROM login");
                $num_rows = mysql_num_rows($result);

                //if there are any usernames in the database
                if ($num_rows > 0) {

                    // $taken = mysql_query("SELECT uname FROM login WHERE uname=test4");
                    //check if the username is already taken
                    // if ($taken > 0){
                    //     return false;
                    // }
                    // else{
                    //     return true;
                    // }
                    return false;
                }
                // return true;
                $conn->close();
            ?>
            console.log("tes");
        }
    </script>
</div>
</body>
</html>
