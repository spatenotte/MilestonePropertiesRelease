
<?php require 'navbar.php'; ?>
<?php if($_SESSION['admin']!= 1) {
               echo "<br><br>Unauthorized Access";
               exit();
            }
            ?>
<html lang="en">
    <head>
        <title>Realtor Profile</title>
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
        </style>
    </head>
    <body>
        <?php
            static $row;
            $row = get_user_data();
        ?>
          <div class="container text-center top-container">
                <h1>Welcome <?php show_info("first_name")?> </h1>
            </div>

        <div class="container transbox">

            <div class="input-group input-group-sm col-sm-offset-4 col-sm-4">
                <b>First Name:</b> <?php show_info("first_name")?> <br>
                <b>Last Name:</b> <?php show_info("last_name")?> <br>
                <b>Phone number:</b> <?php show_info("phone_number")?> <br>
            </div><br>
        </div>

        <div class="container top-container transbox">
            <div class="container text-center">
                 <a href="new_listing.php"> Create A Listing</a>
            </div><br>
            <div class="container text-center">
                 <a href="realtor_database.php"> Edit Listings</a>
            </div> <br>
            <div class="container text-center">
                 <a href="contactUsers.php"> User Messages</a>
            </div>
        </div>

       <br></div>
        <div class="container text-center top-container">
            <h>My Listings</h> <br>
         <?php
        error_reporting(E_ALL & ~E_NOTICE);
        $connection = connect_to_mysql();
        $result = get_realtor_listings($connection);
        ?>
        </div>

        <div class="container-full bottom-container" style="background-color:#e8e8e8">
            <div class="container container-pad" id="property-listings">
                                        <?php
                                    if ($result != "") {
                                        while ($row = mysqli_fetch_array($result)) {
                                            ?>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="brdr bgc-fff pad-10 box-shad btm-mrg-20 property-listing" style="overflow:hidden;">
                                    <div class="media">
                                        <a class="pull-left" href="home_details.php?details=<?php echo $row["id"] ?>" target="_parent">
        <?php
        $rand_num = rand(1, 1);
        $img_name1 = $row["image" . $rand_num];
        $img_path = 'assets/home_images/home' . $row["id"] . '/small/' . $img_name1;
        ?>
                                            <img class="img-responsive" style="margin-top:9%;" src="<?php echo '' . $img_path . ''; ?>"/>
                                            <span class="fnt-smaller fnt-lighter fnt-arial">Milestone Properties&copy</span>
                                        </a>

                                        <div class="clearfix visible-sm"></div>

                                        <div class="media-body fnt-smaller">
                                            <a href="#" target="_parent"></a>

                                            <h3 class="media-heading">
                                                <a href="#" target="_parent">$<?php echo '' . number_format($row["price"]) . '</a><small class="pull-right"><i>' . $row["address"] . ''; ?></i></small></h3>
                                            <p><small class="pull-right"><?php echo '' . $row["city"] . ", " . $row["us_state"] . ", " . $row["zip_code"] . ''; ?></small></p>

                                            <br>
                                            <ul class="list-inline mrg-0 btm-mrg-10 clr-535353 pull-right">
                                                <li><?php echo '' . $row["sq_ft"] . ''; ?> SqFt</li>

                                                <li style="list-style: none">|</li>

                                                <li><?php echo '' . $row["num_bedrooms"] . ''; ?> Beds</li>

                                                <li style="list-style: none">|</li>

                                                <li><?php echo '' . $row["num_bathrooms"] . ''; ?> Baths</li>
                                            </ul>
                                            <br><br>
                                            <p class="hidden-xs"><?php echo '' . substr($row["description"], 0, 120) . ''; ?>...</p>
                                            <div class="row">
                                                <div class="col-md-4">
											<form action="home_details.php" method="post">
                                                <button name="bookmark" type="submit" value="<?php echo $row["id"] ?>" class="btn btn-default btn-xs">
                                                    <span class="glyphicon glyphicon-star" aria-hidden="true"></span> Bookmark
                                                </button>
                                            </form>
										</div>
                                        <div class="col-md-5">
                                            <form action="contact_realtor.php" method="post">
                                                <button name="idListing" type="submit" value="<?php echo $row["id"] ?>" class="btn btn-default btn-xs">
                                                    <span class="glyphicon glyphicon-envelope" aria-hidden="true"></span> Contact realtor
                                                </button>
                                            </form>
                                        </div>
                                        <div class="col-md-3">
                                            <form action="home_details.php" method="get">
                                                <button name="details" type="submit" value="<?php echo '' . $row[0] . ''; ?>" class="btn btn-success btn-xs"><i class="fa fa-search"></i>Details</button>
                                            </form>
                                        </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>
                            <div class="col-sm-6">

        <?php if ($row = mysqli_fetch_array($result)) { ?>
                                    <div class="brdr bgc-fff pad-10 box-shad btm-mrg-20 property-listing" style="overflow:hidden;">
                                        <div class="media">
                                            <a class="pull-left" href="home_details.php?details=<?php echo $row["id"] ?>" target="_parent">
            <?php

            $rand_num = rand(1, 1);
            $img_name1 = $row["image" . $rand_num];
            $img_path = 'assets/home_images/home' . $row["id"] . '/small/' . $img_name1;
            ?>
                                                <img class="img-responsive" style="margin-top:9%;" src="<?php echo '' . $img_path . ''; ?>"/>
                                                <span class="fnt-smaller fnt-lighter fnt-arial">Milestone Properties&copy</span>
                                            </a>

                                            <div class="clearfix visible-sm"></div>

                                            <div class="media-body fnt-smaller">
                                                <a href="#" target="_parent"></a>

                                                <h3 class="media-heading">
                                                    <a href="#" target="_parent">$<?php echo '' . number_format($row["price"]) . '</a><small class="pull-right"><i>' . $row["address"] . ''; ?></i></small></h3>
                                                <p><small class="pull-right"><?php echo '' . $row["city"] . ", " . $row["us_state"] . ", " . $row["zip_code"] . ''; ?></small></p>

                                                <br>
                                                <ul class="list-inline mrg-0 btm-mrg-10 clr-535353 pull-right">
                                                    <li><?php echo '' . $row["sq_ft"] . ''; ?> SqFt</li>

                                                    <li style="list-style: none">|</li>

                                                    <li><?php echo '' . $row["num_bedrooms"] . ''; ?> Beds</li>

                                                    <li style="list-style: none">|</li>

                                                    <li><?php echo '' . $row["num_bathrooms"] . ''; ?> Baths</li>
                                                </ul>
                                                <br><br>
                                                <p class="hidden-xs"><?php echo '' . substr($row["description"], 0, 120) . ''; ?>...</p>
                                                <div class="row">
                                                    <div class="col-md-4">
											<form action="home_details.php" method="post">
                                                <button name="bookmark" type="submit" value="<?php echo $row["id"] ?>" class="btn btn-default btn-xs">
                                                    <span class="glyphicon glyphicon-star" aria-hidden="true"></span> Bookmark
                                                </button>
                                            </form>
										</div>
                                        <div class="col-md-5">
                                            <form action="contact_realtor.php" method="post">
                                                <button name="idListing" type="submit" value="<?php echo $row["id"] ?>" class="btn btn-default btn-xs">
                                                    <span class="glyphicon glyphicon-envelope" aria-hidden="true"></span> Contact realtor
                                                </button>
                                            </form>
                                        </div>
                                        <div class="col-md-3">
                                            <form action="home_details.php" method="get">
                                                <button name="details" type="submit" value="<?php echo '' . $row[0] . ''; ?>" class="btn btn-success btn-xs"><i class="fa fa-search"></i>Details</button>
                                            </form>
                                        </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
        <?php
        }
    }
    mysqli_free_result($result);
} else {
    echo "<h1></h1>";
}
?></div></div>
    </body>
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


    ?>
