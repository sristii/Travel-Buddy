<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $first_name = $_POST['fname'];
    $last_name = $_POST['lname'];
    $email = $_POST['email'];
    $card = $_POST['card'];
    $package = $_POST['package'];

    // $allDecoded = "";

    // foreach ($_POST as $key => $value) {
    //     if (strpos($key, 'heart') === 0) {
    //         $decoded = htmlspecialchars_decode($value);
    //         echo $decoded;

    //         $allDecoded += $value;
    //     }
    // }

    $postDataMap = array();

    // Check if $_POST is not empty
    if (!empty($_POST)) {
        foreach ($_POST as $key => $value) {
            $postDataMap[$key] = $value;
        }
    }
} else {
    // redirect if accessed directly without submitting the form
    // header('Location: tripForm.html');
    // exit();
}

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
// $first_name =  $_REQUEST['first'];
// $last_name = $_REQUEST['last'];
// $email = $_REQUEST['email'];
// $card = $_REQUEST['cnum'];
// $package = $_REQUEST['package'];

// Performing insert query execution
$sql = "INSERT INTO users  VALUES ('$first_name', 
        '$last_name','$email','$card', '$package', 'hello')";
        
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
    <style type="text/css">
        body {
            width: 100%;
            background-color: #1C6B80;
            font-family:'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
        }
        
    </style>
</head>
<body>
    <div id="user-info"></div>
    <script>
        const fname = <?php echo json_encode($first_name); ?>;
        const lname = <?php echo json_encode($last_name); ?>;
        const email = <?php echo json_encode($email); ?>;
        const card = <?php echo json_encode($card); ?>;
        const package = <?php echo json_encode($package); ?>;

        const pairs = <?php echo json_encode($postDataMap); ?>;
        console.log(pairs);

        // const activities = <?php echo json_encode($allDecoded); ?>;

        // console.log("raw:");
        // console.log(activities);

        // const tempDiv = $('<div/>').html(activities).text();

        // // Get the text content of the div (decoded HTML)

        // console.log("decoded:");
        // console.log(tempDiv);


        $(document).ready(function () {
            const userInfo = `<p>Hi ${fname}, ${lname}</p>`;
            $("#user-info").html(userInfo);


        });
    </script>
</body>
</html>
