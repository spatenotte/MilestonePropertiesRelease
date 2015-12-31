<html lang="en">
<?php require 'navbar.php'; ?>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Edit user information</title>
        <style>
            body {
                padding-top: 50px; 
                padding-bottom: 90px;
                margin-bottom: 40px;
                height: 100%;
            }
                        .navbar-brand, .nav{
                font-family: 'Helvetica Neue', serif;
                font-weight: lighter;

            }
            .page-header{
                font-family: 'Helvetica Neue', serif;
                font-weight: lighter;
            }
            
			h1 {text-align: center;}
			.error {color: #FF0000;}
        </style>
    </head>
    <body>
		<?php
		
		if(!isset($_SESSION['id'])) {
			echo "<script> location.replace(\"index.php\"); </script>";
		}
		
		static $firstNameNotValid;
        static $lastNameNotValid;
        static $phoneNumberNotValid;
		
		$firstName;
		$lastName;
		$phone;
		get_user_info();
		
		if($_SERVER["REQUEST_METHOD"] == "POST") {
                check_fields();
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
        <div class="container">
			<h1 class="page-header"> Edit user information</h1>
			<form role="form" method="post">
				<div class="form-group">
						<div class="input-group input-group-sm col-sm-offset-4 col-sm-4">
							<label for="InputFirstName">First Name</label>
							<span class="error"><?php
							if($GLOBALS['firstNameNotValid']) {echo "First name not valid";}
							?></span>
							<input type="firstname" class="form-control" name="InputFirstName" placeholder="<?php if ($GLOBALS["firstName"] !="") echo $GLOBALS["firstName"]; else echo "Enter first name;"?>" value="<?php echo isset($_POST['InputFirstName']) ? $_POST['InputFirstName'] : '' ?>">
						</div>
				</div>
				<div class="form-group">
					<div class="input-group input-group-sm col-sm-offset-4 col-sm-4">
						<label for="InputLastName">Last Name</label>
						<span class="error"><?php
							if($GLOBALS['lastNameNotValid']) {echo "Last name is not valid";}
						?></span>
						<input type="lastname" class="form-control" name="InputLastName" placeholder="<?php if ($GLOBALS["lastName"] !='') echo $GLOBALS["lastName"]; else echo "Enter last name;"?>" value="<?php echo isset($_POST['InputLastName']) ? $_POST['InputLastName'] : '' ?>">
					</div>
				</div>
				<div class="form-group">
					<div class="input-group input-group-sm col-sm-offset-4 col-sm-4">
						<label for="InputPhone">Phone #</label>
						<span class="error"><?php
						if($GLOBALS['phoneNumberNotValid']) {echo "Phone number not valid";}
						?></span>
						<input type="phone" class="form-control" name="InputPhone" placeholder="<?php if ($GLOBALS["phone"] !='') echo $GLOBALS["phone"]; else echo "Enter phone number;"?>" value="<?php echo isset($_POST['InputPhone']) ? $_POST['InputPhone'] : '' ?>">
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
    */
    //checks if fields are correctly filled
    function check_fields() {
        
        $fail = false;
		$empty = true;
		
        // if first name contains any non-letter characters, exit
		if($_POST["InputFirstName"] != '') {
			if(!filter_var($_POST["InputFirstName"], FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z]*$/")))) {
				$GLOBALS['firstNameNotValid'] = true;
				$fail = true;
			}
			else {
				$empty = false;
			}
		}

        // if last name contains any non-letter characters, exit
		if($_POST["InputLastName"] != '') {
			if(!filter_var($_POST["InputLastName"], FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z]*$/")))) {
				$GLOBALS['lastNameNotValid'] = true;
				$fail = true;
			}
			else {
				$empty = false;
			}
		}
        
        // if phone number contains any non-digit or - characters, exit
		if($_POST["InputPhone"] != '') {
			if(!filter_var($_POST["InputPhone"], FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[0-9-]*$/")))) {
				$GLOBALS['phoneNumberNotValid'] = true;
				$fail = true;
			}
			else {
				$empty = false;
			}
		}
		
        if(!$fail && !$empty) {
            change_info();
        }
    }

	function change_info() {
		$change_first = false;
		$change_last = false;
		$change_phone = false;
		
		if($_POST["InputFirstName"] != '') {
			$change_first = true;
		}
		
		if($_POST["InputLastName"] != '') {
			$change_last = true;
		}
		
		if($_POST["InputPhone"] != '') {
			$change_phone = true;
		}
		
		$connection = connect_to_mysql();
		$query = "UPDATE users ";
		
		if($change_first) {
			$query .= "SET first_name='" . $_POST["InputFirstName"] . "'";
			if($change_last) {
				$query .= ", last_name='" . $_POST["InputLastName"] . "'";
			}
			if($change_phone) {
			$query .= ", phone_number='" . $_POST["InputPhone"] . "'";
			}
		}
		
		else if($change_last) {
			$query .= "SET last_name='" . $_POST["InputLastName"] . "'";
			if($change_phone) {
			$query .= ", phone_number='" . $_POST["InputPhone"] . "'";
			}
		}
		
		else {
			$query .= "SET phone_number='" . $_POST["InputPhone"] . "'";
		}
		
		$query .= "WHERE id='" . $_SESSION['id'] . "'";
		
		if(mysqli_query($connection, $query)) {
			echo "<script type='text/javascript'>alert('Successfully changed user information!');</script>";
			close_mysql_connection($connection);
			echo "<meta http-equiv=\"Location\" content=\"profile_user.php\">";
		}
		
		else {
			close_mysql_connection($connection);
		}
	}
	
	function get_user_info() {
		$connection = connect_to_mysql();
		$query = "SELECT * FROM users WHERE id=" . $_SESSION['id'];
		
		$result = mysqli_query($connection, $query);
		$row = mysqli_fetch_array($result);
		
		$GLOBALS["firstName"] = $row["first_name"];
		$GLOBALS["lastName"] = $row["last_name"];
		$GLOBALS["phone"] = $row["phone_number"];
	}
?>