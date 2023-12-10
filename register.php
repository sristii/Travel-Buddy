<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";

 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter an email.";
    } elseif(!preg_match('/^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i', trim($_POST["username"]))){
        $username_err = "Please enter a valid email.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
    
    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);
            
            // Set parameters
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: login.php");
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link href="style.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=PT-Serif">
    <style>
        .wrapper{ 
          width: 40%; 
          padding: 20px; 
          position: absolute;
          top: 50%;
          left: 50%;
          transform: translate(-50%, -50%);
          color: white;
          text-align: center;
          text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
          z-index: 1;
        }

        .btn{
          display: inline-block;
          align-content: center;
          text-align: center;
          background-color: #79adc0;
          color: rgb(255, 255, 255);
          font-size: 22px;
          font-weight: 800;
          padding: 10px;
          border-radius: 20px;
          /* Adding rounded corners */
          border: none;
          cursor: pointer;
          transition: transform 0.3s, background-color 0.3s;
          /* Adding transition for smooth hover effect */
        }
        /* Hover effect */
        .btn:hover {
          background-color: #4e92a6;
          /* Change color on hover */
          transform: scale(1.1);
          /* Scale the button slightly on hover */
          color: white;
        }
    </style>
</head>
<body>
<header class="hero-section">
<?php
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

        </nav>';
?>
    <!-- Image spanning the entire page -->
    <img
      src="images/login-bg.jpg"
      alt="Hero Image">
    <div class="wrapper">
        <h2 style="font-size:3em">Sign Up</h2>
        <p style="font-size:18px;">Please fill this form to create an account.</p>
        <br>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label style="font-size:30px;">Email</label>
                <input style="padding:5px;" type="text" id="email" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                <span style="font-size:16px;" class="invalid-feedback"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group">
                <label style="font-size:30px";>Password</label>
                <input style="padding:5px;" type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                <span style="font-size:16px;" class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <label style="font-size:30px";>Confirm Password</label>
                <input style="padding:5px;"  type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>">
                <span style="font-size:16px;" class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <br>
                <input type="submit" class="btn" value="Submit">
            </div>
            <p style="font-size:30px;">Already have an account? <a href="login.php">Login here</a>.</p>
        </form>
    </div>    
</body>
</html>rgb(163, 86, 86)rgb(163, 85, 85)
