<html lang="en">
<?php require 'navbar.php'; ?>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
			h4 {text-align: center;}
        </style>
    </head>
    <body>
        <?php run_scripts_body();
            static $emptyFields;
            static $oldPasswordIncorrect;
            static $passwordNotValid;
            static $passwordNotMatch;
            
            if($_SERVER["REQUEST_METHOD"] == "POST") {
                check_change_password();
            }
            else {
                $emptyFields = false;
                $oldPasswordIncorrect = false;
                $passwordNotValid = false;
                $passwordNotMatch = false;
            }
        ?>

        <div class="container top-container transbox">
            <div class="container text-center">
                <h1>Change Password</h1>
            </div>
            <div class="row">
                <div class="col-sm-8 col-sm-offset-2">
                </div>
            </div>
            <form method="post" enctype="multipart/form-data" role="form">
                <div class="form-group">
                    <div class="input-group input-group-sm col-sm-offset-4 col-sm-4">
                        <label for="InputOldPW">Current Password</label>
                        <span class="error"><?php
                        if($GLOBALS['oldPasswordIncorrect']) {echo "Password is incorrect.";}
                        ?></span>
                        <input type="password" class="form-control" name="InputOldPW" placeholder="Create Password" value="<?php echo isset($_POST['InputOldPW']) ? $_POST['InputOldPW'] : '' ?>">
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
                <div class="form-group">
                    <div class="input-group input-group-sm col-sm-offset-4 col-sm-4">
                        <button type="submit" class="btn btn-default">Submit</button>
                    </div>
                </div>
            </form>
        </div> 
        
	<div class="footer" style="background-color: #e7e7e7; border-color: #777; width: 100%; position: fixed;bottom: 0">
		<h4>This is for demonstration purposes only. CSC648/848 San Francisco State University Team02 Milestone Properties</h4>
	</div>
		
    </body>
</html>

<?php
    /*
     * @var mysqli_result $connection connection to msql database
     * @var string $query query to mysql database
     * @var array $row result from mysql database, contains information regarding a user
     * @var boolean $fail is true if user input is incorrect in any way
     */
    //checks if email is correct, if it is, begins password recovery
    function check_change_password() {        
        $fail = false;
        
        //if old password is incorrect, exit
        $connection = connect_to_mysql();
        $query = "SELECT * FROM users WHERE email = '" . $_SESSION['email'] . "' AND password = '" . md5($_POST["InputOldPW"]) ."'";
        $row = mysqli_query($connection, $query);
                
        if(mysqli_num_rows($row) != 1) {
            $GLOBALS['oldPasswordIncorrect'] = true;
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
        
        if(!$fail) {
            start_password_change($connection);
        }
        
        close_mysql_connection($connection);
    }
    
    /*
     * @param mysqli_result $connection connection to msql database
     * 
     */
    //Changes a user's password in the database to a new password
    function start_password_change($connection) {
        if(change_password($connection, $_SESSION['email'], $_POST["InputOldPW"], $_POST["InputPW1"])) {
			echo "<script type='text/javascript'>alert('Successfully changed password!');</script>";
			header("Location: index.php");
		}
        else
			echo "<script type='text/javascript'>alert('Failed to change password!');</script>";
    }
    
?>