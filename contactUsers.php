<html lang="en">
<?php require 'navbar.php'; ?>
    <?php if($_SESSION['admin']!= 2 && $_SESSION['admin']!= 1 ) {
               echo "<br><br>Unauthorized Access";
               exit();
            }
            ?>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style>
            .bgc-fff{
                background-color: #f8f8f8;
            }
            #footer{
                display: inline;
                padding: 50px;
            }
            h1{
                font-family: 'Helvetica Neue', serif;
                font-weight: lighter;
                font-size: 52px;

            }
            #index{
                padding-top:50px;
                background: url('assets/bg_images/bg2.jpg');
/*                height: 300px;*/
                width: 66%;
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
                box-shadow: 1px 7px 36px -5px
            }
            .bottom-container{

                padding: 1%;
                border-radius: 10px;
            }

            body { padding-top: 70px; }
			h4 {text-align: center;}
        </style>
        <title>Contact requests</title>
    </head>

    <body>
        <h1 align="center"> Contact request: </h1>

        <?php
        if(isset($_POST['idRow'])) {
            remove_row();
        }
        ?>

        <table class="table table-hover">
            <tr>
                <th>User name</th>
                <th>User email</th>
                <th>User phone number</th>
                <th>Message</th>
                <th>Listing location</th>
                <th>Action</th>
            </tr>
            <?php print contact_requests() ?>
        </table>

        <div class="footer" style="background-color: #e7e7e7; border-color: #777; width: 100%; position: fixed;bottom: 0">
            <h4>This is for demonstration purposes only. CSC648/848 San Francisco State University Team02 Milestone Properties</h4>
        </div>

        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
        <script src="js/jquery.js"></script>
        <script src="js/script.js"></script>
    </body>
</html>

<?php
    function contact_requests() {
        $connection = connect_to_mysql();
        $query = "SELECT * FROM touched";

        $result = mysqli_query($connection, $query);
        $row;

        $max = mysqli_num_rows($result);
        for ($i = 0; $i < $max; $i++) {
            mysqli_data_seek($result, $i);
            $row = mysqli_fetch_array($result);

            echo "<tr>\n";
            echo "<td> ". $row['name'] . "</td>\n";
            echo "<td> ". $row['email'] . " </td>\n";
            echo "<td> ". $row['phone'] . " </td>\n";
            echo "<td> ". $row['message'] . " </td>\n";
            echo "<td> <a href=\"home_details.php?details=" . $row['idListing'] . "\">Visit listing</a></td>\n";
            echo "<td>";
            echo "<form action=\"" . $_SERVER['PHP_SELF'] . "\" method=\"post\">";
            echo "<button name=\"idRow\" type=\"submit\" value=\"" . $row['id'] . "\">Remove contact request</button>";
            echo "</form>";
            echo "</td>\n";
            echo "</tr>";
        }

        close_mysql_connection($connection);
    }

    function remove_row() {
        $connection = connect_to_mysql();
        $query = "DELETE FROM touched WHERE id = '" . $_POST['idRow'] . "'";
        mysqli_query($connection, $query);

        echo "<script type='text/javascript'>alert('Contact request deleted!');</script>";
    }
?>
