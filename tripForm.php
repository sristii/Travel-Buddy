<?php
    $first_name =  $_REQUEST['first'];
    $last_name = $_REQUEST['last'];
    $email = $_REQUEST['email'];
    $card = $_REQUEST['cnum'];
    $package = $_REQUEST['package'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Build Your Trip</title>
     <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=PT-Serif">
    <script src="https://code.jquery.com/jquery-3.7.1.slim.js" integrity="sha256-UgvvN8vBkgO0luPSUl2s8TIlOSYRoGFAX4jlCIm9Adc=" crossorigin="anonymous"></script>
    <style>
        body {
            /* margin: 20px; */
            text-align: center; 
            background-color: white; 
        }

        form {
                display: block;
            margin: 0 auto;
            width: 100%;
            max-width: 600px;
            box-sizing: border-box;
            background-color: aliceblue;
            border-radius: 25px;
            margin-top: 40px;
            padding: 20px 20px;
        }

        #basic-questions label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold; 
        }

        #basic-questions input, #basic-questions select {
            width: 400px;
            padding: 8px;
            margin-bottom: 16px;
            box-sizing: border-box;
            margin-bottom: 25px;
        }

        /* Activities section styling */
        #dietQuestion {
            display: none;
        }

        input, select, textarea {
            margin-bottom: 12px;
            padding: 12px;
            font-size: 16px;
            box-sizing: border-box;
            border-radius: 10px;
            border: 1px solid #b6b6b6;
            width: 400px;
            color: #5b5b5b;
            font-family: 'Averia Serif Libre', serif;
        }
        textarea {
            width: 400px;
            height: 140px;
        }
        input[type="submit"] {
                display: inline-block;
        align-content: center;
        text-align: center;
        background-color: #79adc0;
        color: rgb(255, 255, 255);
        font-size: 22px;
        font-weight: 800;
        padding: 20px;
        border-radius: 20px;
        /* Adding rounded corners */
        border: none;
        cursor: pointer;
        transition: transform 0.3s, background-color 0.3s;
        }        
        input[type="submit"]:hover {
          background-color: #4e92a6;
        /* Change color on hover */
        transform: scale(1.1);
        /* Scale the button slightly on hover */
        color: white;
        }

        input[type="checkbox"] {
            width: fit-content;
            height: fit-content;
        }
        .chkbox-label {
            color: #5b5b5b;
            margin-left: 10px;
        }
        .chkboxes-container {
            display: block;
            margin-left: 160px;
        }

        #activity-questions {
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
                        <br>
  <h1>Just a few more questions...</h1>
    <form id="general-form" onSubmit="return validate()" action="processTripForm.php" method="post">
        <div id="basic-questions">
            <label for="destination">Where are you going?</label>
            <input type="text" id="destination" name="destination" required placeholder="city, state OR city, country">

            <label for="origin">Where are you coming from?</label>
            <input type="text" id="origin" name="origin" required placeholder="city, state OR city, country">

            <label for="departureDate">When are you leaving?</label>
            <input type="date" id="departureDate" name="departureDate" required>

            <label for="returnDate">When are you coming back?</label>
            <input type="date" id="returnDate" name="returnDate">
        </div>

        <div id="activity-questions">
            <p><strong>I want ideas for...</strong></p>
            <input type="checkbox" id="chkCultural" name="activity[]" value="cultural">
            <label for="chkCultural">Cultural and Tourist Activities</label><br />

            <input type="checkbox" id="chkNature" name="activity[]" value="natural">
            <label for="chkNature">Nature Exploration</label><br />

            <input type="checkbox" id="chkCommercial" name="activity[]" value="commercial">
            <label for="chkCommercial">Shopping and Spending</label><br />

            <input type="checkbox" id="chkFood" name="activity[]" value="catering">
            <label for="chkFood">Food and Drink</label><br />

            <input type="checkbox" id="chkAll">
            <label for="chkAll">All the above</label><br />

            <div id="dietQuestion">
                <p><strong>(optional) My dietary restrictions are... </strong></p>
                <input type="checkbox" id="chkVegetarian" name="diet[]" value="vegetarian">
                <label for="chkVegetarian">Vegetarian</label><br />

                <input type="checkbox" id="chkVegan" name="diet[]" value="vegan">
                <label for="chkVegan">Vegan</label><br />

                <input type="checkbox" id="chkHalal" name="diet[]" value="halal">
                <label for="chkHalal">Halal</label><br />

                <input type="checkbox" id="chkKosher" name="diet[]" value="kosher">
                <label for="chkKosher">Kosher</label><br />
            </div>

            <p><strong>(optional) Limit all places to...</strong></p>
            <input type="checkbox" id="chkWheelchair" name="accessibility" value="wheelchair"/>
            <label for="chkWheelchair">Wheelchair-friendly places</label><br />

            <input type="checkbox" id="chkWifi" name="wifi" value="internet_access"/>
            <label for="chkWifi">Places with internet access</label><br />

        </div>
        <input type='submit' value="Build my trip!">
        <div class="input-err"></div>
</form>
<br>
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
<script>
    // if the "All the above" checkbox is clicked, check all the other activities checkboxes.
    $('#chkAll').on('click', function() {
        $('input[name="activity[]"]').prop('checked', this.checked);
    });

    // Toggle the visibility of the question about dietary restrictions
    // based on whether the chkFood checkbox is checked
    $('#chkFood').on('change', function() {
        $('#dietQuestion').toggle(this.checked);
    });

    function validate() {
        let err = "";

        // date validation
        const departDate = new Date($('#departureDate').val());
        const returnDate = new Date($('#returnDate').val());

        // get today's date (excluding time)
        const today = new Date().toISOString().split('T')[0];
        const departDayOnly = departDate.toISOString().split('T')[0];

        // validate departure date
        console.log(departDate);
        if (departDayOnly <= today) {
            err += "Departure date cannot be a past date or today. Please select another date in the future.<br />";
        }

        // validate return date
        if (returnDate < departDate) {
            err += 'Return date cannot be before the departure date. Please select a valid return date.';
        }

        // validate destination is not same as origin location
        const origin = $('#origin').val().trim().toLowerCase();
        const destination = $('#destination').val().trim().toLowerCase();
        if (origin == destination) {
            err += 'Origin and destination cannot be the same place. Please select different locations.';
        }

        if ($('input[name="activity[]"]:checked').length === 0) {
            err += 'Please select at least one category of activities to generate ideas for.<br />';
        }

        if (err !== "") {
            $(".input-err").html("Fix the following errors to continue:<br /><br />" + err);
            return false;
        }

        $(".input-err").html("");

        const fname = <?php echo json_encode($first_name); ?>;
    const lname = <?php echo json_encode($last_name); ?>;
    const email = <?php echo json_encode($email); ?>;
    const card = <?php echo json_encode($card); ?>;
    const package = <?php echo json_encode($package); ?>;
    
    let hiddenInfo = `<input type='hidden' name='fname' value='${fname}'/>`
    + `<input type='hidden' name='lname' value='${lname}'/>`
    + `<input type='hidden' name='email' value='${email}'/>`
    + `<input type='hidden' name='card' value='${card}'/>`
    + `<input type='hidden' name='package' value='${package}'/>`;

    $("#general-form").append(hiddenInfo);
    
        return true;
    }
</script>
</html>