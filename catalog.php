<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <title>Catalog</title>
    <link href="style.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=PT-Serif">
  <style>
        input[type=text] {
        width: 80%;
        margin-bottom: 20px;
        padding: 12px;
        border: 1px solid #ccc;
        border-radius: 3px;
        }

        #catalog {
            padding: 40px;
            display: flex;
            justify-content: space-between;
        }

        .box h3{
          color: #ffcda1;
        }

      .icon-container {
        margin-bottom: 20px;
        padding: 7px 0;
        display: flex;
        } 

        .icon-container label {
          padding: 10px;
        }

        .icon-container label {
          padding: 10px;
        }

        .box:hover {
        background-color: #4e92a6;
        /* Change color on hover */
        transform: scale(1.1);
        /* Scale the button slightly on hover */
        color: white;
      }

        .box{
            display: block;
            text-align: center;
            position: relative;
            box-sizing: border-box;
            background-color: rgb(115, 184, 208);
            color: rgb(255, 255, 255);
            float: left;
            width: 30%;
            padding: 20px 20px;
            /* height: 500px; */
            margin: 5px;
            font-size: 22px;
            border-radius: 25px;
        }

        @media screen and (max-width: 768px){
            .catalog-center{
                display: flex; 
                flex: 1; 
                align-items: center; 
                flex-direction: column; 
            }
            .box{
                width: 80%; 
                margin-bottom: 50px; 
            }
        }

        .payBox {
            display: block;
            margin: 0 auto;
            width: 100%;
            max-width: 600px;
            box-sizing: border-box;
            background-color: aliceblue;
            border-radius: 25px;
            margin-top: 40px;
        }
        form {
            background-color: aliceblue;
            text-align: center;
            border-radius: 5px;
            padding-top: 10px;
            display: block;
            margin: 0 auto;
            width: 100%;
            max-width: 410px;
            box-sizing: border-box;
            
        }
        form h4 {
            text-align: center;
            font-size: 24px;
            color: #2a3d45;
        }
		#error {
            color: #496f5d;
            margin-bottom: 80px;
            text-align: left;
            line-height: 1.4em;
            height: 150px;
        }
		label {
            display: block;
            margin-bottom: 8px;
            font-weight: 700;
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

        .btns {
          text-align: center;
        }

        .button {
          display: inline-block;
          align-content: center;
          text-align: center;
          background-color: #79adc0;
          color: rgb(255, 255, 255);
          font-size: 22px;
          font-weight: 800;
          padding: 20px;
          border-radius: 20px;
          border: none;
          cursor: pointer;
          transition: transform 0.3s, background-color 0.3s;
        }

        .button:hover {
          background-color: #4e92a6;
          /* Change color on hover */
          transform: scale(1.1);
          /* Scale the button slightly on hover */
          color: white;
}

        

    </style>
    <script>
        //card validation functions from w3resources
        //visa
        function validateVisa(cardNum)
        {
            var cardno = /^(?:4[0-9]{12}(?:[0-9]{3})?)$/;
            if(cardNum.match(cardno)){
                return true;
            }
            else{
                return false;
            }
        }

        //discover
        function validateDiscover(cardNum)
        {
            var cardno = /^(?:6(?:011|5[0-9][0-9])[0-9]{12})$/;
            if(cardNum.match(cardno)){
                return true;
            }
            else{
                return false;
            }
        }

        //american express
        function validateAE(cardNum)
        {
            var cardno = /^(?:3[47][0-9]{13})$/;
            if(cardNum.match(cardno)){
                return true;
            }
            else{
                return false;
            }
        }
        //master card
        function validateMaster(cardNum)
        {
            var cardno = /^(?:5[1-5][0-9]{14})$/;
            if(cardNum.match(cardno)){
                return true;
            }
            else{
                return false;
            }
        }

        function validatePhone() {
            const phone = document.getElementById("phone").value;
            if (phone == "") {
                return true;
            } else {
                return phone.match(/^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/);
            }
        }

        function validateEmail() {
            const email = document.getElementById("email").value;
            return email.match(/^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i);
        }

        function validate() {
            reqFields = {
                fname: "First Name",
                lname: "Last Name",
                email: "Email",
                cnum: "Card",
            };
            let err = "";
            for (const id in reqFields) {
                if (document.getElementById(id).value == "") {
                    err += reqFields[id] + " is required.<br />";
                }
            }

            if (!validatePhone()) {
                err += "Invalid phone number.<br />";
            }
            if (!validateEmail()) {
                err += "Email format does not match <em>username@domain.tld</em><br />";
            }

            //checking the credit card num depending on type of card used
           if (document.getElementById("visa").checked){
                if (!validateVisa(document.getElementById("cnum").value)){
                    err += "Not a valid Visa credit card number";
                }
           }
           else if (document.getElementById("discover").checked){
                if(!validateDiscover(document.getElementById("cnum").value)){
                    err += "Not a valid Discover credit card number";
                }
           }
           else if (document.getElementById("mastercard").checked){
                if(!validateMaster(document.getElementById("cnum").value)){
                    err += "Not a valid MasterCard credit card number";
                }
           }
           else if (document.getElementById("AE").checked){
                if(!validateAE(document.getElementById("cnum").value)){
                    err += "Not a valid American Eagle credit card number";
                }
           }
           else{
            err += "Please select a payment type"
           }

            if (err != "") {
                document.getElementById('error').innerHTML =
                    "Fix the following errors to continue:<br><br>" + err;
                return false;
            }
            //if no errors
            if (err == ""){
                document.getElementById('error').innerHTML = "";
                alert("Thanks for purchasing!");
                return true;
            }
        }

        //function to make the purchase pop up
        function purchase(name, cost){
            document.getElementById("catalog").style.display = 'none';
            document.getElementById("payBox").style.display = 'block';
            document.getElementById("packageType").innerHTML = "Package: "+name;
            document.getElementById('package').value = name;
            document.getElementById("total").innerHTML = "Total: $"+cost;
        }

        //function to go back to packages
        function back(){
            document.getElementById("catalog").style.display = 'block';
            document.getElementById("payBox").style.display = 'none';
        }
    </script>
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
  
    <header class="hero-section">
    <img src="images/plan-bg.jpg" alt="Overhead view of a beach shore, bright blue water">

    <div class="hero-text">Catalog</div>
  </header>
   <br>

    <div class="catalog-center" id="catalog">
        <div class="box" onclick="purchase('Basic', 5)" id ="box1">
            <h3>Basic Plan</h3>
            <br><br>
            With the basic plan you will get information about flights and hotels for
            your desired destination! We will provide you with a plethora of flights and a variety
            of hotels so you can choose whichever best suits your needs! Keeping it simple and sweet, our basic plan
            knows how to make ends meet!
            <br><br><br>
            <h3>Cost: $50</h3>
        </div>
        <div class="box" onclick="purchase('Gold', 80)" id="box2">
            <h3>Gold Plan</h3>
            <br><br>
            Our Gold Option adds events for you do at your destination! You will get all of the 
            information about flights and hotels that are included with our basic plan, with the addition
            of locations and attractions that are a must see at your destination. You'll be able to choose
            from the myriad of possibilities that we provide you!
            <br><br><br>
            <h3>Cost: $80</h3>
        </div>
        <div class="box" onclick="purchase('Premium', 120)" id="box3">
            <h3>Premium Plan</h3>
            <br><br>
            Our Premium Option provides peak user personalization and a guaranteed fun time! You will get information about flights, hotels, locations, and even 
            all the best food! 
            Finally, with additional access to special filters for things like dietary restrictions, we will have your perfect vacation right at your finger tips.
            <br><br><br>
            <h3>Cost: $120</h3>
        </div>
    </div>
    <div id="payBox" class="payBox" style="display:none">
        <div class="row">
            <div class="col-75">
              <div class="container">
                <form action = "tripForm.php" onSubmit="return validate()" method="POST">
                   <br><h3>Payment Details</h3> <br>

                    Order Summary: 
                    <p id="packageType">Package:</p>
                    <p id="total">Total: $</p><br>
                    <label>First Name* </label><input type='text' name='first' id="fname"/>
                    <label>Last Name* </label><input type='text' name='last' id="lname"/><br/>
                    <label>Email* </label><input type='text' name='email' id="email"/>
                    <label>Phone Number </label><input type='text' name='phone' id="phone" /><br/>
          
                    <div class="col-50">
                      <label for="fname">Accepted Cards</label>
                      <div class="icon-container">
                        <input type="radio" id="visa" name="cardType" value="Visa">
                            <label for="visa">Visa</label>
                            <input type="radio" id="discover" name="cardType" value="discover">
                            <label for="discover">Discover</label>
                            <input type="radio" id="mastercard" name="cardType" value="mastercard">
                            <label for="mastercard">MasterCard</label>
                            <input type="radio" id="AE" name="cardType" value="AE">
                            <label for="AE">AmEx</label>
                      </div>
                      <label for="cname">Name On Card</label>
                      <input type="text" id="cname" name="cardname" >
                      <label for="ccnum">Credit Card Number *</label>
                      <input type="text" name='cnum' id="cnum" ><br>
                      <label for="expmonth">Exp. Month</label>
                      <input type="text" id="expmonth" name="expmonth" >
                          <label for="expyear">Exp. Year</label>
                          <input type="text" id="expyear" name="expyear" ><br>
                          <label for="cvv">CVV</label>
                          <input type="text" id="cvv" name="cvv" >
                          <input type="hidden" id="package" name="package" value="">
                      </div>
                    </div>
                  </div>

                  <div class="btns">
                  <input type="submit" value="Checkout" class="button">
                  <input value="Back" class="button" onclick="back()">
                  <div id="error">&nbsp;</div>
                  </div>
                </form>
              </div>
            </div>
            </div>
          </div>
          <br>
    </div> 
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