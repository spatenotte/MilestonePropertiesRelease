<html lang="en">
<?php require 'navbar.php'; ?>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet">
        <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
        <link href='http://fonts.googleapis.com/css?family=Crimson+Text' rel='stylesheet' type='text/css'>
        <title>Sign Up</title>
        <style>
            .breadcrumb{
                background: none;
                text-align: left;
            }
            .navbar-brand{
            font-family: 'Crimson Text', serif;
            }
            body{padding-bottom:8%;}
            .top-container{
                margin-top: 80px;
/*                background-color:#e5e5e5;*/
                border-radius: 10px; 
            }
            .transbox{
                background:rgba(0, 0, 0, .07);
                border-radius: 10px; 
                box-shadow: 1px 7px 36px -5px;
            }
            .error {color: #FF0000;}
        </style>
    </head>
    <body>
        <?php run_scripts_body();
        
        static $emailNotValid;
        static $passwordNotValid;
        static $passwordNotMatch;
        static $firstNameNotValid;
        static $lastNameNotValid;
        static $phoneNumberNotValid;
        static $zipCodeNotValid;
        static $emailRegistered;
        
        if($_SERVER["REQUEST_METHOD"] == "POST") {
                check_signup();
        }
            
        else {
            $emailNotValid          = false;
            $passwordNotValid       = false;
            $passwordNotMatch       = false;
            $firstNameNotValid      = false;
            $lastNameNotValid       = false;
            $phoneNumberNotValid    = false;
            $zipCodeNotValid        = false;
            $emailRegistered        = false;
        }
        
        ?>
        
        <div class="container top-container transbox">
            <div class="container text-center">
                <h1>Account Creation</h1>
            </div>
            <form method="post" enctype="multipart/form-data" role="form">
                <!User Login Information>
                <div class="form-group">
                    <div class="input-group input-group-sm col-sm-offset-4 col-sm-4">
                        <label for="InputEmail">Email</label>
                        <span class="error"><?php
                        if($GLOBALS['emailNotValid']) {echo "Email not valid";}
                        else if($GLOBALS['emailRegistered']) {echo "Email already registered";}
                        ?></span>
                        <input type="email" class="form-control" name="InputEmail" placeholder="Enter Email" value="<?php echo isset($_POST['InputEmail']) ? $_POST['InputEmail'] : '' ?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group input-group-sm col-sm-offset-4 col-sm-4">
                        <label for="InputPW1">New Password</label>
                        <span class="error"><?php
                        if($GLOBALS['passwordNotValid']) {echo "Password is not valid (only letters and numbers allowed)";}
                        ?></span>
                        <input type="password" class="form-control" name="InputPW1" placeholder="Create Password" value="<?php echo isset($_POST['InputPW1']) ? $_POST['InputPW1'] : '' ?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group input-group-sm col-sm-offset-4 col-sm-4">
                        <label for="InputPW2">Re-Enter New Password</label>
                        <span class="error"><?php
                        if($GLOBALS['passwordNotMatch']) {echo "Passwords do not match";}
                        ?></span>
                        <input type="password" class="form-control" name="InputPW2" placeholder="Re-Enter Password" value="<?php echo isset($_POST['InputPW2']) ? $_POST['InputPW2'] : '' ?>">
                    </div>
                </div>
                
                <!Contact Information>
                <div class="container text-center"><h4>Contact Information</h4></div>
                <div class="form-group">
                    <div class="input-group input-group-sm col-sm-offset-4 col-sm-4">
                        <label for="InputFirstName">First Name</label>
                        <span class="error"><?php
                        if($GLOBALS['firstNameNotValid']) {echo "First name not valid (only letters allowed)";}
                        ?></span>
                        <input type="firstname" class="form-control" name="InputFirstName" placeholder="First Name" value="<?php echo isset($_POST['InputFirstName']) ? $_POST['InputFirstName'] : '' ?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group input-group-sm col-sm-offset-4 col-sm-4">
                        <label for="InputLastName">Last Name</label>
                        <span class="error"><?php
                        if($GLOBALS['lastNameNotValid']) {echo "Last name not valid (only letters allowed)";}
                        ?></span>
                        <input type="lastname" class="form-control" name="InputLastName" placeholder="Last Name" value="<?php echo isset($_POST['InputLastName']) ? $_POST['InputLastName'] : '' ?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group input-group-sm col-sm-offset-4 col-sm-4">
                        <label for="InputPhone">Phone #</label>
                        <span class="error"><?php
                        if($GLOBALS['phoneNumberNotValid']) {echo "Phone number not valid";}
                        ?></span>
                        <input type="phone" class="form-control" name="InputPhone" placeholder="###-###-####" value="<?php echo isset($_POST['InputPhone']) ? $_POST['InputPhone'] : '' ?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group input-group-sm col-sm-offset-4 col-sm-4">
                        <label for="InputZip">Zip Code</label>
                        <span class="error"><?php
                        if($GLOBALS['zipCodeNotValid']) {echo "Zip code not valid (5 digits)";}
                        ?></span>
                        <input type="zip" class="form-control" name="InputZip" placeholder="#####" value="<?php echo isset($_POST['InputZip']) ? $_POST['InputZip'] : '' ?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group input-group-sm col-sm-offset-4 col-sm-4">
                        <button type="submit" class="btn btn-default">Submit</button>
                    </div>
                </div>
            </form>
            <div class="input-group input-group-sm col-sm-offset-4 col-sm-4">
                <a href="login.php">Already a User?</a>
            </div> <br>
        </div> 
    </body>
</html>


<?php
    /*
    */
    //checks if signup information is correct, and that the user doesn't already exist
    function check_signup() {
        $original_email = trim($_POST["InputEmail"]);
        $clean_email = filter_var($original_email, FILTER_SANITIZE_EMAIL);
        
        $fail = false;

        // if email has special characters or doesn't have right format, exit
        if ($original_email != $clean_email || !filter_var($original_email,FILTER_VALIDATE_EMAIL)) {
            $GLOBALS['emailNotValid'] = true;
            $fail = true;
        }

        // if password contains special characters, exit
        if(!filter_var($_POST["InputPW1"], FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z0-9_]*$/")))) {
            $GLOBALS['passwordNotValid'] = true;
            $fail = true;;
        }

        //if passwords do not match, exit
        if($_POST["InputPW1"] != $_POST["InputPW2"]) {
            $GLOBALS['passwordNotMatch'] = true;
            $fail = true;;
        }

        // if first name contains any non-letter characters, exit
        if(!filter_var($_POST["InputFirstName"], FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z]*$/")))) {
            $GLOBALS['firstNameNotValid'] = true;
            $fail = true;;
        }

        // if last name contains any non-letter characters, exit
        if(!filter_var($_POST["InputLastName"], FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z]*$/")))) {
            $GLOBALS['lastNameNotValid'] = true;
            $fail = true;;
        }
        
        // if last name contains any non-letter characters, exit
        if(!filter_var($_POST["InputPhone"], FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[0-9-]*$/")))) {
            $GLOBALS['phoneNumberNotValid'] = true;
            $fail = true;;
        }
        
        // if last name contains any non-letter characters, exit
        if(!filter_var($_POST["InputZip"], FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[0-9]{5}$/")))) {
            $GLOBALS['zipCodeNotValid'] = true;
            $fail = true;;
        }

        // if email is already registered, exit
        $connection = connect_to_mysql();
        $query = "SELECT * FROM users WHERE email = '" . $original_email . "'";
        $row = mysqli_query($connection, $query);
        
        echo "Num rows: " . mysqli_num_rows($row);
        
        if(mysqli_num_rows($row) != 0) {
            $GLOBALS['emailRegistered'] = true;
            $fail = true;
        }
        
        close_mysql_connection($connection);

        if(!$fail) {
            create_user();
        }
    }
    
    /*
     * @var string $password the password, hashed with default php algorithm
     */
    // creates the user in the DB, with the already verified and sanitized information
    function create_user() {
        // hashes the password to store it safely in the DB
        $password = password_hash($_POST["InputPW1"], PASSWORD_DEFAULT);

        $connection = connect_to_mysql();

        // query to create a new user in the DB
        $query = "INSERT INTO users (email,password,user_type,zip_code,phone_number,first_name,last_name)";
        $query .="VALUES(";
        $query .="'{$_POST["InputEmail"]}',";
        $query .= "'{$password}',";
        $query .= "1,";
        $query .= "{$_POST["InputZip"]},";
        $query .= "'{$_POST["InputPhone"]}',";
        $query .= "'{$_POST["InputFirstName"]}',";
        $query .= "'{$_POST["InputLastName"]}')";

        if(mysqli_query($connection, $query) == FALSE) {
            echo "Failed to create user";
        }

        close_mysql_connection($connection);
    }
?>