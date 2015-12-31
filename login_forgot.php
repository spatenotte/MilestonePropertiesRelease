<html lang="en">
<?php require 'navbar.php'; ?>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet">
        <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
        <link href='http://fonts.googleapis.com/css?family=Crimson+Text' rel='stylesheet' type='text/css'>
        <title>Account Recovery</title>
        <style>
            .breadcrumb{
                background: none;
                text-align: left;
            }
            .navbar-brand{
                font-family: 'Crimson Text', serif;
            }
            body{padding-top:0%;}
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
            
            h4 { text-align: center;}
        </style>
    </head>
    <body>
        <?php
            static $emptyFields;
            static $emailNotValid;
            static $emailNotRegistered;
            
            if($_SERVER["REQUEST_METHOD"] == "POST") {
                check_login_forgot();
            }
            else {
                $emptyFields = false;
                $emailNotValid = false;
                $emailNotRegistered = false;
            }
        ?>

        <div class="container top-container transbox">
            <div class="container text-center">
                <h1>Account Recovery</h1>
            </div>
            <div class="row">
                <div class="col-sm-8 col-sm-offset-2">
                    For demonstration purposes, the password recovery functionality will have no real security. Please enter the email you have registered at Milestones Property.
                    Your password will be reset, and further instructions will be sent to the email address you have entered.
                </div>
            </div>
            <form method="post" enctype="multipart/form-data" role="form">
                <div class="form-group">
                    <div class="input-group input-group-sm col-sm-offset-4 col-sm-4">
                        <label for="InputEmail">Email</label>
                        <span class="error"><?php
                        if($GLOBALS['emailNotValid']) {echo "Email not valid";}
                        else if($GLOBALS['emailNotRegistered']) {echo "Email has not been registered";}
                        ?></span>
                        <input type="email" class="form-control" name="InputEmail" placeholder="Enter Email" value="<?php echo isset($_POST['InputEmail']) ? $_POST['InputEmail'] : '' ?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group input-group-sm col-sm-offset-4 col-sm-4">
                        <button type="submit" class="btn btn-default">Submit</button>
                    </div>
                </div>
            </form>
        </div> 
        <br><br><br><br><br>
        
        <div class="footer" style="background-color: #e7e7e7; border-color: #777; width: 100%; position: fixed;bottom: 0">
            <h4>This is for demonstration purposes only. CSC648/848 San Francisco State University Team02 Milestone Properties</h4>
        </div>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    </body>
</html>

<?php   
    /*
     * @var string $original_email what the user entered
     * @var string $clean_email user email with input sanitized
     * @var mysqli_result $connection connection to msql database
     * @var string $query query to mysql database
     * @var array $row result from mysql database, contains information regarding a user
     * @var boolean $fail is true if user input is incorrect in any way
     */
    //checks if email is correct, if it is, begins password recovery
    function check_login_forgot() {
        $original_email = trim($_POST["InputEmail"]);
        $clean_email = filter_var($original_email, FILTER_SANITIZE_EMAIL);
        
        $fail = false;

        // if email has special characters or doesn't have right format, exit
        if ($original_email != $clean_email || !filter_var($original_email,FILTER_VALIDATE_EMAIL)) {
            $GLOBALS['emailNotValid'] = true;
            $fail = true;
        }
        
        // if email is not already registered, exit
        $connection = connect_to_mysql();
        $query = "SELECT * FROM users WHERE email = '" . $original_email . "'";
        $row = mysqli_query($connection, $query);
                
        if(mysqli_num_rows($row) != 1) {
            $GLOBALS['emailNotRegistered'] = true;
            $fail = true;
        }
        
        if(!$fail) {
            start_password_recovery($connection, $clean_email);
        }
        
        close_mysql_connection($connection);
    }
    
    /*
     * @param mysqli_result $connection connection to msql database
     * @param string $clean_email sanitized email
     */
    //checks if email is correct, if it is, begins password recovery
    function start_password_recovery($connection, $clean_email) {
        switch (recover_password($connection, $clean_email)) {
            case 1:
                //echo "Success! Password has been reset, email has been sent!";
                break;
            case -1:
                //echo "Error in sending email, but password has been reset";
                break;
            case -2:
                //echo "Error in changing the password";
                break;
            default:
                echo "Something is seriously broken";
        }
    }
    
?>