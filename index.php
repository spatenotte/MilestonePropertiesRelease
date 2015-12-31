<html lang="en">
<?php require 'navbar.php'; ?>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Milestone Properties</title>
        <style>

            h1{
                font-family: 'Helvetica Neue', serif;
                font-weight: lighter;
                font-size: 52px;

            }
            #index{
                padding-top:50px;
                background: url('assets/bg_images/bg2.jpg');
                /*                height: 300px;*/
                width: 62%;
                border-radius: 10px;
                /*            width: 73%;*/
            }
            .row{
                padding: 1%;
            }
            .welcome{
                font-family: 'Helvetica Neue', serif;
                font-weight: lighter;
                color: white;
                font-size: 52px;

            }
            .welcome-paragraph{
                font-family: 'Helvetica Neue', serif;
                font-weight: lighter;
                color: white;
            }
            .navbar-brand, .nav{
                font-family: 'Helvetica Neue', serif;
                font-weight: lighter;

            }
            .transbox{
                background:rgba(0, 0, 0, .5);
                padding: 4%;
                border-radius: 10px;
                box-shadow: 1px 7px 36px -5px;
            }
            .bottom-container{

                padding: 1%;
                border-radius: 10px;
                margin-bottom: 70px;
            }
            h4 { text-align: center;}
        </style>
    </head>
    <body>

        <div class="container" id="index">
            <div class="row">
                <div class="col-sm-3"></div>
                <div class="col-sm-6 text-center">
                    <div class="transbox">
                        <h2 class="welcome">Hello Milestone Properties</h2>
                        <h3 class="welcome-paragraph text-center">Find your dream home today</h3>
                        <br>
                        <form action="listing.php" method="post">
                            <div class="input-group input-group-md">
                                <input name="usersearch" type="text" class="center-block form-control input-md" title="Enter search query" placeholder="Enter state, city, or zip code...">
                                <span class="input-group-btn"><button class="btn btn-md btn-primary" type="submit">Search Homes</button></span>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-sm-3"></div>
            </div>
        </div>

        <div class="container-full bottom-container">
            <div class="container container-pad" id="property-listings">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="text-center">Milestone Property Featured Homes</h1>
                        <br>

                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 col-sm-6 col-md-6">
                        <?php
                        $connection = connect_to_mysql();
                        $results = featured_properties($connection, 2);
                        if ($results != "") {
                            $row = mysqli_fetch_array($results);
                        } else {
                            echo "<br><br><br><h2>Must enter valid input</h2>";
                            die();
                        }
                        ?>
                        <div class="brdr bgc-fff pad-10 box-shad btm-mrg-20 property-listing" style="overflow:hidden;">
                            <div class="media">
                                <a class="media-left" href="home_details.php?details=<?php echo $row["id"] ?>" target="_parent">
                                    <?php
                                    $rand_num = rand(1, 1);
                                    $img_name1 = $row["image" . $rand_num];
                                    $img_path = 'assets/home_images/home' . $row["id"] . '/small/' . $img_name1;
                                    ?>
                                    <img class="img-responsive" style="margin-top:9%;" src="<?php echo '' . $img_path . ''; ?>"/>
                                    <span class="fnt-smaller fnt-lighter fnt-arial">Milestone Properties&copy</span>
                                </a>
                                <div class="media-body fnt-smaller">
                                    <h3 class="media-heading">
                                        $<?php echo '' . number_format($row["price"]) . '<small class="pull-right"><i>' . $row["address"] . ''; ?></i></small></h3>
                                    <p><small class="pull-right"><?php echo '' . $row["city"] . ", " . $row["us_state"] . ", " . $row["zip_code"] . ''; ?></small></p>

                                    <br>
                                    <ul class="list-inline mrg-0 btm-mrg-10 pull-right">
                                        <li><?php echo '' . $row["sq_ft"] . ''; ?> SqFt</li>

                                        <li style="list-style: none">|</li>

                                        <li><?php echo '' . $row["num_bedrooms"] . ''; ?> Beds</li>

                                        <li style="list-style: none">|</li>

                                        <li><?php echo '' . $row["num_bathrooms"] . ''; ?> Baths</li>
                                    </ul>
                                    <br><br>
                                    <p><?php echo '' . substr($row["description"], 0, 120) . ''; ?>...</p>
                                </div>
                                <div class="row">
                                    <div  class="btn-group btn-group-justified" role="group" aria-label="...">
                                        <div class="btn-group" role="group">
                                            <form action="home_details.php" method="post">
                                                <button name="bookmark" type="submit" value="<?php echo $row["id"] ?>" class="btn btn-default btn-sm">
                                                    <span class="glyphicon glyphicon-star" aria-hidden="true"></span> Bookmark
                                                </button>
                                            </form>
                                        </div>
                                        <div class="btn-group" role="group">
                                            <form action="contact_realtor.php" method="post">
                                                <button name="idListing" type="submit" value="<?php echo $row["id"] ?>" class="btn btn-default btn-sm">
                                                    <span class="glyphicon glyphicon-envelope" aria-hidden="true"></span> Contact realtor
                                                </button>
                                            </form>
                                        </div>
                                        <div class="btn-group" role="group">
                                            <form action="home_details.php" method="get">
                                                <button name="details" type="submit" value="<?php echo '' . $row[0] . ''; ?>" class="btn btn-success btn-sm">Details</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                        close_mysql_connection($connection);
                        ?>
                    </div>
                    <div class="col-sm-12 col-sm-6 col-md-6">
                        <?php
                        //$connection = connect_to_mysql();
                        //$results = featured_properties($connection); //no longer necessary
                        if ($results != "") {
                            $row = mysqli_fetch_array($results);
                        } else {
                            echo "<br><br><br><h2>Must enter valid input</h2>";
                            die();
                        }
                        ?>
                        <div class="brdr bgc-fff pad-10 box-shad btm-mrg-20 property-listing" style="overflow:hidden;">
                            <div class="media">
                                <a class="media-left" href="home_details.php?details=<?php echo $row["id"] ?>" target="_parent">
                                    <?php
                                    $rand_num = rand(1, 1);
                                    $img_name1 = $row["image" . $rand_num];
                                    $img_path = 'assets/home_images/home' . $row["id"] . '/small/' . $img_name1;
                                    ?>
                                    <img class="img-responsive" style="margin-top:9%;" src="<?php echo '' . $img_path . ''; ?>"/>
                                    <span class="fnt-smaller fnt-lighter fnt-arial">Milestone Properties&copy</span>
                                </a>
                                <div class="media-body fnt-smaller">
                                    <h3 class="media-heading">
                                        $<?php echo '' . number_format($row["price"]) . '<small class="pull-right"><i>' . $row["address"] . ''; ?></i></small></h3>
                                    <p><small class="pull-right"><?php echo '' . $row["city"] . ", " . $row["us_state"] . ", " . $row["zip_code"] . ''; ?></small></p>

                                    <br>
                                    <ul class="list-inline mrg-0 btm-mrg-10 pull-right">
                                        <li><?php echo '' . $row["sq_ft"] . ''; ?> SqFt</li>

                                        <li style="list-style: none">|</li>

                                        <li><?php echo '' . $row["num_bedrooms"] . ''; ?> Beds</li>

                                        <li style="list-style: none">|</li>

                                        <li><?php echo '' . $row["num_bathrooms"] . ''; ?> Baths</li>
                                    </ul>
                                    <br><br>
                                    <p><?php echo '' . substr($row["description"], 0, 120) . ''; ?>...</p>
                                </div>
                                <div class="row">
                                    <div  class="btn-group btn-group-justified" role="group" aria-label="...">
                                        <div class="btn-group" role="group">
                                            <form action="home_details.php" method="post">
                                                <button name="bookmark" type="submit" value="<?php echo $row["id"] ?>" class="btn btn-default btn-sm">
                                                    <span class="glyphicon glyphicon-star" aria-hidden="true"></span> Bookmark
                                                </button>
                                            </form>
                                        </div>
                                        <div class="btn-group" role="group">
                                            <form action="contact_realtor.php" method="post">
                                                <button name="idListing" type="submit" value="<?php echo $row["id"] ?>" class="btn btn-default btn-sm">
                                                    <span class="glyphicon glyphicon-envelope" aria-hidden="true"></span> Contact realtor
                                                </button>
                                            </form>
                                        </div>
                                        <div class="btn-group" role="group">
                                            <form action="home_details.php" method="get">
                                                <button name="details" type="submit" value="<?php echo '' . $row[0] . ''; ?>" class="btn btn-success btn-sm">Details</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    //close_mysql_connection($connection);
                    ?>

                </div>
            </div>
        </div>

        <div class="footer" style="background-color: #e7e7e7; border-color: #777; width: 100%; position: fixed;bottom: 0">
            <h4>This is for demonstration purposes only. CSC648/848 San Francisco State University Team02 Milestone Properties</h4>
        </div>


    </body>
</html>
