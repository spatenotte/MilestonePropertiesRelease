<html lang="en">
<?php require 'navbar.php'; ?>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Listings Page</title>
        <style>
            .breadcrumb{
                background: none;
                text-align: left;
            }

            .top-container{
                margin-top: 60px;
                background-color:#e5e5e5;
                border-radius: 10px;

            }
            .bottom-container{
                margin-top: 20px;
                padding: 2%;
                background-color:#e5e5e5;
                border-radius: 10px;
            }
            .navbar-brand, .nav{
                font-family: 'Helvetica Neue', serif;
                font-weight: lighter;
            }
            .property-listing{
                border-radius:4px;
            }
            .transbox{
                border-radius: 4px;
                -webkit-box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2), 0 1px 0px rgba(0, 0, 0, 0.1);
                box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2), 0 1px 0px rgba(0, 0, 0, 0.1);
			}
			h4 { text-align: center;}
        </style>
    </head>
    <body>



        <div class="container top-container transbox">
            <div class="row">
                <div class="col-sm-3">
                    <ol class="breadcrumb text-left">
                        <li><a href="index.php">Home</a></li>
                        <li class="active">Listings: <?php if (!(isset($_POST["usersearch"]))) {
    echo '';
} else {
    echo $_POST["usersearch"];
} ?></li>
                    </ol>
                </div>
                <div class="col-sm-6 text-center">
                    <h2 style="font-family: 'Helvetica Neue', serif;
                        font-weight: lighter; padding: 15px;">Milestone Property Home Listings</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 col-xs-12">
                    <div class="quick-search">
                        <div class="row">
                            <form action="listing.php" method="post">
                                <div class="col-md-2 col-sm-2">
                                    <div class="form-group">
                                        <label for="bedroom">Search Homes:</label>
                                        <input name="usersearch" type="text" class="form-control" placeholder="<?php echo $_POST["usersearch"] ?>" value = "<?php echo isset($_POST["usersearch"]) ? $_POST["usersearch"] : '' ?>">
                                    </div>
                                </div>
                                <div class="col-md-2 col-sm-2">
                                    <div class="form-group">
                                        <label for="minprice">Min Price:</label>
                                        <input class="form-control" type="text" name="minprice" value = "<?php echo isset($_POST["minprice"]) ? $_POST["minprice"] : '' ?>" placeholder="min price">
                                    </div>
                                </div>
                                                             <div class="col-md-2 col-sm-2">
                                    <div class="form-group">
                                        <label for="maxprice">Max Price:</label>
                                        <input class="form-control" type="text" name="maxprice" value = "<?php echo isset($_POST["maxprice"]) ? $_POST["maxprice"] : '' ?>" placeholder="max price">
                                    </div>

                                </div>
                                <div class="col-md-2 col-sm-2">
                                   <div class="form-group">
                                        <label for="bedroom"> Min Bedroom:</label>
                                        <input class="form-control" type="text" name="min_bedroom" value = "<?php echo isset($_POST["min_bedroom"]) ? $_POST["min_bedroom"] : '' ?>" placeholder="min bedrooms">
                                    </div>
                                </div>
                                <div class="col-md-2 col-sm-2">
                                    <div class="form-group">
                                        <label for="status">Min Walkscore:</label>
                                        <input class="form-control" type="text" name="min_walkscore" value = "<?php echo isset($_POST["min_walkscore"]) ? $_POST["min_walkscore"] : '' ?>" placeholder="min walkscore">
                                    </div>
                                </div>
                                <!-- break -->
                                <div class="col-md-2 col-sm-2">
                                    <div class="form-group">
                                        <label for="maxprice">&nbsp;</label>
                                        <input type="submit" name="submit" value="Filter" class="btn btn-primary btn-block">
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<?php
$connection = connect_to_mysql();
$result = milestone_search_with_filters($connection);
?>
        <div class="container-full bottom-container" style="background-color:#e8e8e8">
            <div class="container container-pad" id="property-listings">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <h2 style="font-family: 'Helvetica Neue', serif;
                            font-weight: lighter; ">Showing <?php echo number_of_listings($result); ?> Results for:<br> <?php echo '"';
                if (!(isset($_POST["usersearch"]))) {
                    echo '';
                } else {
                    echo $_POST["usersearch"];
                } echo '"'; ?> </h2>
                        <br>
                        <br>
                    </div>
                </div>
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
?>
            </div>
        </div>


        <div class="footer" style="background-color: #e7e7e7; border-color: #777; width: 100%; position: fixed;bottom: 0">
            <h4>This is for demonstration purposes only. CSC648/848 San Francisco State University Team02 Milestone Properties</h4>
        </div>

        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    </body>
</html>
