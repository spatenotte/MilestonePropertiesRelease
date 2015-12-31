<html lang="en">
<?php require 'navbar.php'; ?>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Sell Home</title>
        <style>
            .breadcrumb{
                background: none;
                text-align: left;
            }
            .navbar-brand, .nav{
                font-family: 'Helvetica Neue', serif;
                font-weight: lighter;

            }

            body{padding-top:0%;}
            .top-container{
                margin-top: 70px;
/*                background-color:#e5e5e5;*/
                border-radius: 10px; 
                
            }
            .transbox{
                background:rgba(0, 0, 0, .07);
                border-radius: 10px; 
                box-shadow: 1px 7px 36px -5px;
				margin-bottom:50px;
            }
            input {
                display: inline;
                float: right;
			}
			h4 { text-align: center;}
        </style>
    </head>
    <body>                        
                        <?php if (isset($_SESSION['id'])){
                            
                            echo '<div class="container top-container transbox" id="sellhome">
            <div class="row">
                <div class="col-md-5 col-md-offset-4">
                    <h1 style="           
                font-family: "Helvetica Neue", serif;
                font-weight: lighter;">Sell Your Home Today</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <form action="new_listing_created.php" method="post" enctype="multipart/form-data">
                        State:      <input type="text" name="us_state" value="" /><br />
                        <br />
                        City:       <input type="text" name="city" value="" /><br />
                        <br />
                        Address:    <input type="text" name="address" value="" /><br />
                        <br />
                        Zip Code:   <input type="text" name="zip_code" value="" /><br />
                        <br />
                        Price:      <input type="text" name="price" value="" /><br />
                        <br />
                        Square Feet:<input type="text" name="sq_ft" value="" /><br />
                        <br />
                        Bedrooms:   <input type="text" name="num_bedrooms" value="" /><br />
                        <br />
                        Bathrooms:  <input type="text" name="num_bathrooms" value="" /><br />
                        <br />
                        Garages:    <input type="text" name="num_garages" value="" /><br />
                        <br />
                        Description:<input type="text" name="description" value="" /><br />                    
                        <br />       
                        <input type="file" name="image1" id="image1">
                        <br>
                        <input type="file" name="image2" id="image2">
                        <br>
                        <input type="file" name="image3" id="image3">
                        <br>
                        <h4>Check our terms and conditions <a href="#termsModal" data-toggle="modal" data-target="#termsModal" data-dismiss="modal">here</a></h4>
                        <br />

                            <input type="submit" name="submit" value="Sell My Home!" />
                            <br />
                    </form>
                </div>
                
              
        </div>
            
        </div>';
                        } else {
                            echo '<br>';
                            echo '<br>';
                            echo '<br>';
                            echo '<h3 class="text-center">You must be logged in to submit a listing!</h3>';
                        }
                            ?>
                        <br />
                    </form>
                </div>
                
              
        </div>
            
        </div>
            
		<div class="footer" style="background-color: #e7e7e7; border-color: #777; width: 100%; position: fixed;bottom: 0">
			<h4>This is for demonstration purposes only. CSC648/848 San Francisco State University Team02 Milestone Properties</h4>
        </div>
		

    </body>
</html>
<?php
    function bookmark_listing() {
        $connection = connect_to_mysql();
        if (isset($_SESSION['id'])){
        $query = "INSERT into bookmarks (user_id, listing_id) VALUES(";
        $query .= $_SESSION['id'] . "," . $_POST['bookmark'] . ")";
        mysqli_query($connection, $query);
        echo "<script type='text/javascript'>alert('Listing added to bookmarks');</script>";
        } else {
            echo "<script type='text/javascript'>alert('You must be logged in to bookmark a property!');</script>";
        }
    }
?>

<?php
    function new_listing() {
        
    }
?>