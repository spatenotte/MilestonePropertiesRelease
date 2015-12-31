<?php
/*
 * PHP version 5
 * @author f14g02
 * @version 1.0
 * @package Milestone_Properties
 * define all global variables to be used in connecting to mysql
 * @global string $GLOBALS['DB_Server'] address of sfsuswe server for connecting to sql datatbase
 * @name DB_Server
 * @global string $GLOBALS['DB_login'] login name for connecting to sql datatbase
 * @name DB_login
 * @global string $GLOBALS['DB_password'] login string password name for connecting to sql datatbase
 * @name DB_password
 * @global string $GLOBALS['DB_name']  team name for connecting to sql datatbase
 * @name  DB_name
 * @global counter integer counter for login
 */

// removed credentials for GitHub
define("DB_Server", "");
define("DB_login", "");
define("DB_password", "");
define("DB_name", "");
$counter = 0;

/* @global DB_Server string address of sfsuswe server for connecting to sql datatbase
 * @global DB_login string login name for connecting to sql datatbase
 * @global DB_password login string password name for connecting to sql datatbase
 * @global DB_name string team name for connecting to sql database
 * @return mysqli_result $connection returns connection got mysql database or false
 */
//function to initiate the connection to the mysql database, and choose the particular db
function connect_to_mysql() {
    $connection = mysqli_connect(DB_Server, DB_login, DB_password, DB_name);
    if (!$connection) {
        die("Database connection failed: " . mysqli_connect_errno() .
                "(" . mysqli_connect_error() . ")");
    }
    mysqli_set_charset($connection, 'utf-8');
    return $connection;
}
/*
 * @param mysqli_result $connection connection to msql database
 * @global array $_POST array with user search request
 * @var string nameErr error message
 * @return mysqli_result $result
 * @var string $query query to mysql database
 */
//fucnction to search database for listings
//function is inefficient as-is, implement query by selecting relevant columns
function milestone_search($connection) {
    $user_search = filter_input(INPUT_POST, "usersearch", FILTER_SANITIZE_STRING);
    if (!$user_search) {
        $nameErr = "Name is required";//redundant, fix it
        return $result = "";
    } else {
        $query = "SELECT * ";
        $query .="FROM listings ";
        $query .="WHERE city =";
        $query .= "'$user_search'";
        $query .= " OR us_state =";
        $query .= "'$user_search'";
        $query .= " OR zip_code =";
        $query .= "'$user_search'";
        $query .= " OR address =";
        $query .= "'$user_search'";
        return $result = mysqli_query($connection, $query);
    }
}

function get_search_back($connection){
        $user_search = filter_input(INPUT_POST, "bookmark", FILTER_SANITIZE_STRING);
    if (!$user_search) {
        $nameErr = "Name is required";//redundant, fix it
        return $result = "";
    } else {
        $query = "SELECT * ";
        $query .="FROM listings ";
        $query .="WHERE id =";
        $query .= "'$user_search'";
        return $result = mysqli_query($connection, $query);
    }
}

/*
 * @param mysqli_result $connection connection to msql database
 * @global array $_POST array with user search request and filter arguments
 * @var string nameErr error message
 * @return mysqli_result $result
 * @var string $query query to mysql database
 */
//searches the database for listings with filters
function milestone_search_with_filters($connection) {
    $user_search = filter_input(INPUT_POST, "usersearch", FILTER_SANITIZE_STRING);
    if (!$user_search) {
        $nameErr = "Name is required";
        return $result = "";
    } else {
        $query = "SELECT * ";
        $query .="FROM listings ";
        $query .="WHERE (city = ";
        $query .= "'$user_search'";
        $query .= " OR us_state = ";
        $query .= "'$user_search'";
        $query .= " OR zip_code = ";
        $query .= "'$user_search' )";
        $bed = filter_input(INPUT_POST, "min_bedroom", FILTER_VALIDATE_INT);
        if ($bed) {
            $query .= " AND num_bedrooms >=";
            $query .= " '$bed' ";
        }
        $walk = filter_input(INPUT_POST, "min_walkscore", FILTER_VALIDATE_INT);
        if ($walk) {
            $query .= " AND walk_score >=";
            $query .= " '$walk' ";
        }
//        $bath = filter_input(INPUT_POST, "min_bathroom", FILTER_VALIDATE_INT);
//        if ($bath) {
//            $query .= " AND num_bathrooms >=";
//            $query .= " '$bath' ";
//        }
//        $ft = filter_input(INPUT_POST, "min_sq_ft", FILTER_VALIDATE_INT);
//        if ($ft) {
//            $query .= " AND sq_ft >=";
//            $query .= " '$ft' "; //form must be converted to int,
//        }
        $miprice = filter_input(INPUT_POST, "minprice", FILTER_VALIDATE_INT);
        if ($miprice) {
            $query .= " AND price >=";
            $query .= " '$miprice' ";
        }
        $maprice = filter_input(INPUT_POST, "maxprice", FILTER_VALIDATE_INT);
        if ($maprice) {
            $query .= " AND price <=";
            $query .= " '$maprice' ";
        }
        return $result = mysqli_query($connection, $query);
    }
}

function get_realtor_listings($connection) {
    if(!isset($_SESSION['id'])) {
        $nameErr = "Realtor not logged in";
        return $result = "";
    } else {
        $query = "SELECT * ";
        $query .="FROM listings ";
        $query .="WHERE realtor = ";
        $query .= "'{$_SESSION['id']}'";
        //$query .= " '24' ";

        return $result = mysqli_query($connection, $query);
    }
}
/*
 * @param mysqli_result $connection connection to msql database
 * @global array $_POST array with user search request
 * @var string nameErr error message
 * @return mysqli_result $result
 * @var string $query query to mysql database
 */
//function to retrieve information from listing
function milestone_details($connection) {
        $query = "SELECT * ";
        $query .="FROM listings ";
        $query .="WHERE id =";
        $query .= "'{$_GET["details"]}'";
        return $result = mysqli_query($connection, $query);
}
/*
 * @param mysql_result $connection
 */
//closes connection my mysql datbase
function close_mysql_connection($connection) {
    mysqli_close($connection);
}
/*
 * @param string $address0 address
 * @var string $address1 reformated address
 * @var string $json json formatted data
 * @var string $json1 reformated json data
 * @var float $lat lattitude of address
 * @var float $long longitude of address
 * @return array $return latitude and longitude values
 */
//finds and returns the lattitude and longitude of an address
function get_lat_long($address0) {
    $address1 = str_replace(" ", "+", $address0);
    $json = file_get_contents("http://maps.google.com/maps/api/geocode/json?address=$address1&sensor=false");
    $json1 = json_decode($json);

    $lat = $json1->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
    $long = $json1->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};
    $return = array(
        'lat' => $lat,
        'long' => $long,
    );
    return $return;
}
/*
 * @param string $address1
 * @var array $l_temp latitude and longtude values
 * @var WalkScrore $w new WalkScore object
 * @var array $w_options array of address information formatted for WalkScore function
 * @return int $score WalkScore value
 */
//function takes in address and finds and returns WalkScore value
function get_walkscore($address) {
    require_once("WalkScore.php");
    $l_temp = get_lat_long($address);
    $w = new WalkScore('dbd8b3f251a2ea4b4a6be60beae80642');
    $w_options = array(
        'address' => $address,
        'lat' => $l_temp['lat'],
        'lon' => $l_temp['long'],
    );
    $score = $w->WalkScore($w_options)->walkscore;
    return $score;
}
/*
 * @param mysql_result $connection connection to mysql database
 * @var string description description of listing
 * @var string $address address listing is located at
 * @var int $zip_code zip code listing is located in
 * @var string $us_state state listing is located in
 * @var int $price price of listing
 * @var int $sq_ft number of square feet in listing
 * @var int $num_bedrooms number of bedrooms in listing
 * @var int $num_bathrooms number of bathrooms in listing
 * @var string $target_dir name of image to upload
 * @var string $w_address address of listing
 * @var int $walkscore WalkScore for listing
 * @var bool $uploadOK
 * @var string $image1 address image1 is stored at
 * @var string query value to insert into sql database
 * @ global array $_POST
 */
//Takes in user input and creates listing
function input_listing($connection) {
    //$connection = connect_to_mysql(); $maprice = filter_input(INPUT_POST, "maxprice", FILTER_VALIDATE_INT);
    $description = filter_input(INPUT_POST,"description", FILTER_SANITIZE_STRING);
    $address = filter_input(INPUT_POST, "address", FILTER_SANITIZE_STRING);
    $zip_code = filter_input(INPUT_POST, "zipcode", FILTER_VALIDATE_INT);
    $city = filter_input(INPUT_POST, "city", FILTER_SANITIZE_STRING);
    $us_state = filter_input(INPUT_POST, "us_state", FILTER_SANITIZE_STRING);
    $price = filter_input(INPUT_POST, "price", FILTER_VALIDATE_INT);
    $sq_ft = filter_input(INPUT_POST, "sq_ft", FILTER_VALIDATE_INT);
    $num_bedrooms = filter_input(INPUT_POST, "num_bedrooms", FILTER_VALIDATE_INT);
    $num_bathrooms = filter_input(INPUT_POST, "num_bathrooms", FILTER_VALIDATE_INT);
    $num_garages = filter_input(INPUT_POST, "num_garages", FILTER_VALIDATE_INT);
    $target_id_query = "Select id from listings Where id<(select max(Id) from listings)
		order by id desc limit 1";
	$result = mysqli_query($connection, $target_id_query);
	$row = mysqli_fetch_array($result);
        echo $row[0];

    //$target_dir = $target_dir . basename(($_FILES["uploadFile"]["name"]));
    $w_address = $address . ", " . $city . ", " . $us_state;
    $walkscore = get_walkscore($w_address);
    $uploadOk = 1;

    $i = 1;
    while ($i <  (count($_FILES)+1) ){
    $target_dir = "./assets/home_images/home" . (((int)$row[0])+2) . "/small/home" . (((int)$row[0])+2) . "_" . $i . ".jpg";
    if (move_uploaded_file($_FILES["image" . $i]["tmp_name"], $target_dir)) {
       ${'image' . $i} = "home" . (((int)$row[0])+2) . "_" . $i . ".jpg";
        echo "The file " . basename($_FILES["image" . $i]["name"]) . " has been uploaded.\n";
    } else {
        echo "Sorry, there was an error uploading your file.";
        $i++;
    }
    $i++;
    }
    $query = "INSERT INTO listings (description, address, zip_code, city, us_state, price, sq_ft, num_bedrooms, num_bathrooms, num_garages, image1, image2, image3, walk_score)";
    $query .= "VALUES('$description', '$address', '$zip_code', '$city', '$us_state', '$price', '$sq_ft', '$num_bedrooms', '$num_bathrooms', '$num_garages', '$image1', '$image2', '$image3', '$walkscore')";

    if (!mysqli_query($connection, $query)) {
        die('Error: ' . mysqli_error($connection));
    }
    echo "1 record added";

    close_mysql_connection($connection);
}

/*
 * @param int $result number of results
 */
//displays number of results
function number_of_listings($result) {
    if ($result == "") {
        echo 0;
    } else {
        echo mysqli_num_rows($result);
    }
}
//runs ajax and bootstrap scripts for body
function run_scripts_body() {
    echo '
            <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
            <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
        ';
}
//runs bootstrap scripts for head
function run_scripts_head() {
    echo '
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet">
            <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
            <link href="http://fonts.googleapis.com/css?family=Crimson+Text" rel="stylesheet" type="text/css">
        ';
}
/*
 * @param mysql_result $connection connection to database
 * @param int $num = number of results desired
 * @var string $query input for sql database
 * @return mysql_result $result featured listing from database
 */
//finds and returns a given number of featured properties from database
function featured_properties($connection, $num) {
    $query = "SELECT * ";
    $query .="FROM listings ";
    $query .="ORDER BY clicked_on DESC ";
    $query .="LIMIT {$num}";
    return $result = mysqli_query($connection, $query);
}

/*
 * @param mysql_result $connection connection to database
 * @param int $listing_id the id of the listing as stored in the database
 * @var string $query input for sql database
 * @return mysql_result $result featured listing from database
 */
//increments a listing's hits counter
function visited_listing($connection, $listing_id) {
    $query = "UPDATE listings ";
    $query .="SET clicked_on = clicked_on + 1 ";
    $query .="WHERE id = ";
    $query .= "{$listing_id} ";

    if (mysqli_query($connection, $query)) {
        return true;
    } else {
        return false;
    }
}

/*
 * @param mysqli_result $connection connection to msql database
 * @param string $user_email
 * @param string oldPw old password to be changed
 * @param string newPw new and updated password
 * @var array $caller debug_backtrace(), used to get calling method
 * @var string $query query to mysql database
 * @return boolean :true if password is successfully changed, false on fail
 */
//Changes a user's password in the database to a new password
function change_password($connection, $user_email, $oldPw, $newPw) {
    //if the calling function is recover_password(), then the oldPw is already hashed, no need to rehash it
    $caller = debug_backtrace();
    if($caller[1]['function'] != 'recover_password') {
        $oldPw = md5($oldPw);
    }

    $query = "SELECT email , password ";
    $query .="FROM users ";
    $query .="WHERE email = ";
    $query .= "'{$user_email}' ";
    $query .="AND password = ";
    $query .= "'{$oldPw}'";

    $result = mysqli_query($connection, $query);

    //either email or password is incorrect, failed to change password
    if (mysqli_num_rows($result) == 0) {
        //echo "change_password():Account does not exist";
        return false;
    } else { //attempting to change password
        $newPw = md5($newPw);

        $query = "UPDATE users ";
        $query .="SET password = ";
        $query .= "'{$newPw}' ";
        $query .="WHERE email = ";
        $query .= "'{$user_email}' ";
        $query .="AND password = ";
        $query .= "'{$oldPw}'";

        if (mysqli_query($connection, $query)) {
            //echo "change_password():success";
            return true;
        } else {
            //echo "change_password():update query fail";
            return false;
        }
    }
}

/*
 * @param mysqli_result $connection connection to msql database
 * @param string $user_email
 * @var string $query query to mysql database
 * @var string $newPw new randomly generated password with a length 8 characters
 * @var string $message messsage to send in the email
 * @return boolean :true if password is successfully changed and email is sent, false on fail
 */
//Changes a user's password in the database to a new randomized password, sends an email with the new password to the corresponding email address
function recover_password($connection, $user_email) {
    //must get old password in order to change password
    $query = "SELECT password , first_name, last_name ";
    $query .="FROM users ";
    $query .="WHERE email = ";
    $query .= "'{$user_email}'";
    $result = mysqli_query($connection, $query);
    $row = mysqli_fetch_array($result);

    //generating a new random password
    $newPw = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 8);

    if (change_password($connection, $user_email, $row["password"], $newPw)) {
        //send email with new password
        $message = "Hello {$row["first_name"]} {$row["last_name"]},\n\n"
                . "You have requested a password recovery for your account at "
                . "Milestones Property. If you did not request password recovery"
                . ", please contact us at our contact page.\n\n"
                . "Your new password is: {$newPw}\n\n"
                . "For your security, please change this password immediately.\n\n"
                . "Find your dream home today\n"
                . "-Milestone Properties\n\n"
                . "This is for demonstration purposes only. CSC648/848 San "
                . "Francisco State University Team02 Milestone Properties©";
        $message = wordwrap($message, 70);

        if(mail($user_email, "Milestone Properties Password Recovery", $message)) {
            //echo "recover_password():Email has been sent";
            return 1;
        } else {
            //echo "recover_password():Error in sending email";
            return -1;
        }
    } else {
        //echo "recover_password():change_password failed";
        return -2;
    }
}

/*
 * @param mysql_result $result listing results to display
 * @var string $img_name name of image file to be displayed
 * @var string $img_path path of image to be displayed
 * @var array $row
 */
//funtion displays public information about listing results passed in to it
function display_formatted_results($result) {

    if ($result != "") {

        while ($row = mysqli_fetch_array($result)) {
             echo '<div class="row">
                    <div class="col-sm-6">
                        <div class="brdr bgc-fff pad-10 box-shad btm-mrg-20 property-listing" style="overflow:hidden;">
                            <div class="media">
                                <a class="pull-left" href="#" target="_parent">';

                                    $rand_num = rand(1, 3);
                                    $img_name1 = $row["image" . $rand_num];
                                    $img_path = 'assets/home_images/home' . $row["id"] . '/small/' . $img_name1;

                                    echo '<img class="img-responsive" style="margin-top:9%;" src="' .$img_path . '"/></a>

                                <div class="clearfix visible-sm"></div>

                                <div class="media-body fnt-smaller">
                                    <a href="#" target="_parent"></a>

                                    <h3 class="media-heading">
                                        <a href="#" target="_parent">$' . number_format($row["price"]) . '</a><small class="pull-right"><i>' . $row["address"] . '</i></small></h3>
                                    <p><small class="pull-right">' . $row["city"] . ", " . $row["us_state"] . ", " . $row["zip_code"] . '</small></p>

                                    <br>
                                    <ul class="list-inline mrg-0 btm-mrg-10 clr-535353 pull-right">
                                        <li>' . $row["sq_ft"] . 'SqFt</li>

                                        <li style="list-style: none">|</li>

                                        <li>' . $row["num_bedrooms"] . 'Beds</li>

                                        <li style="list-style: none">|</li>

                                        <li>' . $row["num_bathrooms"] . 'Baths</li>
                                    </ul>
                                    <br><br>
                                    <p class="hidden-xs">' . substr($row["description"], 0, 120) . '...</p>
                                    <div class="btn-toolbar pull-right">
                                       <form action="contact_realtor.php" method="post">
                                            <button name="idListing" type="submit" value="' . $row["id"] . ' " class="btn btn-default btn-sm">
                                                <span class="glyphicon glyphicon-envelope" aria-hidden="true"></span> Contact realtor
                                            </button>
										</form>
										</div>
										<div class="col-md-4">
											<form action="home_details.php" method="get">
                                            <button name="details" type="submit" value="' . $row[0] . '" class="btn btn-success btn-sm">
												<span class="glyphicon glyphicon-star" aria-hidden="true"></span> Details</button>
                                        </form>

                                    </div>
                                    <br>
                                    <span class="fnt-smaller fnt-lighter fnt-arial">Milestone Properties&copy</span>
                                </div>
                            </div>
                        </div>


                    </div>
                    <div class="col-sm-6">';

                        if ($row = mysqli_fetch_array($result)){

                        echo '<div class="brdr bgc-fff pad-10 box-shad btm-mrg-20 property-listing" style="overflow:hidden;">
                            <div class="media">
                                <a class="pull-left" href="#" target="_parent">';

                                    $rand_num = rand(1, 3);
                                    $img_name1 = $row["image" . $rand_num];
                                    $img_path = 'assets/home_images/home' . $row["id"] . '/small/' . $img_name1;

                                    echo '<img class="img-responsive" style="margin-top:9%;" src="' .$img_path . '"/></a>

                                <div class="clearfix visible-sm"></div>

                                <div class="media-body fnt-smaller">
                                    <a href="#" target="_parent"></a>

                                    <h3 class="media-heading">
                                        <a href="#" target="_parent">$' . number_format($row["price"]) . '</a><small class="pull-right"><i>' . $row["address"] . '</i></small></h3>
                                    <p><small class="pull-right">' . $row["city"] . ", " . $row["us_state"] . ", " . $row["zip_code"] . '</small></p>

                                    <br>
                                    <ul class="list-inline mrg-0 btm-mrg-10 clr-535353 pull-right">
                                        <li>' . $row["sq_ft"] . 'SqFt</li>

                                        <li style="list-style: none">|</li>

                                        <li>' . $row["num_bedrooms"] . 'Beds</li>

                                        <li style="list-style: none">|</li>

                                        <li>' . $row["num_bathrooms"] . 'Baths</li>
                                    </ul>
                                    <br><br>
                                    <p class="hidden-xs">' . substr($row["description"], 0, 120) . '...</p>
                                    <div class="btn-toolbar pull-right">
                                       <form action="contact_realtor.php" method="post">
                                            <button name="idListing" type="submit" value="' . $row["id"] . ' " class="btn btn-default btn-sm">
                                                <span class="glyphicon glyphicon-envelope" aria-hidden="true"></span> Contact realtor
                                            </button>
										</form>
										</div>
										<div class="col-md-4">
											<form action="home_details.php" method="get">
                                            <button name="details" type="submit" value="' . $row[0] . '" class="btn btn-success btn-sm">
												<span class="glyphicon glyphicon-star" aria-hidden="true"></span> Details</button>
                                        </form>

                                    </div>
                                    <br>
                                    <span class="fnt-smaller fnt-lighter fnt-arial">Milestone Properties&copy</span>
                                </div>
                            </div>

                    </div>
                </div>
                </div>';
        }
        }
        mysqli_free_result($result);
    } else {
        echo "<h1></h1>";
    }
}

/*
 * @param mysql_result $connection connection to mysql database
 * @var string email user's email
 * @var string $password user's password
 * @var string $first_name user's first name
 * @var string $last_name user's last name
 * @var string $query value to send to mysql database
 * @global array $_POST
 */
//Takes in user input and adds new user to database
function input_user($connection) {
    //$connection = connect_to_mysql();
    $email = filter_input(INPUT_POST, "user_email", FILTER_VALIDATE_EMAIL);
    $user_exists = is_already_user($email, $connection);
        if (!$user_exists){
    $pass = filter_input(INPUT_POST, "user_password", FILTER_SANITIZE_STRING);
    $password = md5($pass);
    $query = "INSERT INTO users (email, password)
                    VALUES ('$email', '$password')";

    if (!mysqli_query($connection, $query)) {
        echo "<br><br><br>failed";
        die('Error: ' . mysqli_error($connection));
    }
    echo "1 record added";

    $first_name = filter_input(INPUT_POST, "first_name", FILTER_SANITIZE_STRING);
    if($first_name){
          $sql = "UPDATE users SET ";
            $sql .= "first_name=";
            $sql .= " '$first_name' ";
            $sql .= "WHERE email = '$email'";
            if (mysqli_query($connection, $sql)) {
                echo "Record updated successfully";
            }
            else {
                echo "Error updating record: " . mysqli_error($connection);
            }
    }
    $last_name = filter_input(INPUT_POST, "last_name", FILTER_SANITIZE_STRING);
    if($last_name){
          $sql = "UPDATE users SET ";
            $sql .= "last_name=";
            $sql .= " '$last_name' ";
            $sql .= "WHERE email = '$email'";
            if (mysqli_query($connection, $sql)) {
                echo "Record updated successfully";
            }
            else {
                echo "Error updating record: " . mysqli_error($connection);
            }
    }
    $phone_number = filter_input(INPUT_POST, "phone_number", FILTER_VALIDATE_INT);
    if($phone_number){
          $sql = "UPDATE users SET ";
            $sql .= "phone_number=";
            $sql .= " '$phone_number' ";
            $sql .= "WHERE email = '$email'";
            if (mysqli_query($connection, $sql)) {
                echo "Record updated successfully";
            }
            else {
                echo "Error updating record: " . mysqli_error($connection);
            }
    }
    $admin = filter_input(INPUT_POST, "admin", FILTER_VALIDATE_INT);
    echo $admin;
    if($admin){
          $sql = "UPDATE users SET ";
            $sql .= "admin=";
            $sql .= " '$admin' ";
            $sql .= "WHERE email = '$email'";
            if (mysqli_query($connection, $sql)) {
                echo "Record updated successfully";
            }
            else {
                echo "Error updating record: " . mysqli_error($connection);
            }
    }

    mysqli_close($connection);
} else {echo 'failed';
    mysqli_close($connection);
}
}
/*
 * @param mysql_result $connection connection to database
 * @param string $email email to be checked
 * @var string $query input for sql database
 * @return mysql_result $result user
 */
//checks to see if sign-up email is already in database
function is_already_user($email, $connection){
    $user_email = filter_input(INPUT_POST, "user_email", FILTER_VALIDATE_EMAIL);
    $query = "SELECT email";
    $query .= "FROM users ";
    $query .= "WHERE email=";
    $query .= "' . $user_email . '";
    $result = mysqli_query($connection, $query);
    if ($result){
        return TRUE;
    } else {FALSE;}
}
/*
 * @param mysql_result $connection connection to database
 * @var string $user_email_provided email for login
 * @var string $password_provided password for login
 * @return mysql_result $result user
 */
//signs user in
function user_sign_in($connection){
    $user_email_provided = filter_input(INPUT_POST, "user_email", FILTER_VALIDATE_EMAIL);
    $password_provided = md5(filter_input(INPUT_POST, "user_password", FILTER_SANITIZE_STRING));

    $query = "SELECT *";
    $query .="FROM users ";
    $query .="WHERE email=";
    $query .="'$user_email_provided'";
    $result = mysqli_query($connection, $query);
    if($result){
        $row = mysqli_fetch_array($result);
        if ($row['password'] == $password_provided){
            return $row;
        } else {return FALSE;}
    }
}

/*
 * @var string $table sql table to output from
 * @var string $password_provided password for login
 * @return mysql_result $result listings
 */
//shows database entries for editing
function display_table(){
            //$db_host = 'sfsuswe.com';
            //$db_user = 'f14g02';
            //$db_pwd = 'dreamteam12';
            //$database = 'student_f14g02';
            $table = 'listings';

            if (!mysql_connect(DB_Server, DB_login, DB_password)){
                die("Can't connect to database");
            }
            if (!mysql_select_db(DB_name)){
                die("Can't select database");
            }

            // sending query
            $result = mysql_query("SELECT * FROM {$table}");
            if (!$result) {
                die("Query to show fields from table failed");
            }

            $fields_num = mysql_num_fields($result);

            //echo "<h1>Table: {$table}</h1>";
            echo "<table border='1'><tr>";
            // printing table headers
            $field = mysql_fetch_field($result);
                echo "<td><b>{$field->name}</b></td>";
            $field = mysql_fetch_field($result);
            for($i=0; $i<$fields_num-11; $i++)
            {
                $field = mysql_fetch_field($result);
                echo "<td><b>{$field->name}\t</b></td>";
            }
            echo "</tr>\n";
            // printing table rows
            while($row = mysql_fetch_row($result))
            {
                echo "<tr>";

                // $row is array... foreach( .. ) puts every element
                // of $row to $cell variable
                $i = 0;
                foreach($row as $cell){
                    if ($i == 0){
                        $listingID = $cell;
                    }
                    if ($i == 1){
                        $cell;
                    }
                    else if ($i > 10){
                        break;
                    }
                    else{
                        echo "<td>$cell</td>";
                    }
                    $i++;
                }
                // delete button with value of listingID;
                echo "<td>
                <form name='deleteID' action='destroy_listing.php' method='POST'>
                    <input type='hidden' name='listingID' value='$listingID'/>
                    <input type='submit' name='deleteID' value='Delete'/>
                </form>
                </td>";
                echo "<td>
                <form name='assignRealtor' action='assign_realtor.php' method='POST'>
                    Realtor name: <input type='text' name='rname'><br>
                    <input type='hidden' name='listingID' value='$listingID'/>
                    <input type='submit' name='assignRealtor' value='Assign Realtor'/>
                </form>
                </td>";
                echo "</tr>\n";
                }

			echo "</table>";
            mysql_free_result($result);
}

/*
 * @param mysql_result $connection connection to database
 * @var string $listingID id of listing to assign
 * @var string $sql sql query to delte listing
 */
//deltes listing
function destroy_listing ($connection){
    // acquires field from form and delete from query
    // value from function not transfering to $listingID
    $listingID = filter_input(INPUT_POST, "listingID",FILTER_VALIDATE_INT);
    $sql = "DELETE FROM listings WHERE id = $listingID";

    if (mysqli_query($connection, $sql)) {
        echo "Record deleted successfully";
    } else {
        echo "Error deleting record: " . mysqli_error($connection);
    }
    mysqli_close($connection);
}

/*
 * @param mysql_result $connection connection to database
 * @var string $listingID id of listing to assign
 * @var string $realtor_name name of realtor user assigned
 * @var string $sql0 sql query to check if realtor exists
 * @var string $sql1 sql query to assign realtor
 */
//assigns realtor to listing
function assign_realtor ($connection){
    // acquires field from form and delete from query
    // value from function not transfering to $listingID
    $listingID = filter_input(INPUT_POST, "listingID",FILTER_VALIDATE_INT);
    $realtorName = filter_input(INPUT_POST, "rname",FILTER_SANITIZE_STRING);
    $sql0 = "SELECT * FROM users WHERE first_name='$realtorName'";

    if ($result = mysqli_query($connection, $sql0)) {
        if($result->num_rows > 0){
            echo "User exists";
            $result = mysqli_query($connection, $sql0);
            $obj=mysqli_fetch_object($result);
            if($obj->admin == 1){
                $r_id = $obj->id;
                $sql1 = "UPDATE listings SET realtor = $r_id WHERE id = $listingID";

                if (mysqli_query($connection, $sql1)) {
                    echo "Realtor assigned successfully";
                } else {
                    echo "Error assigning realtor: " . mysqli_error($connection);
                }
            }
            else{
                echo "User is not realtor" ;
            }
        }
        else{
            echo "User does not exist";
        }
    } else {
        echo "Error finding realtor: " . mysqli_error($connection);
    }

    mysqli_close($connection);
}

/*
 * @param mysql_result $connection connection to database
 * @var string $listingID id for looking up which entry to edit
 * @var string $description column value to edit for entry
 * @var string $address column value to edit for entry
 * @var int $bed column value to edit for entry
 * @var int $zip_code column value to edit for entry
 * @var string $city column value to edit for entry
 * @var string $us_state column value to edit for entry
 * @var int $walk column value to edit for entry
 * @var int $bath column value to edit for entry
 * @var int $ft column value to edit for entry
 * @var int $price column value to edit for entry
 * @var int $num_garages column value to edit for entry
 */
//edits datbase listing
function edit_listing ($connection){
    // acquires field from form and delete from query
    // value from function not transfering to $listingID
    $listingID = filter_input(INPUT_POST, "listingID", FILTER_VALIDATE_INT);

    $description = filter_input(INPUT_POST, "description", FILTER_SANITIZE_STRING);
        if ($description) {
            $sql = "UPDATE listings SET ";
            $sql .= "description=";
            $sql .= " '$description' ";
            $sql .= "WHERE id = $listingID";
            if (mysqli_query($connection, $sql)) {
                echo "Record updated successfully";
            }
            else {
                echo "Error updating record: " . mysqli_error($connection);
            }
        }

    $address = filter_input(INPUT_POST, "address", FILTER_SANITIZE_STRING);
        if ($address) {
            $sql = "UPDATE listings SET ";
            $sql .= "address=";
            $sql .= " '$address' ";
            $sql .= "WHERE id = $listingID";
            if (mysqli_query($connection, $sql)) {
                echo "Record updated successfully";
            }
            else {
                echo "Error updating record: " . mysqli_error($connection);
            }
        }
    $bed = filter_input(INPUT_POST, "num_bedrooms", FILTER_VALIDATE_INT);
        if ($bed) {
            $sql = "UPDATE listings SET ";
            $sql .= "num_bedrooms=";
            $sql .= " '$bed' ";
            $sql .= "WHERE id = $listingID";
            if (mysqli_query($connection, $sql)) {
                echo "Record updated successfully";
            }
            else {
                echo "Error updating record: " . mysqli_error($connection);
            }
        }
    $zip_code = filter_input(INPUT_POST, "zip_code", FILTER_VALIDATE_INT);
        if ($zip_code) {
            $sql = "UPDATE listings SET ";
            $sql .= "zip_code=";
            $sql .= " '$zip_code' ";
            $sql .= "WHERE id = $listingID";
            if (mysqli_query($connection, $sql)) {
                echo "Record updated successfully";
            }
            else {
                echo "Error updating record: " . mysqli_error($connection);
            }
        }
    $city = filter_input(INPUT_POST, "city", FILTER_SANITIZE_STRING);
        if ($city) {
            $sql = "UPDATE listings SET ";
            $sql .= "city=";
            $sql .= " '$city' ";
            $sql .= "WHERE id = $listingID";
            if (mysqli_query($connection, $sql)) {
                echo "Record updated successfully";
            }
            else {
                echo "Error updating record: " . mysqli_error($connection);
            }
        }
    $us_state = filter_input(INPUT_POST, "us_state", FILTER_SANITIZE_STRING);
        if ($us_state) {
            $sql = "UPDATE listings SET ";
            $sql .= "us_state=";
            $sql .= " '$us_state' ";
            $sql .= "WHERE id = $listingID";
            if (mysqli_query($connection, $sql)) {
                echo "Record updated successfully";
            }
            else {
                echo "Error updating record: " . mysqli_error($connection);
            }
        }
    $walk = filter_input(INPUT_POST, "walkscore", FILTER_VALIDATE_INT);
        if ($walk) {
            $sql = "UPDATE listings SET ";
            $sql .= "walkscore=";
            $sql .= " '$walk' ";
            $sql .= "WHERE id = $listingID";
            if (mysqli_query($connection, $sql)) {
                echo "Record updated successfully";
            }
            else {
                echo "Error updating record: " . mysqli_error($connection);
            }
        }
    $bath = filter_input(INPUT_POST, "num_bathrooms", FILTER_VALIDATE_INT);
        if ($bath) {
            $sql = "UPDATE listings SET ";
            $sql .= "num_bathrooms=";
            $sql .= " '$bath' ";
            $sql .= "WHERE id = $listingID";
            if (mysqli_query($connection, $sql)) {
                echo "Record updated successfully";
            }
            else {
                echo "Error updating record: " . mysqli_error($connection);
            }
        }
        $ft = filter_input(INPUT_POST, "sq_ft", FILTER_VALIDATE_INT);
        if ($ft) {
            $sql = "UPDATE listings SET ";
            $sql .= "sq_ft=";
            $sql .= " '$ft' ";
            $sql .= "WHERE id = $listingID";
            if (mysqli_query($connection, $sql)) {
                echo "Record updated successfully";
            }
            else {
                echo "Error updating record: " . mysqli_error($connection);
            }
        }
        $price = filter_input(INPUT_POST, "price", FILTER_VALIDATE_INT);
        if ($price) {
            $sql = "UPDATE listings SET ";
            $sql .= "price=";
            $sql .= " '$price' ";
            $sql .= "WHERE id = $listingID";
            if (mysqli_query($connection, $sql)) {
                echo "Record updated successfully";
            }
            else {
                echo "Error updating record: " . mysqli_error($connection);
            }
        }
        $num_garages= filter_input(INPUT_POST, "num_garages", FILTER_VALIDATE_INT);
        if ($num_garages) {
            $sql = "UPDATE listings SET ";
            $sql .= "num_garages=";
            $sql .= " '$num_garages' ";
            $sql .= "WHERE id = $listingID";
            if (mysqli_query($connection, $sql)) {
                echo "Record updated successfully";
            }
            else {
                echo "Error updating record: " . mysqli_error($connection);
            }
        }
    //echo $sql;
    mysqli_close($connection);
}

/*
 * @pram string $realtor_id id for logged in realtor user
 * @var string $table sql table to output from
 * @var string $password_provided password for login
 */
//shows database entries for editing belonging to realtor
function realtor_display_table($realtor_id){
            //$db_host = 'sfsuswe.com';
            //$db_user = 'f14g02';
            //$db_pwd = 'dreamteam12';
            //$database = 'student_f14g02';
            $table = 'listings';

            if (!mysql_connect(DB_Server, DB_login, DB_password))
                die("Can't connect to database");
            if (!mysql_select_db(DB_name))
                die("Can't select database");

            // sending query
            $result = mysql_query("SELECT * FROM {$table} WHERE realtor = '$realtor_id'");
            if (!$result) {
                die("Query to show fields from table failed");
            }

            $fields_num = mysql_num_fields($result);

            //echo "<h1>Table: {$table}</h1>";
            echo "<table border='1'><tr>";
            // printing table headers
            $field = mysql_fetch_field($result);
            for($i=0; $i<$fields_num-10; $i++)
            {
                $field = mysql_fetch_field($result);
                echo "<td><b>{$field->name}\t</b></td>";
            }
            echo "</tr>\n";
            // printing table rows

            while($row = mysql_fetch_row($result))
            {
                echo "<tr>";

                // $row is array... foreach( .. ) puts every element
                // of $row to $cell variable
                $i = 0;

                foreach($row as $cell){

                   if ($i == 0){
                        $listingID = $cell;
                    }
                   // if ($i == 1){
                      // $cell;
                    //}
                    elseif ($i > 10){
                        break;
                    }
                    else{
                        $tmp = mysql_fetch_field($result,$i);
                        $edit_field = $tmp->name;
                        echo
                         "<td>
                             <form name='Edit2' action='edit_listing.php' method='POST'>
                             <input type='text' name='$edit_field' value='$cell' ><br>
                             <input type='hidden' name='listingID' value='$listingID'/>
                             <input type='submit' name='edit' value='Edit'/>
                    </form>
                    </td>";


                    }
                    $i++;

                }
                 /*echo "<td>
                     <form name='Edit' action='edit_listing.php' method='POST'>
                 <input type='hidden' name='listingID' value='$listingID'/>
                 <input type='submit' name='deleteID' value='Edit'/>
                </form>
                </td>";*/

                // delete button with value of listingID;
                echo "<td>
                <form name='deleteID' action='destroy_listing.php' method='POST'>
                    <input type='hidden' name='listingID' value='$listingID'/>
                    <input type='submit' name='deleteID' value='Delete'/>
                </form>
                </td>";

                echo "</tr>\n";
                }

			echo "</table>";
            mysql_free_result($result);
     }

?>
