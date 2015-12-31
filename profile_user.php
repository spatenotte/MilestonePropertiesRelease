<html lang="en">
<?php require 'navbar.php'; ?>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>User Profile</title>
        <style>
            .breadcrumb{
                background: none;
                text-align: left;
            }
            .navbar-brand, .nav{
                font-family: 'Helvetica Neue', serif;
                font-weight: lighter;            }
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
            body { padding-bottom: 50px; }
            h4 {text-align: center;}
        </style>
    </head>
    <body>
        <?php
            if(!isset($_SESSION['email'])) {
                header("Location: index.php");
                exit();
            }

            run_scripts_body();

            static $row;
            $row = get_user_data();
        ?>

        <div class="container top-container transbox">
            <div class="container text-center">
                <h1><?php show_info("first_name")?>'s Profile</h1>
            </div>
            <div class="input-group input-group-sm col-sm-offset-4 col-sm-4">
                <b>Email:</b> <?php show_info("email")?> <br>
                <b>Password:</b> *********<br>
                <a href="change_password.php"> Change Password</a><br>
            </div><br>
        </div>

        <div class="container top-container transbox">
            <div class="container text-center">
                <h1>Contact Information</h1> <a href="edit_user.php"> Edit</a>
            </div>
           <div class="input-group input-group-sm col-sm-offset-4 col-sm-4">
                <b>First Name:</b> <?php show_info("first_name")?> <br>
                <b>Last Name:</b> <?php show_info("last_name")?> <br>
                <b>Phone number:</b> <?php show_info("phone_number")?> <br>
           </div>
       <br></div>

		<div class="container top-container transbox">
            <div class="container text-center">
                <h1>Bookmarks</h1>
            </div>
            <?php get_bookmarks() ?>
       <br></div>

    </body>

	<div class="footer" style="background-color: #e7e7e7; border-color: #777; width: 100%; position: fixed;bottom: 0">
		<h4>This is for demonstration purposes only. CSC648/848 San Francisco State University Team02 Milestone Properties</h4>
	</div>

	<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
	<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
	<script src="js/jquery.js"></script>
	<script src="js/script.js"></script>
</html>

<?php
    function get_user_data() {
        $connection = connect_to_mysql();
        $query = "SELECT * FROM users WHERE email = '";
        $query .= $_SESSION["email"] . "'";

        $result = mysqli_query($connection, $query);
        $row = mysqli_fetch_array($result);

        if($row != false) {
            close_mysql_connection($connection);
            return $row;
        }
    }

    function show_info($fieldName) {
        echo $GLOBALS['row'][$fieldName];
    }

    function get_bookmarks() {
        $connection = connect_to_mysql();
        $query = "SELECT * FROM bookmarks WHERE user_id = '";
        $query .= $_SESSION["id"] . "'";

        $result = mysqli_query($connection, $query);
        if(mysqli_num_rows($result)==0) {
            echo "<h4 text-align: center>No bookmarks!</h4>";
            return;
        }
        $row;

        $max = mysqli_num_rows($result);
        for ($i = 0; $i < $max; $i++) {
            mysqli_data_seek($result, $i);
            $row = mysqli_fetch_array($result);
            display_listing($row['listing_id']);
        }
    }

    function display_listing($id) {
        $connection = connect_to_mysql();
        $query = "SELECT * ";
        $query .="FROM listings ";
        $query .="WHERE id ='" . $id . "'";

        $result = mysqli_query($connection, $query);
        $row = mysqli_fetch_array($result);

        echo '<div class="row">
            <div class="container transbox">
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
                                    <p class="hidden-xs">' . substr($row["description"], 0, 300) . '...</p>
                                    <div class="btn-toolbar pull-right">
                                        <form action="home_details.php" method="get">
                                            <button type="button" class="btn btn-default btn-sm">
                                                <span class="glyphicon glyphicon-star" aria-hidden="true"></span> Star
                                            </button>
                                            <button name="details" type="submit" value="' . $row[0] . '" class="btn btn-success btn-sm">Details</button>

                                        </form>

                                    </div>
                                    <br>
                                    <span class="fnt-smaller fnt-lighter fnt-arial">Milestone Properties&copy</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><hr>';
    }
?>
