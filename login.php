<html lang="en">
<?php require 'navbar.php'; ?>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login</title>
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
        </style>
    </head>
    <body>
        <?php run_scripts_body();
            static $emptyFields;
            static $wrongCredentials;
            static $emailNotValid;
            
            if($_SERVER["REQUEST_METHOD"] == "POST") {
                check_login();
            }
            else {
                $emptyFields = false;
                $emailNotValid = false;
                $wrongCredentials = false;
            }
        ?>
        
        <div class="container top-container transbox">
            <div class="container text-center">
                <h1>Login</h1>
            </div>
            <form role="form" method="post">
                <div class="form-group">
                    <div class="input-group input-group-sm col-sm-offset-4 col-sm-4">
                        <label for="InputEmail">Email</label>
                        <input type="email" class="form-control" name="InputEmail" placeholder="Enter Email" value="<?php echo isset($_POST['InputEmail']) ? $_POST['InputEmail'] : '' ?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group input-group-sm col-sm-offset-4 col-sm-4">
                        <label for="InputPW1">Password</label>
                        <input type="password" class="form-control" name="InputPW1" placeholder="Enter Password" value="<?php echo isset($_POST['InputPW1']) ? $_POST['InputPW1'] : '' ?>">
                    </div>
                </div>
                <div class="form-group">
                  <div class="input-group input-group-sm col-sm-offset-4 col-sm-4">
                    <div class="checkbox">
                      <label>
                        <input type="checkbox"> Remember me
                      </label>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="input-group input-group-sm col-sm-offset-4 col-sm-4">
                    <button type="submit" class="btn btn-default">Sign in</button>
                    <span class="error"> <?php echo display_errors() ?></span>
                  </div>
                </div>
              </form>
            <div class="input-group input-group-sm col-sm-offset-4 col-sm-4">
                <a href="login_forgot.php">Forgot Your Password?</a>
            </div> <br>
        </div> 
    </body>
</html>

<?php
    if(empty($_POST)) {
        $emptyFields=false;
        $wrongCredentials = false;
    }

    /*
     * @var string $email email of the user, with input sanitized
     * @var string $password password of the user, with input sanitized
     */
    //checks if login information is correct, if it is, redirect to the user's profile page
    function check_login() {

        $email = filter_var($_POST["InputEmail"], FILTER_SANITIZE_EMAIL);

        $connection = connect_to_mysql();
        $result = mysqli_query($connection, "SELECT * FROM users WHERE email = '" . $email . "'");
        $row = mysqli_fetch_array($result);

        if ($_POST["InputEmail"] == "" || $_POST["InputPW1"] == "") {
            $GLOBALS['emptyFields'] = true;
        } 
        
        else if($_POST["InputEmail"] != $email) {
            $GLOBALS['emailNotValid'] = true;
        }
        
        else if (!password_verify($_POST["InputPW1"], $row["password"])) {
            $GLOBALS['wrongCredentials'] = true;
        } 
        
        else {
            sec_session_start($email);
            header("Location: temp.php");
            exit();
        }
    }

    function display_errors() {
        if($GLOBALS['emptyFields']) {
            echo "Fields cannot be empty";
        }
        
        else if($GLOBALS['emailNotValid']) {
            echo "Email is not valid";
        }

        else if($GLOBALS['wrongCredentials']) {
            echo "Wrong email/password combination";
        }
    }
    
    /*
    * @param string $email email of the user currently logged in
    */
    // starts a cookie session to remember logged in user
    function sec_session_start($email) {
        session_destroy();
        $session_name = 'milestoneProperties';   // Set a custom session name
        $secure = 'SECURE';
        // This stops JavaScript being able to access the session id.
        $httponly = true;
        // Gets current cookies params.
        $cookieParams = session_get_cookie_params();
        session_set_cookie_params($cookieParams["lifetime"], $cookieParams["path"], $cookieParams["domain"], $secure, $httponly);
        // Sets the session name to the one set above.
        session_name($session_name);
        session_start();            // Start the PHP session
        $_SESSION['email'] = $email;
        $_SESSION['loggedIn'] = true;
        session_write_close();
    }
?>